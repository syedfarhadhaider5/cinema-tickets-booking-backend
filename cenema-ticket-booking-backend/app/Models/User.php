<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'users';

    protected $fillable = [
        'name', 'email', 'password','access_token','type'
    ];

    protected $hidden = [
        'password','created_at','updated_at'
    ];
    public function tickets()
    {
        // optional second parameter of forign key movie_id
        return $this->hasMany(Ticket::class);
    }
}
