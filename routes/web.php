<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\KycController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\SettlementController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', function () {
    return view('welcome');
});

// Course browsing (public)
Route::get('/courses', [CourseController::class, 'browse'])->name('courses.browse');
Route::get('/courses/{course}', [CourseController::class, 'show'])->name('courses.show');

// Authenticated routes
Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // KYC Registration
    Route::get('/auth/kyc', [KycController::class, 'show'])->name('kyc.show');
    Route::post('/auth/kyc', [KycController::class, 'store'])->name('kyc.store');

    // Bookings
    Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/{booking}', [BookingController::class, 'show'])->name('bookings.show');
    Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
    Route::post('/bookings/{booking}/cancel', [BookingController::class, 'cancel'])->name('bookings.cancel');

    // Transactions
    Route::get('/transactions/{transaction}', [TransactionController::class, 'show'])->name('transactions.show');
    Route::post('/transactions', [TransactionController::class, 'store'])->name('transactions.store');
    Route::post('/transactions/{transaction}/refund', [TransactionController::class, 'refund'])->name('transactions.refund');

    // Settlements
    Route::get('/settlements', [SettlementController::class, 'index'])->name('settlements.index');
    Route::get('/settlements/{settlement}', [SettlementController::class, 'show'])->name('settlements.show');
    Route::post('/settlements/generate', [SettlementController::class, 'generate'])->name('settlements.generate');

    // Instructor routes
    Route::middleware('can:teach')->group(function () {
        Route::get('/courses/create', [CourseController::class, 'create'])->name('courses.create');
        Route::post('/courses', [CourseController::class, 'store'])->name('courses.store');
        Route::get('/courses/{course}/edit', [CourseController::class, 'edit'])->name('courses.edit');
        Route::put('/courses/{course}', [CourseController::class, 'update'])->name('courses.update');
        Route::delete('/courses/{course}', [CourseController::class, 'destroy'])->name('courses.destroy');
        Route::post('/courses/{course}/publish', [CourseController::class, 'publish'])->name('courses.publish');
    });

    // Admin routes
    Route::middleware('is-admin')->group(function () {
        Route::post('/settlements/{settlement}/approve', [SettlementController::class, 'approve'])->name('settlements.approve');
        Route::post('/settlements/{settlement}/reject', [SettlementController::class, 'reject'])->name('settlements.reject');
        Route::post('/settlements/{settlement}/pay', [SettlementController::class, 'pay'])->name('settlements.pay');
    });

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
