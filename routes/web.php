<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\ActivityHistoryController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\EndUserController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::group(['middleware' => ['auth', 'verified']], function () {
    Route::resource('/category', CategoryController::class)->names('category');
    Route::resource('/activity', ActivityController::class)->names('activity');
    Route::resource('/location', LocationController::class)->names('location');
    Route::resource('/enduser', EndUserController::class)->names('enduser');
    Route::resource('/user', UserController::class)->names('user');
    Route::resource('/task', TaskController::class)->names('task');
    Route::get('/activity_history', [ActivityHistoryController::class, 'index'])->name('activity_history.index');
    Route::get('/activity_history/{id}', [ActivityHistoryController::class, 'show'])->name('activity_history.show');
});

// Edit Activity History, Privilage only for Admin
Route::group(['middleware' => ['auth', 'verified', 'role:ADMIN']], function () {
    Route::get('/activity_history/{id}/edit', [ActivityHistoryController::class, 'edit'])->name('activity_history.edit');
    Route::put('/activity_history/{id}', [ActivityHistoryController::class, 'update'])->name('activity_history.update');
    Route::delete('/activity_history/{id}', [ActivityHistoryController::class, 'destroy'])->name('activity_history.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
