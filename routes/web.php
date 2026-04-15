<?php

use App\Http\Controllers\AbsenController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\ActivityHistoryController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardManagementController;
use App\Http\Controllers\DashboardOperatorController;
use App\Http\Controllers\EndUserController;
use App\Http\Controllers\EndUserDepartmentController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProfileNewController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TaskPersonalController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Route::get('/test-email', function () {

//     Mail::to('b-fajar@intra.tifico.co.id')->send(new NotifCreate());
// });


Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return view('auth.login');
});

Route::get('/dashboard', function () {
    if (Auth::user()->role === 'OPERATOR') {
        return redirect()->route('dashboard_operator.index');
    } elseif (Auth::user()->role === 'MANAGEMENT') {
        return redirect()->route('dashboard_management.index');
    } elseif (Auth::user()->role === 'ADMIN') {
        return redirect()->route('dashboard_management.index');
    }
})->middleware(['auth', 'verified'])->name('dashboard');


Route::group(['middleware' => ['auth', 'verified', 'active.session']], function () {
    Route::resource('/category', CategoryController::class)->names('category');
    Route::resource('/activity', ActivityController::class)->names('activity');
    Route::resource('/location', LocationController::class)->names('location');
    Route::resource('/enduser', EndUserController::class)->names('enduser');
    Route::resource('/enduser-department', EndUserDepartmentController::class)->names('enduser_department');
    Route::resource('/task/personal', TaskPersonalController::class)->names('task_personal');
    Route::get('/task-{id}', [TaskController::class, 'getTask'])->name('task.get');

    Route::get('/dashboard/operator', [DashboardOperatorController::class, 'index'])->name('dashboard_operator.index');
    Route::post('/dashboard_operator/take/{id}', [DashboardOperatorController::class, 'takeActivity'])->name('dashboard_operator.take');
    Route::put('/dashboard_operator/complete/{id}', [DashboardOperatorController::class, 'completeActivity'])->name('dashboard_operator.complete');
    Route::get('/activity/active/{id}', [DashboardOperatorController::class, 'idle'])->name('dashboard_operator.idle');
    Route::get('/active_task/{id}', [DashboardOperatorController::class, 'takeTask'])->name('active_task.index');
    Route::get('/task/active/{id}', [DashboardOperatorController::class, 'idleTask'])->name('dashboard_operator.idle_task');
    Route::put('/task/update/{id}', [DashboardOperatorController::class, 'updateTask'])->name('dashboard_operator.update_task');
    Route::get('/profile/edit/{id}', [ProfileNewController::class, 'edit'])->name('profileNew.edit');
    Route::put('/profile/update', [ProfileNewController::class, 'update'])->name('profileNew.update');
    Route::get('/export-activity', [ActivityController::class, 'export']);
    Route::get('/activity_history', [ActivityHistoryController::class, 'index'])->name('activity_history.index');
    Route::get('/absen', [AbsenController::class, 'index'])->name('absen.index');
    Route::get('/absen/create', [AbsenController::class, 'create'])->name('absen.create');
    Route::post('/absen', [AbsenController::class, 'store'])->name('absen.store');
    Route::get('/absen/edit/{id}', [AbsenController::class, 'edit'])->name('absen.edit');
    Route::put('/absen/update/{id}', [AbsenController::class, 'update'])->name('absen.update');
    Route::delete('/absen/{id}', [AbsenController::class, 'destroy'])->name('absen.destroy');
});

Route::group(['middleware' => ['auth', 'verified', 'role:MANAGEMENT,ADMIN']], function () {
    Route::get('/dashboard/management', [DashboardManagementController::class, 'index'])->name('dashboard_management.index');
    Route::get('/user-inactive', [UserController::class, 'inactive'])->name('user.inactive');
    Route::put('/user/{id}/restore', [UserController::class, 'restore'])->name('user.restore');
    Route::resource('/user', UserController::class)->names('user');

    Route::get('/activity_history/{id}', [ActivityHistoryController::class, 'show'])->name('activity_history.show');
    Route::get('/activity_history/list/{id}', [ActivityHistoryController::class, 'list'])->name('activity_history.list');
    Route::get('/activity_history/list/{id}/filter', [ActivityHistoryController::class, 'listFilter'])->name('activity_history.list.filter');
    Route::resource('/task/department', TaskController::class)->names('task');
    Route::put('/task/{id}/complete', [TaskController::class, 'complete'])->name('task.complete');
    Route::get('/export-task-department', [TaskController::class, 'export'])->name('task.export');
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
