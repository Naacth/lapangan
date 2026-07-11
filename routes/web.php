<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Web\BookingController;
use App\Http\Controllers\Web\Admin\DashboardController;
use App\Http\Controllers\Web\Admin\FieldController as AdminFieldController;
use App\Http\Controllers\Web\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Web\Admin\ReportController as AdminReportController;

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/fields/{id}', [HomeController::class, 'field'])->name('fields.show');
Route::get('/fields/{id}/availability', [HomeController::class, 'checkAvailability'])->name('fields.availability');

// Auth Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Customer Routes (requires login)
Route::middleware(['auth', 'customer'])->group(function () {
    Route::get('/book/{field_id}', [BookingController::class, 'create'])->name('bookings.create');
    Route::post('/book', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('/bookings', [BookingController::class, 'history'])->name('bookings.history');
    Route::get('/bookings/{id}/upload', [BookingController::class, 'showUpload'])->name('bookings.upload');
    Route::post('/bookings/{id}/upload', [BookingController::class, 'upload'])->name('bookings.upload.post');
    Route::post('/bookings/{id}/cancel', [BookingController::class, 'cancel'])->name('bookings.cancel');
});

// Admin Routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Fields CRUD
    Route::get('/fields', [AdminFieldController::class, 'index'])->name('fields.index');
    Route::get('/fields/create', [AdminFieldController::class, 'create'])->name('fields.create');
    Route::post('/fields', [AdminFieldController::class, 'store'])->name('fields.store');
    Route::get('/fields/{id}/edit', [AdminFieldController::class, 'edit'])->name('fields.edit');
    Route::put('/fields/{id}', [AdminFieldController::class, 'update'])->name('fields.update');
    Route::delete('/fields/{id}', [AdminFieldController::class, 'destroy'])->name('fields.destroy');

    // Bookings Management
    Route::get('/bookings', [AdminBookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/{id}', [AdminBookingController::class, 'show'])->name('bookings.show');
    Route::post('/bookings/{id}/status', [AdminBookingController::class, 'updateStatus'])->name('bookings.status');

    // Reports
    Route::get('/reports', [AdminReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/export/csv', [AdminReportController::class, 'exportCsv'])->name('reports.export.csv');
    Route::get('/reports/export/pdf', [AdminReportController::class, 'exportPdf'])->name('reports.export.pdf');
});
