<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TodoController;
use App\Http\Controllers\SubscriptionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    /**
     * Subscription Routes
     */
    Route::get('/subscriptions', [SubscriptionController::class, 'index'])->name('subs.index');
    Route::get('/subscriptions/{plan}', [SubscriptionController::class, 'show'])->name('subs.show');
    Route::post('/subscriptions', [SubscriptionController::class, 'subscription'])->name('subs.create');

    /**
     * TODOs Route
     */
    Route::group(['middleware' => ['permission', 'subscription.active']], function () {
        Route::resource('todos', TodoController::class);
    });
});

require __DIR__.'/auth.php';
