<?php

namespace App\Http\Controllers\Subadmin\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SubAdmin;
use App\Models\User;

class DataController extends Controller
{
  public function users(Request $request)
  {
    $data = User::select('users.id', 'users.name', 'users.email', 'users.created_at')
      ->where('users.created_by', $request->user()->id)
      ->get();

    return response()->json(['data' => $data], 200);
  }
}
