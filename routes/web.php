<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\LockerController;
use App\Http\Controllers\LockerReservationController;
use App\Http\Controllers\ProfileController;

// ✅ Home Page
Route::get('/', function () {
    return view('welcome');
});

// ✅ Dashboard Page (Locker List)
Route::get('/dashboard', [LockerController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// ✅ Reserve Locker (POST)
Route::post('/lockers/{locker}/reserve', [LockerReservationController::class, 'reserve'])
    ->middleware(['auth', 'verified'])
    ->name('lockers.reserve');

// ✅ Cancel Reservation (DELETE)
Route::delete('/lockers/{locker}/cancel', [LockerReservationController::class, 'cancel'])
    ->middleware(['auth', 'verified'])
    ->name('lockers.cancel');

    Route::patch('/lockers/{locker}/extend', [LockerReservationController::class, 'extend'])
    ->middleware(['auth', 'verified'])
    ->name('lockers.extend');


// ✅ Loyalty Reward Page
Route::get('/loyalty-reward', function () {
    return view('loyalty');
})->middleware(['auth', 'verified'])->name('loyalty');

// ✅ Contact Center Page
Route::get('/contact-center', function () {
    return view('contact');
})->middleware(['auth', 'verified'])->name('contact');

// ✅ Email Verification Notice
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

// ✅ Email Link Verification (handles auto-logout)
Route::get('/verify-email/{id}/{hash}', VerifyEmailController::class)
    ->middleware(['auth', 'signed'])
    ->name('verification.verify');

// ✅ Resend Email Verification
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('status', 'verification-link-sent');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

// ✅ Profile Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::patch('/profile/photo', [ProfileController::class, 'updatePhoto'])->name('profile.update.photo');
});

// ✅ Test Auth Check (Optional)
Route::get('/test-verify', function () {
    if (Auth::check()) {
        return Auth::user()->hasVerifiedEmail() ? '✅ Verified' : '❌ Not Verified';
    }
    return '🛑 Not Logged In';
})->middleware('auth');

// ✅ Include Auth Routes (Login, Register, etc.)
require __DIR__.'/auth.php';
