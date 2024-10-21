<?php

namespace App\Http\Controllers\Subadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Permission;

class UserController extends Controller
{
  // create resource functions
  public function index()
  {
    $users = User::paginate(10);
    return view('sub-admin.users.index', compact('users'));
  }

  // create resource functions
  public function create()
  {
    $permissions = Permission::all();
    return view('sub-admin.users.create', compact('permissions'));
  }
  // Store a newly created resource in storage
  public function store(Request $request)
  {
    // Validate and store the data
    $validatedData = $request->validate([
      'name' => 'required|string|max:255',
      'email' => 'required|string|email|max:255|unique:users',
      'password' => 'required|string|min:8',
    ]);

    // Create the sub-admin
    $user = new User();
    $user->name = $validatedData['name'];
    $user->email = $validatedData['email'];
    $user->password = bcrypt($validatedData['password']);
    $user->created_by = auth()->guard('subadmin')->user()->id;
    $user->save();

    // Assign permissions
    if ($request->filled('permissions')) {
      $user->syncPermissions($request->permissions);
    }
    return redirect()->route('subadmin.users.index')->with('success', 'User created successfully.');
  }

  // Show the form for editing the specified resource
  public function edit($id)
  {
    $user = User::findOrFail($id);
    $permissions = Permission::all();
    $userPermissions = $user->permissions->pluck('id')->toArray();
    return view('sub-admin.users.edit', compact('user', 'permissions', 'userPermissions'));
  }

  // Update the specified resource in storage
  public function update(Request $request, $id)
  {
    // Validate and update the data
    $validatedData = $request->validate([
      'name' => 'required|string|max:255',
      'email' => 'required|string|email|max:255|unique:users,email,' . $id,
      'password' => 'nullable|string|min:8|confirmed',
    ]);

    // Update the sub-admin
    $user = User::findOrFail($id);
    $user->name = $validatedData['name'];
    $user->email = $validatedData['email'];
    if ($request->filled('password')) {
      $user->password = bcrypt($validatedData['password']);
    }
    $user->save();

    // Assign permissions
    if (count($request->permissions)) {
      $user->syncPermissions($request->permissions);
    } else {
      $user->syncPermissions([]);
    }

    return redirect()->route('subadmin.users.index')->with('success', 'User updated successfully.');
  }

  // Remove the specified resource from storage
  public function destroy($id)
  {
    $user = User::findOrFail($id);
    $user->delete();

    return redirect()->route('subadmin.users.index')->with('success', 'User deleted successfully.');
  }
}
