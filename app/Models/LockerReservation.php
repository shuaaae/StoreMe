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
}
