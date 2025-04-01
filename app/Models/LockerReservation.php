<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Models\Locker;

class LockerReservation extends Model
{
    protected $fillable = [
        'user_id',
        'locker_id',
        'reserved_at',
        'expires_at',
    ];

    public function reserve($lockerId)
    {
        $locker = Locker::findOrFail($lockerId);

        if ($locker->status === 'unavailable') {
            return back()->with('error', 'This locker is already reserved.');
        }

        self::create([
            'user_id' => Auth::id(),
            'locker_id' => $lockerId,
            'reserved_at' => now(),
        ]);

        $locker->update(['status' => 'unavailable']);

        return back()->with('success', 'Locker reserved successfully!');
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
}
