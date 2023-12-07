<?php
// app/Http/Controllers/UserController.php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6',
        ]);
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->access_token =  Str::random(60);
        $user->save();

        $createdUser = User::find($user->id);

        return response()->json([
            'user' => [
                'id' => $createdUser->id,
                'name' => $createdUser->name,
                'email' => $createdUser->email,
                'type' => $createdUser->type,
                'access_token' => $createdUser->access_token
            ],
            'message' => 'User registered successfully'
        ], 201);
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Email or password incorrect.'], 401);
        }

        return response()->json(['user' => $user, 'message' => 'Login successful'], 200);
    }
    public function logout(Request $request){
        $token = $request->token;

        // Find the user based on the provided email
        $user = User::where('access_token', $token)->first();

        if ($user) {
            // Generate a new access token
            $newAccessToken = Str::random(60);

            // Update the user's access token in the database
            $user->update(['access_token' => $newAccessToken]);

            return response()->json(['message' => 'Logout successful'], 200);
        }

        return response()->json(['message' => 'User not found'], 404);
    }
}
