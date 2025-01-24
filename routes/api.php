<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ArticleController;
use App\Http\Controllers\Api\Admin\AdminController;
use App\Http\Controllers\Api\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::prefix(
    'v1'
)->group(function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);

    Route::get('/articles/search', [ArticleController::class, 'searchArticles']);
    Route::get('/articles/filters', [ArticleController::class, 'getFilterApparatus']);
   // Route::get('/get-news', [ArticleController::class, 'news']); // to manually update the articles

    Route::middleware([
        'auth',
        'user'
    ])->prefix(
        'user'
    )->group(function () {
        Route::post('/preferences/{userId}', [UserController::class, 'updateUserPreferences']);
        Route::get('/user-details', [AuthController::class, 'details']);
    });

    Route::middleware([
        'auth:api',
        'admin'
    ])->prefix(
        'admin'
    )->group(function () {
        Route::post('/add/category', [AdminController::class, 'createCategory']);
        Route::get('/categories', [AdminController::class, 'getCategories']);
        Route::get('/news', [AdminController::class, 'getSourceNews']);
        Route::get('/details', [AdminController::class, 'getAdminDetails']);
        Route::get('/users', [AdminController::class, 'getUsers']);
        Route::get('/users/{id}', [AdminController::class, 'getUsers']);
    });
});
