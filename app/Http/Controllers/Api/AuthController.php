<?php

namespace App\Http\Controllers\Api;

use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Services\UserService;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    protected $authService;
    protected $userService;



    public function __construct(AuthService $authService,
    UserService $userService)
    {
        $this->authService = $authService;
        $this->userService = $userService;
    }

    // Register a new user
    public function register(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()
            ], 400);
        }

        // Register the user via the service
        $user = $this->authService->register($request->all());

        return response()->json([
            'status' => true,
            'message' => 'User created successfully',
            'user' => $user
        ], 201);
    }

    // Log in and get the token with user details
    public function login(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()
            ], 400);
        }

        // Log in the user and get the token
        $res = $this->authService->login($request->all());

        if ($res) {
            return response()->json([
                'status' => true,
                'data' => $res,

            ], 200);
        }

        return response()->json([
            'status' => false,
            'message' => 'Incorrect Credentials'
        ], 401);
    }

    //   Get user details.
    public function details()
    {
        $user = $this->userService->getUserDetails();

        if ($user) {
            return response()->json([
                'status' => true,
                'message' => 'User details retrieved successfully.',
                'data' => $user,
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'User not authenticated.',
        ], 401);
    }
}
