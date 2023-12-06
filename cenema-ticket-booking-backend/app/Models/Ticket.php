<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $table = 'tickets';

    protected $fillable = [
        'movie_id',
        'time_slot_id',
        'user_id',
        'seat_number',
        'cnic',
        'contact_number',
        'contact_email',
        'booking_date',
        'sir_name',
        'full_name'
    ];
    public function movie()
    {
        return $this->belongsTo(Movie::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function timeSlot()
    {
        return $this->belongsTo(TimeSlot::class);
    }
}
