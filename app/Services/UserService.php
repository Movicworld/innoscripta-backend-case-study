<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;



class UserService
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getUserDetails()
    {
        $user = Auth::user();
        return $this->userRepository->getUserDetails($user->id);
    }

    public function getUserPreferences($userId)
    {
        return $this->userRepository->getPreferences($userId);
    }

    public function createOrUpdateUserPreferences($userId, $data)
    {
        return $this->userRepository->savePreferences($userId, $data);
    }
}
