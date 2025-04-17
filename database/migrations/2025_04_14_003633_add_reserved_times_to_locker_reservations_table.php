<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('locker_reservations', function (Blueprint $table) {
            $table->timestamp('reserved_at')->nullable();
            $table->timestamp('reserved_until')->nullable(); // previously called "expires_at"
        });
    }

    public function down()
    {
        Schema::table('locker_reservations', function (Blueprint $table) {
            $table->dropColumn(['reserved_at', 'reserved_until']);
        });
    }
};
