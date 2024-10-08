<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DocumentController;

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
})->name('home');

Route::get('/', [HomeController::class, 'home'])->name('home');

Route::resource('attendences', AttendanceController::class);


Route::group(['prefix'=>'reports'], function(){
    Route::get('/latest', [ReportController::class, 'latest'])->name('reports.latest');
});


Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::resource('permissions', PermissionController::class);
    Route::resource('employees', EmployeeController::class);
    Route::resource('documents', DocumentController::class);
    Route::get('/workdays', [EmployeeController::class, 'we'])->name('employees.we');
    Route::get('/oldemployees', [EmployeeController::class, 'old'])->name('employees.old');
    Route::post('/employees/restore/{employee}', [EmployeeController::class, 'restore'])->name('employees.restore');
    Route::delete('/employees/fdelete/{employee}', [EmployeeController::class, 'fdelete'])->name('employees.fdelete');

    Route::group(['prefix'=>'reports'], function(){
        Route::get('/daily', [ReportController::class, 'daily'])->name('reports.daily');
        Route::get('/weekly', [ReportController::class, 'weekly'])->name('reports.weekly');
        Route::get('/thisWeek', [ReportController::class, 'thisWeek'])->name('reports.thisWeek');
        Route::get('/lastWeek', [ReportController::class, 'lastWeek'])->name('reports.lastWeek');
        Route::get('/monthly', [ReportController::class, 'monthly'])->name('reports.monthly');
        Route::get('/yearly', [ReportController::class, 'yearly'])->name('reports.yearly');
        Route::get('/range', [ReportController::class, 'range'])->name('reports.range');
        Route::get('/present', [ReportController::class, 'present'])->name('reports.present');
        Route::get('/dailyscan', [ReportController::class, 'dailyscan'])->name('reports.dailyscan');
    });

    // Route::controller(ReportController::class)->group(function () {
    //     Route::get('/orders/{id}', 'daily')->name('reports.daily');
    // });
});

require __DIR__.'/auth.php';
