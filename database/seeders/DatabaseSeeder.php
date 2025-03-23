<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // ✅ Seed 24 lockers
        $this->call([
            LockerSeeder::class,
        ]);
    }
}
