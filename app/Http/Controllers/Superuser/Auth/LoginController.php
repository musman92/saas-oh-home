<?php

namespace App\Http\Controllers\Superuser\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\SuperUser;

class LoginController extends Controller
{
  public function __construct()
  {
    $this->middleware('guest:superuser', ['except' => ['logout']]);
  }

  public function login()
  {
    return view('super-user.auth.login');
  }

  public function submit(Request $request)
  {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required|min:6'
    ]);

    $admin = SuperUser::where('email', $request->email)->first();
    if (isset($admin) && $admin->status != 1) {
        return redirect()->back()->withInput($request->only('email', 'remember'))
            ->withErrors(['You are blocked!!, contact with admin.']);
    }else{
        if (auth('superuser')->attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
            return redirect()->route('superuser.dashboard');
        }
    }

    return redirect()->back()->withInput($request->only('email', 'remember'))
        ->withErrors(['Credentials does not match.']);
  }

  public function logout(Request $request)
  {
    auth()->guard('superuser')->logout();
    $request->session()->invalidate();
    return redirect()->route('superuser.auth.login');
  }
}
