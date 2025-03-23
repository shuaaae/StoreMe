<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('lockers', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();         // Locker name e.g. "Locker 1"
            $table->boolean('is_reserved')->default(false);
            $table->unsignedBigInteger('user_id')->nullable(); // The user who reserved it
            $table->timestamp('reserved_until')->nullable();   // When reservation expires
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lockers');
    }
};
