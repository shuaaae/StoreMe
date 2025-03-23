<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Locker extends Model
{
    use HasFactory;

    // ✅ Add this line to allow mass assignment for 'name'
    protected $fillable = ['name', 'is_reserved', 'user_id', 'reserved_until'];
}
