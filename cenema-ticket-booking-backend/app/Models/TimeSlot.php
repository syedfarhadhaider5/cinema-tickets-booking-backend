<?php

namespace App\Models;

use App\Models\Movie;
use App\Models\Ticket;
use Illuminate\Database\Eloquent\Model;

class TimeSlot extends Model
{
    protected $table = 'time_slot';

    protected $fillable = [
        'movie_id',
        'movie_date',
        'time_slot',
        'total_seat',
        'premium_seat_available',
        'general_seat_available',
        'ticket_type',
        'premium_seat_price',
        'general_seat_price',
    ];

    public function movie()
    {
        return $this->belongsTo(Movie::class);
    }
    public function tickets()
    {
        // optional second parameter of forign key movie_id
        return $this->hasMany(Ticket::class);
    }
}
