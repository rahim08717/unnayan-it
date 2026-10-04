<?php

use App\Http\Controllers\AssetCategoryController;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\DailyReportController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TicketCommentController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VendorController;
use Illuminate\Support\Facades\Route;

// Root Redirect to Login
Route::get('/', function () {
    return redirect()->route('login');
});

// Dashboard Route
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Authenticated Routes
Route::middleware('auth')->group(function () {

    // User Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Daily Working Reports Routes
    Route::get('/daily-reports', [DailyReportController::class, 'index'])->name('daily-reports.index');
    Route::get('/daily-reports/dashboard', [DailyReportController::class, 'index'])->name('daily-reports.dashboard');
    Route::get('/daily-reports/create', [DailyReportController::class, 'create'])->name('daily-reports.create');
    Route::post('/daily-reports', [DailyReportController::class, 'store'])->name('daily-reports.store');
    Route::get('/daily-reports/history', [DailyReportController::class, 'history'])->name('daily-reports.history');
    Route::get('/daily-reports/{id}', [DailyReportController::class, 'show'])->name('daily-reports.show');
    Route::get('/daily-reports/{id}/print', [DailyReportController::class, 'printPdf'])->name('daily-reports.print');
    Route::delete('/daily-reports/{id}', [DailyReportController::class, 'destroy'])->name('daily-reports.destroy');

    // General Authorized Routes
    Route::resource('assets', AssetController::class);
    Route::resource('tickets', TicketController::class);
    Route::post('tickets/{ticket}/comments', [TicketCommentController::class, 'store'])->name('tickets.comments.store');

    // Protected Admin Routes
    Route::middleware('admin')->group(function () {
        Route::resource('branches', BranchController::class);
        Route::resource('categories', AssetCategoryController::class);
        Route::resource('employees', EmployeeController::class);
        Route::resource('vendors', VendorController::class);
        Route::resource('users', UserController::class);

        // Management Reports
        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('/reports/assets', [ReportController::class, 'assetReport'])->name('reports.assets');
        Route::get('/reports/tickets', [ReportController::class, 'ticketReport'])->name('reports.tickets');
        Route::get('/reports/export-assets', [ReportController::class, 'exportAssets'])->name('reports.export-assets');
    });
});

require __DIR__.'/auth.php';