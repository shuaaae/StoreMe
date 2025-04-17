<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Models\Locker;

class LockerReservation extends Model
{
    protected $fillable = [
        'locker_id',
        'user_id',
        'reserved_at',
        'reserved_until',
        'status',
        'payment_status',
    ];
    
    

    public function extend(Request $request, Locker $locker)
{
    $request->validate([
        'extend_hours' => 'required|integer|min:1|max:24',
    ]);

    $user = auth()->user();

    if ($locker->user_id !== $user->id) {
        abort(403);
    }

    // Extend the reserved_until on the locker
    $locker->reserved_until = \Carbon\Carbon::parse($locker->reserved_until)->addHours($request->extend_hours);
    $locker->save();

    // Find the latest reservation record
    $reservation = \App\Models\Reservation::where('locker_id', $locker->id)
        ->where('user_id', $user->id)
        ->latest()
        ->first();

    if ($reservation) {
        // Extend the reservation record's reserved_until too
        $reservation->reserved_until = $locker->reserved_until;
        $reservation->save();
    }

    return back()->with('success', 'Locker extended successfully.');
}


    public function isExpired()
{
    return Carbon::now()->greaterThan($this->reserved_until);
}

public function isInGracePeriod()
{
    return $this->isExpired() && Carbon::now()->lessThanOrEqualTo(Carbon::parse($this->reserved_until)->addMinutes(15));
}

public function isFullyExpired()
{
    return Carbon::now()->greaterThan(Carbon::parse($this->reserved_until)->addMinutes(15));
}
public function locker()
{
    return $this->belongsTo(Locker::class);
}

public function user()
{
    return $this->belongsTo(User::class);
}

}
