<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\AdminServices;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    protected $adminService;

    public function __construct(AdminServices $adminService)
    {
        $this->adminService = $adminService;
    }

    public function createCategory(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:categories,name',
            'description' => 'required|string',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()
            ], 400);
        }

        try {
            $category = $this->adminService->createCategory($validator->validated());
            return response()->json(['message' => 'Category created successfully', 'data' => $category], 201);
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to create category', 'message' => $e->getMessage()], 500);
        }
    }

    public function getCategories()
    {
        try {
            $categories = $this->adminService->getCategories();

            return response()->json([
                'status' => true,
                'message' => 'Categories retrieved successfully',
                'data' => $categories
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to retrieve categories',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getUsers($userId = null)
    {
        try {
            $users = $this->adminService->getUsers($userId);

            return response()->json([
                'status' => true,
                'message' => $userId ? 'User details retrieved successfully' : 'Users retrieved successfully',
                'data' => $users
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to retrieve users',
                'error' => $e->getMessage()
            ], 500);
        }
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
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 403);
        }
    }
}
