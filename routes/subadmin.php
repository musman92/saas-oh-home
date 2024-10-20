<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Subadmin\PlanController;
use App\Http\Controllers\Subadmin\UserController;
use App\Http\Controllers\Subadmin\SubscriptionController;

Route::group(['namespace' => 'Subadmin', 'prefix' => 'subadmin', 'as' => 'subadmin.'], function () {

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

  Route::group(['middleware' => ['subadmin']], function () {
    Route::get('/', 'DashboardController@dashboard')->name('dashboard');//previous dashboard route
    
    /**
     * Plan Routes
     */
    Route::get('/plans', [PlanController::class, 'index'])->name('plans.index');
    Route::get('/plans/create', [PlanController::class, 'create'])->name('plans.create');
    Route::post('/plans', [PlanController::class, 'store'])->name('plans.store');
    
    
    /**
     * Subscription Routes
     */
    Route::get('/subscriptions', [SubscriptionController::class, 'index'])->name('subs.index');
    Route::get('/subscriptions/{plan}', [SubscriptionController::class, 'show'])->name('subs.show');
    Route::post('/subscriptions', [SubscriptionController::class, 'subscription'])->name('subs.create');

    /**
     * User Routes
     */
    Route::resource('users', UserController::class);

  });
});
