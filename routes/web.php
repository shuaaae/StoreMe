<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\LockerController;
use App\Http\Controllers\LockerReservationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminLockerController;
use App\Http\Controllers\LoyaltyController;


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
    Route::patch('/lockers/{locker}', [LockerController::class, 'update'])->name('lockers.update');
    Route::patch('/lockers/{locker}/name', [LockerController::class, 'updateName'])->name('lockers.updateName');
    Route::patch('/lockers/{locker}/color', [LockerController::class, 'updateColor'])->name('lockers.color');
    Route::patch('/lockers/{locker}/extend', [LockerController::class, 'extend'])->name('lockers.extend');
    Route::patch('/lockers/{locker}/note', [LockerController::class, 'updateNote'])->name('lockers.note');

    // Reservation
    Route::post('/lockers/{locker}/reserve', [LockerController::class, 'reserve'])->name('lockers.reserve');
    Route::delete('/lockers/{locker}/cancel', [LockerReservationController::class, 'cancel'])->name('lockers.cancel');
});

// ✅ Static Pages
Route::get('/loyalty-reward', [LoyaltyController::class, 'showLoyaltyPage'])->middleware(['auth', 'verified'])->name('loyalty');
Route::get('/contact-center', fn () => view('contact'))->middleware(['auth', 'verified'])->name('contact');

// ✅ Email Verification
Route::get('/email/verify', fn () => view('auth.verify-email'))->middleware('auth')->name('verification.notice');
Route::get('/verify-email/{id}/{hash}', VerifyEmailController::class)->middleware(['auth', 'signed'])->name('verification.verify');
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('status', 'verification-link-sent');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

// ✅ Contact Forms
Route::post('/contact/help', [App\Http\Controllers\ContactController::class, 'submitHelp'])->name('contact.help');
Route::post('/contact/feedback', [App\Http\Controllers\ContactController::class, 'submitFeedback'])->name('contact.feedback');

// ✅ Profile Management
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::patch('/profile/photo', [ProfileController::class, 'updatePhoto'])->name('profile.update.photo');
});


Route::patch('/profile/photo/delete', [ProfileController::class, 'deletePhoto'])
    ->middleware(['auth'])
    ->name('profile.delete.photo');


// ✅ Admin Routes
Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

    Route::middleware('auth:admin')->group(function () {
        Route::get('/dashboard', [AdminLockerController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/lockers/{locker}', [AdminLockerController::class, 'show'])->name('admin.lockers.show');
        Route::post('/lockers/{locker}/pause', [AdminLockerController::class, 'pause']);
        Route::post('/lockers/{locker}/resume', [AdminLockerController::class, 'resume']);
        Route::post('/lockers/{locker}/reset', [AdminLockerController::class, 'reset']);
        Route::post('/lockers/{locker}/approve', [AdminLockerController::class, 'approve'])->name('admin.lockers.approve'); // ✅ fixed
        Route::post('/lockers/{locker}/end', [AdminLockerController::class, 'endReservation']);
        Route::patch('/lockers/{locker}/pay', [AdminLockerController::class, 'markAsPaid'])->name('admin.lockers.pay');
        Route::get('/admin/reservations', [AdminLockerController::class, 'reservationHistory'])->name('admin.reservations');
        Route::get('/admin/lockers/{locker}', [AdminLockerController::class, 'show']);
        Route::get('/reservations/export-pdf', [AdminLockerController::class, 'exportPDF'])->name('admin.reservations.export.pdf');

    });    
});
Route::middleware(['auth'])->group(function () {
    Route::post('/loyalty/update', [LoyaltyController::class, 'update'])->name('loyalty.update');
});
// ✅ Debug/Test
Route::get('/test-verify', function () {
    if (Auth::check()) {
        return Auth::user()->hasVerifiedEmail() ? '✅ Verified' : '❌ Not Verified';
    }
    return '🛑 Not Logged In';
})->middleware('auth');

// ✅ Auth Routes (Laravel Breeze or Jetstream)
require __DIR__ . '/auth.php';
