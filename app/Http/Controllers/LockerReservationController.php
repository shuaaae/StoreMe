<?php

namespace App\Http\Controllers;

use App\Models\Locker;
use App\Models\LockerReservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LockerReservationController extends Controller
{
    public function reserve(Request $request, Locker $locker)
    {
        // Validate the duration input
        $request->validate([
            'duration' => 'required|integer|min:1|max:24',
        ]);

        // Check if already reserved
        if ($locker->is_reserved) {
            return back()->with('error', 'This locker is already reserved.');
        }

        // Cast duration to int
        $duration = (int) $request->input('duration');

        // Create reservation
        LockerReservation::create([
            'user_id' => auth()->id(),
            'locker_id' => $locker->id,
            'reserved_at' => now(),
            'expires_at' => now()->addHours($duration),
        ]);

        // Mark locker as reserved
        $locker->update([
            'is_reserved' => true,
            'user_id' => auth()->id(), // Store who reserved it
            'reserved_until' => now()->addHours($duration),
        ]);

        return redirect()->route('dashboard')->with('success', 'Locker reserved successfully!');
    }

    public function cancel(Locker $locker)
    {
        $reservation = LockerReservation::where('user_id', auth()->id())
                        ->where('locker_id', $locker->id)
                        ->latest()
                        ->first();

        if ($reservation) {
            $reservation->delete();

            $locker->update([
                'is_reserved' => false,
                'user_id' => null,
                'reserved_until' => null,
            ]);

            return redirect()->route('dashboard')->with('success', 'Reservation canceled successfully!');
        }

        return redirect()->route('dashboard')->with('error', 'No active reservation found.');
    }
    
    public function extend(Locker $locker)
{
    $reservation = LockerReservation::where('user_id', auth()->id())
        ->where('locker_id', $locker->id)
        ->latest()
        ->first();

    if (!$reservation) {
        return back()->with('error', 'No active reservation found.');
    }

    // Extend expires_at by 1 hour
    $reservation->expires_at = now()->parse($reservation->expires_at)->addHour();
    $reservation->save();

    return back()->with('success', 'Reservation extended by 1 hour!');
}

}
