<?php

namespace App\Http\Controllers;

use App\Models\Locker;
use App\Models\LockerReservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class LockerReservationController extends Controller
{
    public function reserve(Request $request, Locker $locker)
{
    $userId = auth()->id();

    // Prevent user from reserving another locker
    $existingReservation = Locker::where('user_id', $userId)
        ->where('is_reserved', true)
        ->first();

    if ($existingReservation) {
        return back()->with('error', 'You already have a reserved locker.');
    }

    // Validate and cast to integer
    $request->validate([
        'duration' => 'required|integer|min:1|max:24',
    ]);

    $duration = (int) $request->duration;

    // Update the locker
    $locker->update([
        'is_reserved' => true,
        'user_id' => $userId,
        'reserved_until' => now()->addHours($duration),
    ]);

    // Save reservation history
    \App\Models\LockerReservation::create([
        'locker_id' => $locker->id,
        'user_id' => $userId,
        'reserved_at' => now(),
        'expires_at' => now()->addHours($duration),
    ]);

    return back()->with('success', 'Locker reserved successfully.');
}

public function cancel(Locker $locker)
{
    $locker->update([
        'is_reserved' => false,
        'user_id' => null,
        'reserved_until' => null,
        'name' => 'Locker ' . $locker->id,
        'background_color' => null,
    ]);

    // Optionally delete the reservation record too
    $locker->reservation()->delete();

    return redirect()->route('dashboard')->with('status', 'Reservation ended.');
}

    
    public function extend(Request $request, Locker $locker)
{
    $reservation = LockerReservation::where('user_id', auth()->id())
        ->where('locker_id', $locker->id)
        ->latest()
        ->first();

    if (!$reservation) {
        return back()->with('error', 'No active reservation found.');
    }

    $extendHours = (int) $request->input('extend_hours');

    if ($extendHours <= 0) {
        return back()->with('error', 'Invalid extension hours.');
    }

    $reservation->expires_at = Carbon::parse($reservation->expires_at)->addHours($extendHours);
    $reservation->save();

    // Update the locker reserved_until field as well
    $locker->reserved_until = $reservation->expires_at;
    $locker->save();

    return back()->with('success', 'Reservation extended successfully.');
    }

}
