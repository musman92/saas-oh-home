<?php

namespace App\Http\Controllers\Subadmin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\SubAdmin;

class LoginController extends Controller
{
  public function __construct()
  {
    $this->middleware('guest:subadmin', ['except' => ['logout']]);
  }

  public function login()
  {
    return view('sub-admin.auth.login');
  }

  public function submit(Request $request)
  {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required|min:6'
    ]);

    $admin = SubAdmin::where('email', $request->email)->first();
    if (!isset($admin)) {
      return redirect()->back()->withInput($request->only('email', 'remember'))
          ->withErrors(['Email does not exist.']);
    } else {
      if (auth('subadmin')->attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
        return redirect()->route('subadmin.dashboard');
      }
    }

    return redirect()->back()->withInput($request->only('email', 'remember'))
        ->withErrors(['Credentials does not match.']);
  }

  public function logout(Request $request)
  {
    auth()->guard('subadmin')->logout();
    $request->session()->invalidate();
    return redirect()->route('subadmin.auth.login');
  }
}
