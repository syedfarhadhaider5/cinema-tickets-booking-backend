<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    protected $table = 'movies';

    protected $fillable = [
        'movie_name',
        'movie_name',
        'movie_name',
        'movie_name',
        'movie_name',
        'movie_name',
        'movie_banner',
        'director_name',
        'cenema_name',
        'release_date',
        'details',
        'duration',
        'movie_type',
        'location_name',
        'is_published',
    ];
    public function timeSlots()
    {
        // optional second parameter of forign key movie_id
        return $this->hasMany(TimeSlot::class);
    }
    public function tickets()
    {
        // optional second parameter of forign key movie_id
        return $this->hasMany(Ticket::class);
    }
}
