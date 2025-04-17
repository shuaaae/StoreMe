<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Locker;

class AddNumberColumnToLockersTable extends Migration
{
    public function up(): void
    {
        Schema::table('lockers', function (Blueprint $table) {
            $table->integer('number')->nullable()->after('id');
        });

        Locker::all()->each(function ($locker, $index) {
            $locker->number = $index + 1;
            $locker->save();
        });
    }

    public function down(): void
    {
        Schema::table('lockers', function (Blueprint $table) {
            $table->dropColumn('number');
        });
    }
}
