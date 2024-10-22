<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController as UserAuthController;
use App\Http\Controllers\Api\TodoController;

use App\Http\Controllers\Superuser\Api\AuthController as SuperuserAuthController;
use App\Http\Controllers\Superuser\Api\DataController as SuperuserDataController;

use App\Http\Controllers\Subadmin\Api\AuthController as SubadminAuthController;
use App\Http\Controllers\Subadmin\Api\DataController as SubadminDataController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group(['prefix' => 'superuser', 'as' => 'superuser.'], function () {
  Route::post('/login', [SuperuserAuthController::class, 'login'])->name('login');

  Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/user', [SuperuserAuthController::class, 'user'])->name('user');
    Route::get('/subadmins', [SuperuserDataController::class, 'subadmins'])->name('subadmins.list');
    Route::get('/subusers', [SuperuserDataController::class, 'subusers'])->name('subusers.list');
  });
});

Route::group(['prefix' => 'subadmin', 'as' => 'subadmin.'], function () {
  Route::post('/login', [SubadminAuthController::class, 'login'])->name('login');

  Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/user', [SubadminAuthController::class, 'user'])->name('user');

    Route::get('/users', [SubadminDataController::class, 'users'])->name('subusers.list');
  });
});

Route::group(['prefix' => 'user', 'as' => 'user.'], function () {
  Route::post('/login', [UserAuthController::class, 'login'])->name('login');

  Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/user', [UserAuthController::class, 'user'])->name('user');

    // crete todos api resources
    Route::group(['middleware' => ['permission', 'subscription.active']], function () {
      Route::apiResource('todos', TodoController::class);
    });
  });
});