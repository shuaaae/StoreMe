<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Locker;
use Illuminate\Support\Facades\Auth;
use App\Models\LockerReservation; // ✅ Properly import the model here
use Carbon\Carbon;


class LockerController extends Controller
{
    public function index()
    {
        $lockers = Locker::all();
        $userReservations = LockerReservation::where('user_id', auth()->id())
    ->where('status', '!=', 'cancelled') // ✅ Exclude cancelled reservations
    ->orderByDesc('reserved_at')
    ->take(5)
    ->get();
    
        $userLocker = $lockers->firstWhere('user_id', auth()->id());
        $latestReservation = null; // ✅ Add this before any condition
        $reservedAtValue = null;
    
        if ($userLocker) {
            $reservation = LockerReservation::where('user_id', auth()->id())
                ->where('locker_id', $userLocker->id)
                ->latest('reserved_at')
                ->first();
    
            if ($reservation) {
                $reservedAtValue = $reservation->reserved_at;
                $latestReservation = $reservation; // ✅ ADD THIS
            }
        }
    
        return view('dashboard', compact('lockers', 'userReservations', 'reservedAtValue', 'latestReservation'));
    }
    

    public function extend(Request $request, Locker $locker)
{
    $extendHours = (int) $request->input('extend_hours');
    $userId = auth()->id();

    $latestReservation = LockerReservation::where('locker_id', $locker->id)
        ->where('user_id', $userId)
        ->latest('reserved_at')
        ->first();

    if (!$latestReservation || $latestReservation->status !== 'active') {
        return back()->with('error', 'You do not have an active reservation to extend.');
    }

    $reservedUntil = \Carbon\Carbon::parse($latestReservation->reserved_until);
    $now = \Carbon\Carbon::now();

    // ✅ Only allow extension if reservation is expired
    if ($now->lessThan($reservedUntil)) {
        return back()->with('error', 'You can only request extension after your reservation expires.');
    }

    // ✅ Add as pending reservation
    LockerReservation::create([
        'user_id' => $userId,
        'locker_id' => $locker->id,
        'reserved_at' => $now,
        'reserved_until' => $now->copy()->addHours($extendHours),
        'status' => 'pending',
        'payment_status' => 'Unpaid',
    ]);

    return back()->with('success', 'Extension request submitted. Please wait for admin approval.');
}

    public function updateColor(Request $request, $id)
    {
        $locker = Locker::findOrFail($id);

        if ($locker->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'background_color' => 'required|string|max:20'
        ]);

        $locker->background_color = $request->background_color;
        $locker->save();

        return redirect()->back()->with('success', 'Locker background updated!');
    }

    // Update locker name
    public function updateName(Request $request, Locker $locker)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
    
        if ($locker->user_id !== Auth::id()) {
            abort(403);
        }
    
        $locker->name = $request->name;
        $locker->save();
    
        return back()->with('success', 'Locker name updated!');
    }    

    // Change background color
    public function changeColor(Request $request, Locker $locker)
    {
        if ($locker->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate(['background_color' => 'required|string|max:20']);
        $locker->update(['background_color' => $request->background_color]);

        return back()->with('success', 'Locker background updated!');
    }

    public function updateNote(Request $request, Locker $locker)
{
    if ($locker->user_id !== auth()->id()) {
        abort(403);
    }

    $request->validate([
        'note' => 'nullable|string|max:1000',
    ]);

    $locker->note = $request->note;
    $locker->save();

    return redirect()->route('dashboard')->with('success', 'Note saved!');
}
public function reserve(Request $request, Locker $locker)
{
    // Only allow if the locker is not reserved
    if ($locker->is_reserved) {
        return redirect()->back()->with('error', 'Locker is already reserved.');
    }

    // Create new reservation entry
    $reservation = new LockerReservation();
    $reservation->user_id = auth()->id();
    $reservation->locker_id = $locker->id;
    $reservation->status = 'pending'; // Admin will approve later
    $reservation->save();

    // Update the locker table if needed (optional depending on your logic)
    $locker->update([
        'user_id' => auth()->id(),
        'is_reserved' => true, // Assuming you have this column
    ]);

    return redirect()->back()->with('success', 'Reservation request submitted. Please wait for admin approval.');
}
public function cancelReservation(LockerReservation $reservation)
{
    $locker = Locker::find($reservation->locker_id);

    $reservation->update([
        'status' => 'cancelled',
        'reserved_at' => null,
        'reserved_until' => null,
    ]);

    if ($locker) {
        $locker->update([
            'user_id' => null,
            'note' => null,
            'is_reserved' => false,
            'name' => 'Locker #' . $locker->number,
        ]);
    }

    return back()->with('success', 'Reservation cancelled successfully.');
}

}
