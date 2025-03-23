<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Locker;

class LockerSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 1; $i <= 24; $i++) {
            Locker::create([
                'name' => 'Locker ' . $i,
            ]);
        }
    }
}
