<?php

namespace App\Http\Controllers\Subadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

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
    return view('sub-admin.users.create');
  }
  // Store a newly created resource in storage
  public function store(Request $request)
  {
    // dd($request->all());
    // Validate and store the data
    $validatedData = $request->validate([
      'name' => 'required|string|max:255',
      'email' => 'required|string|email|max:255|unique:users',
      'password' => 'required|string|min:8',
    ]);

    // dd($validatedData);

    // Create the sub-admin
    $subAdmin = new User();
    $subAdmin->name = $validatedData['name'];
    $subAdmin->email = $validatedData['email'];
    $subAdmin->password = bcrypt($validatedData['password']);
    $subAdmin->save();

    // dd($subAdmin);

    return redirect()->route('subadmins.users.index')->with('success', 'Sub Admin created successfully.');
  }

  // Show the form for editing the specified resource
  public function edit($id)
  {
    $subAdmin = User::findOrFail($id);
    return view('sub-admin.users.edit', compact('subAdmin'));
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
    $subAdmin = User::findOrFail($id);
    $subAdmin->name = $validatedData['name'];
    $subAdmin->email = $validatedData['email'];
    if ($request->filled('password')) {
      $subAdmin->password = bcrypt($validatedData['password']);
    }
    $subAdmin->save();

    return redirect()->route('subadmin.users.index')->with('success', 'Sub-admin updated successfully.');
  }

  // Remove the specified resource from storage
  public function destroy($id)
  {
    $subAdmin = User::findOrFail($id);
    $subAdmin->delete();

    return redirect()->route('subadmin.users.index')->with('success', 'Sub-admin deleted successfully.');
  }
}
