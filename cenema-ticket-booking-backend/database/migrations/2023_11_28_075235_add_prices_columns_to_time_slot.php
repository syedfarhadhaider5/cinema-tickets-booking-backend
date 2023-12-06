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
        Schema::table('time_slot', function (Blueprint $table) {
            $table->string('premium_seat_price');
            $table->string('general_seat_price');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('time_slot', function (Blueprint $table) {
            $table->dropColumn('premium_seat_price');
            $table->dropColumn('general_seat_price');
        });
    }
};
