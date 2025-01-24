<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\UserPreference;
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

    public function getUserDetails($userId)
    {
        return User::where(
            'role',
            'user',
        )->with(
            'preferences'
        )
        ->findOrFail($userId);
    }

    public function getPaginatedUsers($perPage = 10)
    {
        return User::where(
            'role',
            'user'
        )->paginate($perPage);
    }

    public function getPreferences($userId)
    {
        return UserPreference::where('user_id', $userId)->first();
    }

    // Create or update preferences for a user
    public function savePreferences($userId, $data)
    {
        return UserPreference::updateOrCreate(
            ['user_id' => $userId],
            [
                'preferred_sources' => $data['preferred_sources'] ?? [],
                'preferred_categories' => $data['preferred_categories'] ?? [],
                'preferred_authors' => $data['preferred_authors'] ?? [],
            ]
        );
    }

}
