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

    // Validate input
    $request->validate([
        'duration' => 'required|integer|min:1|max:24',
    ]);

    $duration = (int) $request->duration;

    // Save reservation to history WITH STATUS
    LockerReservation::create([
        'locker_id' => $locker->id,
        'user_id' => $userId,
        'reserved_at' => now(),
        'status' => 'pending', // <- THIS IS THE IMPORTANT PART
    ]);

    return back()->with('success', 'Your reservation request is now pending admin approval.');
}


public function cancel(Request $request, Locker $locker)
{
    // Step 1: Cancel latest reservation for this locker
    LockerReservation::where('locker_id', $locker->id)
        ->where('user_id', auth()->id())
        ->latest()
        ->update([
            'reserved_at' => null,
            'reserved_until' => null,
            'status' => 'cancelled',
        ]);

    // Step 2: Reset the locker fields
    $locker->update([
        'user_id' => null,
        'name' => 'Locker #' . $locker->id,
        'background_color' => null,
        'note' => null,
        'is_reserved' => false, // ✅ this line makes it available again
    ]);

    return redirect()->back()->with('success', 'Reservation cancelled successfully.');
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
