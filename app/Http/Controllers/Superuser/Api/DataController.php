<?php

namespace App\Http\Controllers\Superuser\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SubAdmin;
use App\Models\User;

class DataController extends Controller
{
  public function subadmins(Request $request)
  {
    $data = SubAdmin::select('id', 'name', 'email', 'created_at')->get();

    return response()->json(['data' => $data], 200);
  }
  public function subusers(Request $request)
  {
    $data = User::select('users.id', 'users.name', 'users.email', 'users.created_at', 'sub_admins.name as created_by_name')
      ->join('sub_admins', 'sub_admins.id', '=', 'users.created_by')
      ->get();

    return response()->json(['data' => $data], 200);
  }
}