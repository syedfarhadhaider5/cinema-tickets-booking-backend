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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('movie_id'); // Assuming movie_id is a foreign key
            $table->foreign('movie_id')->references('id')->on('movies')->onDelete('cascade');
            $table->unsignedBigInteger('time_slot_id'); // Assuming movie_id is a foreign key
            $table->foreign('time_slot_id')->references('id')->on('time_slot')->onDelete('cascade');
            $table->unsignedBigInteger('user_id'); // Assuming movie_id is a foreign key
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('seat_number');
            $table->string('premium_seat_price');
            $table->string('general_seat_price');
            $table->string('cnic');
            $table->string('sir_name');
            $table->string('full_name');
            $table->string('contact_number');
            $table->string('contact_email');
            $table->string('booking_date');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
