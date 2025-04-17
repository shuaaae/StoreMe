<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('locker_reservations', function (Blueprint $table) {
        // ✅ REMOVE this line if it still exists:
        // $table->timestamp('reserved_at')->nullable();

        // ✅ KEEP these:
        $table->timestamp('expires_at')->nullable();
        $table->string('status')->default('pending');
    });
}

};
