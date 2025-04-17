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
    Schema::table('lockers', function (Blueprint $table) {
        $table->dropColumn(['status', 'reserved_at', 'reserved_until']);
    });
}

public function down()
{
    Schema::table('lockers', function (Blueprint $table) {
        $table->string('status')->nullable();
        $table->timestamp('reserved_at')->nullable();
        $table->timestamp('reserved_until')->nullable();
    });
}

};
