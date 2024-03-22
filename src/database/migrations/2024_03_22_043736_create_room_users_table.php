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
        Schema::create('room_users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('room_id')->index()->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->index()->constrained();
            $table->dateTime('joined_at')->comment('The time when the user joined the room');
            $table->dateTime('left_at')->nullable()->comment('The time when the user left the room');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('room_users');
    }
};
