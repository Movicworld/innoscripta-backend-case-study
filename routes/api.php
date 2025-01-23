<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ArticleController;
use App\Http\Controllers\Api\Admin\AdminController;

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
    Route::get('/get-news', [ArticleController::class, 'news']);

    Route::middleware([
        'auth',
        'user'
    ])->prefix(
        'user'
    )->group(function () {
        Route::get('/details', [AuthController::class, 'details']);
    });

    Route::middleware([
        'auth:api',
        'admin'
    ])->prefix(
        'admin'
    )->group(function () {
        Route::post('/add/category', [AdminController::class, 'createCategory']);
        Route::get('/news', [AdminController::class, 'getSourceNews']);
        Route::get('/users/preferences/{id}', [AdminController::class, 'getUsersWithPreferences']);
        Route::get('/details', [AdminController::class, 'getAdminDetails']);
    });
});
