<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userServices;

    public function __construct(UserService $userServices)
    {
        $this->userServices = $userServices;
    }


    public function updateUserPreferences(Request $request, $userId)
    {
        $validatedData = $request->validate([
            'preferred_sources' => 'nullable|array',
            'preferred_categories' => 'nullable|array',
            'preferred_authors' => 'nullable|array',
        ]);

        try {
            $updatedPreferences = $this->userServices->createOrUpdateUserPreferences($userId, $validatedData);
            return response()->json([
                'status' => true,
                'message' => 'User preferences updated successfully.',
                'data' => $updatedPreferences,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to update user preferences.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
