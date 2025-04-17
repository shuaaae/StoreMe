<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Locker extends Model
{
    use HasFactory;

    // ✅ FIXED: Added 'note' to the fillable array
    protected $fillable = [
        'name',
        'is_reserved',
        'user_id',
        'reserved_until',
        'background_color',
        'note', // ✅ This line is required to allow updates
    ];

    // ✅ Relationship to get the latest reservation for this locker
    public function latestReservation()
    {
        return $this->hasOne(\App\Models\LockerReservation::class)->latestOfMany();
    }

    public function reservation()
    {
        return $this->hasOne(\App\Models\LockerReservation::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
