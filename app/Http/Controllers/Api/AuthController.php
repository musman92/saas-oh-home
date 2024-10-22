<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
  public function login(Request $request)
  {
    $credentials = $request->only('email', 'password');

    $user = User::where('email', $request->email)->first();

    if ($user && Hash::check($request->password, $user->password)) {
        return $user->createToken('Sub Admin Token')->plainTextToken;
    }

    return response()->json(['error' => 'Unauthorized'], 401);
  }

  public function user(Request $request)
  {
    $user = $request->user();

    if ($user) {
      return response()->json([
        'id' => $user->id,
        'name' => $user->name,
        'email' => $user->email,
        'created_at' => $user->created_at,
      ]);
    }

    return response()->json(['error' => 'User not found'], 404);
  }
}