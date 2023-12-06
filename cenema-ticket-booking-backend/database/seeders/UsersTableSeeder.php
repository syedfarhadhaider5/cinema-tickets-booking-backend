<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $numberOfUsers = 10;

        for ($i = 0; $i < $numberOfUsers; $i++) {
            $type = ($i % 2 == 0) ? 'admin' : 'normal'; // Alternating 'admin' and 'normal' users

            DB::table('users')->insert([
                'name' => 'User' . $i,
                'email' => 'user' . $i . '@example.com',
                'password' => Hash::make('password'), // You may want to use bcrypt() instead of Hash::make() depending on your Laravel version
                'access_token' => Str::random(40), // Generate a random string for the access token
                'type' => $type,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
