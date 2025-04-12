<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReportController;
use App\Models\Student;
use Illuminate\Http\Request;

Auth::routes();

Route::middleware(['auth'])->group(function () {
    // Dashboard Routes
    Route::get('/', [DashboardController::class, 'index']);
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Resource Routes
    Route::resources([
        'students' => StudentController::class,
        'sections' => SectionController::class,
        'courses' => CourseController::class,
        'attendance' => AttendanceController::class,
        'grades' => GradeController::class,
    ]);
    Route::get('/attendance/create/{sectionId}', [AttendanceController::class, 'getStudentsBySection']);

    Route::resource('reports', ReportController::class)->only(['index', 'performance', 'attendance', 'grades'])->middleware('auth');
    // Report Routes
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/', [ReportController::class, 'index'])->name('index');
        Route::get('/attendance', [ReportController::class, 'attendance'])->name('attendance');
        Route::get('/grades', [ReportController::class, 'grades'])->name('grades');
        Route::get('/export/attendance', [ReportController::class, 'exportAttendance'])->name('export.attendance');
        Route::get('/attendance/{id}/details', [ReportController::class, 'getAttendanceDetails'])->name('attendance.details');
        Route::get('/attendance/{id}/print', [ReportController::class, 'printAttendanceReport'])->name('attendance.print');
    });
});

Auth::routes();
