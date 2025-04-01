<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Locker extends Model
{
    use HasFactory;

    // ✅ Allow mass assignment for these fields
    protected $fillable = ['name', 'is_reserved', 'user_id', 'reserved_until', 'background_color'];

    // ✅ Relationship to get the latest reservation for this locker
    public function latestReservation()
    {
        return $this->hasOne(\App\Models\LockerReservation::class)->latestOfMany();
    }

    public function reservation()
{
    return $this->hasOne(\App\Models\LockerReservation::class);
}

}
