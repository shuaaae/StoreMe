<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Locker;
use App\Models\LockerReservation; // ✅ Properly import the model here
use Carbon\Carbon;

class LockerController extends Controller
{
    public function index()
    {
        $lockers = Locker::all();
        $userReservations = LockerReservation::where('user_id', auth()->id())
            ->orderByDesc('reserved_at')
            ->take(5)
            ->get();
    
        $userLocker = $lockers->firstWhere('user_id', auth()->id());
        $reservedAtValue = null;
    
        if ($userLocker) {
            $reservation = LockerReservation::where('user_id', auth()->id())
                ->where('locker_id', $userLocker->id)
                ->latest('reserved_at')
                ->first();
    
            if ($reservation) {
                $reservedAtValue = $reservation->reserved_at;
            }
        }
    
        return view('dashboard', compact('lockers', 'userReservations', 'reservedAtValue'));
    }
    

    public function extend(Request $request, Locker $locker)
    {
        $hours = (int) $request->input('extend_hours');

        $reservation = $locker->reservation()->where('user_id', auth()->id())->first();

        if ($reservation) {
            $reservation->reserved_until = Carbon::parse($reservation->reserved_until)->addHours($hours);
            $reservation->save();
        }

        return redirect()->route('dashboard');
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
    public function update(Request $request, Locker $locker)
    {
        if ($locker->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate(['name' => 'required|string|max:50']);
        $locker->update(['name' => $request->name]);

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

}
