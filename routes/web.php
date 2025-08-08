<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::get('/', [AuthenticatedSessionController::class, 'create'])->name('login');


// Update dashboard route to use controller
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // User Management Routes
    Route::resource('users', UserController::class);

    // Student Routes
    Route::resource('students', StudentController::class);

    // Teacher Routes
    Route::resource('teachers', TeacherController::class);

    // Attendance Routes
    Route::resource('attendances', AttendanceController::class);

    // Grade Routes
    Route::resource('grades', GradeController::class);

    // Subject Routes
    Route::resource('subjects', SubjectController::class);

    // Classes
    Route::resource('classes', ClassController::class);

    // Schedule Routes
    Route::resource('schedules', ScheduleController::class);

    // New Route to get students for a schedule
    Route::get('/schedules/{schedule}/students', [ScheduleController::class, 'getStudents'])->name('schedules.students');

    Route::get('/schedules/{schedule}/students', [ScheduleController::class, 'getStudents'])->name('schedules.students');
    Route::get('/classes/{class}/students', [ClassController::class, 'getStudents'])->name('classes.students');

    // Report Routes
    Route::prefix('reports')->group(function () {
        Route::get('/', [ReportController::class, 'index'])->name('reports.index');
        Route::get('/export/excel', [ReportController::class, 'exportExcel'])->name('reports.export.excel');
        Route::get('/export/pdf', [ReportController::class, 'exportPdf'])->name('reports.export.pdf');
    });
});

require __DIR__ . '/auth.php';