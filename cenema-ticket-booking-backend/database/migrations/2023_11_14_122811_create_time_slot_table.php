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
        Schema::create('time_slot', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('movie_id'); // Assuming movie_id is a foreign key
            $table->foreign('movie_id')->references('id')->on('movies')->onDelete('cascade');
            $table->string('movie_date');
            $table->string('time_slot');
            $table->integer('total_seat');
            $table->integer('premium_seat_available');
            $table->integer('general_seat_available');
            $table->string('ticket_type');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('time_slot');
    }
};
