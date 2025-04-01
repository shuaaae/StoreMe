<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\LockerController;
use App\Http\Controllers\LockerReservationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminAuthController;



// ✅ Home Page
Route::get('/', function () {
    return view('welcome');
});

// ✅ Dashboard Page (Locker List)
Route::get('/dashboard', [LockerController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// ✅ Locker Actions (for the user's reserved locker)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::patch('/lockers/{locker}', [LockerController::class, 'update'])->name('lockers.update'); // Update name
    Route::patch('/lockers/{locker}/color', [LockerController::class, 'updateColor'])->name('lockers.color'); // Change background color
});

// ✅ Reservation Actions
Route::middleware(['auth', 'verified'])->group(function () {
    Route::post('/lockers/{locker}/reserve', [LockerReservationController::class, 'reserve'])->name('lockers.reserve');
    Route::delete('/lockers/{locker}/cancel', [LockerReservationController::class, 'cancel'])->name('lockers.cancel');
});

Route::patch('/lockers/{locker}/extend', [LockerReservationController::class, 'extend'])
    ->middleware(['auth', 'verified'])
    ->name('lockers.extend');


// ✅ Static Pages
Route::get('/loyalty-reward', function () {
    return view('loyalty');
})->middleware(['auth', 'verified'])->name('loyalty');

Route::get('/contact-center', function () {
    return view('contact');
})->middleware(['auth', 'verified'])->name('contact');

// ✅ Email Verification
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/verify-email/{id}/{hash}', VerifyEmailController::class)
    ->middleware(['auth', 'signed'])
    ->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('status', 'verification-link-sent');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::post('/contact/help', [App\Http\Controllers\ContactController::class, 'submitHelp'])->name('contact.help');
Route::post('/contact/feedback', [App\Http\Controllers\ContactController::class, 'submitFeedback'])->name('contact.feedback');


// ✅ Profile Management
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::patch('/profile/photo', [ProfileController::class, 'updatePhoto'])->name('profile.update.photo');
});

// Admin Auth
Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

    Route::middleware('auth:admin')->group(function () {
        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('admin.dashboard');
    });
});




Route::patch('/lockers/{locker}/note', [LockerController::class, 'updateNote'])->name('lockers.note');


// ✅ Debug / Test Route
Route::get('/test-verify', function () {
    if (Auth::check()) {
        return Auth::user()->hasVerifiedEmail() ? '✅ Verified' : '❌ Not Verified';
    }
    return '🛑 Not Logged In';
})->middleware('auth');

// ✅ Auth (Login, Register, etc.)
require __DIR__ . '/auth.php';
