<?php

use App\Http\Controllers\LockerController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

// ✅ Dashboard (Protected)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// ✅ Loyalty Reward Page (Renamed route path)
Route::get('/loyalty-reward', function () {
    return view('loyalty');
})->middleware(['auth', 'verified'])->name('loyalty');

// ✅ Contact Center Page (Renamed route path)
Route::get('/contact-center', function () {
    return view('contact');
})->middleware(['auth', 'verified'])->name('contact');

// ✅ Email Verification Notice Page
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

// ✅ Handle Email Verification from Link
Route::get('/verify-email/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill(); // mark user as verified
    return redirect('/dashboard');
})->middleware(['auth', 'signed'])->name('verification.verify');

// ✅ Resend Email Verification Link
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('status', 'verification-link-sent');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::get('/dashboard', [LockerController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// ✅ Profile Routes (Protected)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ✅ Test Route (Optional)
Route::get('/test-verify', function () {
    if (Auth::check()) {
        return Auth::user()->hasVerifiedEmail() ? '✅ Verified' : '❌ Not Verified';
    }
    return '🛑 Not Logged In';
})->middleware('auth');

require __DIR__.'/auth.php';
