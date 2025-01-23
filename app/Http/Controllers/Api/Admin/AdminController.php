<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Admin\AdminServices;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    protected $adminService;

    public function __construct(AdminServices $adminService)
    {
        $this->adminService = $adminService;
    }

    public function storeNewsApiCredentials(Request $request)
    {
        $validator =  Validator::make($request->all(), [
            'api_name' => 'required|string',
            'api_key' => 'required|string',
            'secret_key' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()
            ], 400);
        }
        $this->adminService->storeNewsApiCredentials($request->api_name, $request->api_key);

        return response()->json([
            'status' => true,
            'message' => 'API credentials stored successfully.',
        ]);
    }

    public function getSourceNews()
    {
        try {
            $news = $this->adminService->getSourceNews();

            return response()->json([
                'status' => true,
                'message' => 'News fetched successfully.',
                'data' => $news,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function getUsersWithPreferences($id)
    {
        $users = $this->adminService->getUsersWithPreferences($id);

        return response()->json([
            'status' => true,
            'message' => 'Users with preferences retrieved successfully.',
            'data' => $users,
        ]);
    }

    public function getAdminDetails()
    {
        try {
            $admin = $this->adminService->getAdminDetails(Auth::user());

            return response()->json([
                'status' => true,
                'message' => 'Admin details retrieved successfully.',
                'data' => $admin,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 403);
        }
    }
}
