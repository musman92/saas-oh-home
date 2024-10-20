<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Superuser\PlanController;


Route::group(['namespace' => 'Superuser', 'prefix' => 'superuser', 'as' => 'superuser.'], function () {

  Route::get('/', function (){
    return redirect()->route('admin.auth.login');
  });

  /*authentication*/
  Route::group(['namespace' => 'Auth', 'prefix' => 'auth', 'as' => 'auth.'], function () {
    Route::get('/code/captcha/{tmp}', 'LoginController@captcha')->name('default-captcha');
    Route::get('login', 'LoginController@login')->name('login');
    Route::post('login', 'LoginController@submit');
    Route::get('logout', 'LoginController@logout')->name('logout');
  });

  Route::group(['middleware' => ['superuser']], function () {
    Route::get('/', 'DashboardController@dashboard')->name('dashboard');//previous dashboard route
    

    /**
     * Plan Routes
     */
    Route::get('/plans', [PlanController::class, 'index'])->name('plans.index');
    Route::get('/plans/create', [PlanController::class, 'create'])->name('plans.create');
    Route::post('/plans', [PlanController::class, 'store'])->name('plans.store');
    
    Route::get('/payment', function () {
      return view('super-user.plan.payment');
    })->name('payment.view');
    
    Route::post('/create-plan', [PlanController::class, 'createPlan'])->name('create.plan');
    Route::post('/charge', [PlanController::class, 'charge'])->name('charge');
  });
});
