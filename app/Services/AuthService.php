<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Exception;
use Illuminate\Support\Facades\Hash;


class AuthService
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    // Register a new user
    public function register(array $data)
    {
        try {
            // Create a new user
            $registerUser = $this->userRepository->createUser($data);

            if ($registerUser) {
                // Log in the newly registered user
                return $this->login([
                    'email' => $registerUser->email,
                    'password' => $data['password'],
                ]);
            }
        } catch (Exception $e) {
            return [
                'status' => false,
                'message' => 'User registration failed: ' . $e->getMessage(),
            ];
        }
    }
    public function login(array $data)
    {
        // Find the user by email
        $user = $this->userRepository->findUserByEmail($data['email']);

        if ($user && Hash::check($data['password'], $user->password)) {
            // Generate access token
            $token = $user->createToken('Innoscripta')->accessToken;

            return $data = [
                'role' => $user->role,
                'token' => $token,
            ];
        }

        return false;
    }
}
