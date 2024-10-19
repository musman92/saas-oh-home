<?php

namespace App\Http\Controllers\Subadmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;

class DashboardController extends Controller
{
  public function dashboard()
  {

    return view('sub-admin.dashboard');
  }
}
