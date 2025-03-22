<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// ✅ Protected Dashboard
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// ✅ Email Verification Notice Page
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

// ✅ Handle email verification from email link
Route::get('/verify-email/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill(); // marks user as verified
    return redirect('/dashboard'); // or wherever you want to go after verifying
})->middleware(['auth', 'signed'])->name('verification.verify');

// ✅ Resend verification email
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('status', 'verification-link-sent');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

// ✅ Profile routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ✅ Test route (for debugging only)
Route::get('/test-verify', function () {
    if (Auth::check()) {
        return Auth::user()->hasVerifiedEmail() ? '✅ Verified' : '❌ Not Verified';
    }
    return '🛑 Not Logged In';
})->middleware('auth');

require __DIR__.'/auth.php';
