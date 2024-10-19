<?php

use Illuminate\Support\Facades\Route;

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
    
  });
});
