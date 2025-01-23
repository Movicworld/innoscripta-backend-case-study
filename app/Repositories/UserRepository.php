<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserRepository
{
    // Create a new user
    public function createUser(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    // Find user by email
    public function findUserByEmail(string $email)
    {
        return User::where('email', $email)->first();
    }

    public function getUsersWithPreferences(string $id)
    {
        return User::where('id', $id)
           // ->leftJoin('user_preferences', 'users.id', '=', 'user_preferences.user_id')
            //->select('users.id', 'users.name', 'users.email', 'user_preferences.preference')
            ->get();
    }
}
