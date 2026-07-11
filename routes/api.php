<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\VenueController;
use App\Http\Controllers\FieldController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ReportController;

// Public Routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/venues', [VenueController::class, 'index']);
Route::get('/fields/{id}/availability', [FieldController::class, 'availability']);

// Protected Routes
Route::middleware('auth:sanctum')->group(function () {
    // Auth
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Customer Booking Routes
    Route::post('/bookings', [BookingController::class, 'store']);
    Route::get('/bookings/me', [BookingController::class, 'me']);
    Route::put('/bookings/{id}/cancel', [BookingController::class, 'cancel']);
    
    // Customer Payment Routes
    Route::post('/payments/{booking_id}/upload', [PaymentController::class, 'upload']);

    // Admin Routes
    Route::prefix('admin')->group(function () {
        Route::get('/bookings', [BookingController::class, 'index']);
        Route::put('/bookings/{id}/status', [BookingController::class, 'updateStatus']);
        
        Route::post('/fields', [FieldController::class, 'store']);
        Route::put('/fields/{id}', [FieldController::class, 'update']);
        
        Route::get('/reports', [ReportController::class, 'index']);
    });
});
