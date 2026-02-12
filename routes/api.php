<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\PersonController;
use App\Http\Controllers\Api\RegistrationController;
use App\Http\Controllers\Api\SettingsController;
use App\Http\Controllers\Api\StoryController;
use App\Http\Controllers\Api\Admin\CompanyController as AdminCompanyController;
use App\Http\Controllers\Api\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Api\Admin\PersonController as AdminPersonController;
use App\Http\Controllers\Api\Admin\SettingsController as AdminSettingsController;
use App\Http\Controllers\Api\Admin\StoryController as AdminStoryController;
use App\Http\Controllers\Api\Admin\UserController as AdminUserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public API Routes
|--------------------------------------------------------------------------
*/

// Stories
Route::get('stories', [StoryController::class, 'index']);
Route::get('stories/{story}', [StoryController::class, 'show']);

// Companies
Route::get('companies/founders', [CompanyController::class, 'founders']);
Route::get('companies/heroes', [CompanyController::class, 'heroes']);
Route::get('companies/{company}', [CompanyController::class, 'show']);

// People
Route::get('people', [PersonController::class, 'index']);
Route::get('people/{person}', [PersonController::class, 'show']);

// Settings
Route::get('settings/results', [SettingsController::class, 'results']);

// Registration
Route::post('register-interest', [RegistrationController::class, 'store']);

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/

Route::post('login', [AuthController::class, 'login']);
Route::post('forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('reset-password', [AuthController::class, 'resetPassword']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('user', [AuthController::class, 'user']);
    Route::post('logout', [AuthController::class, 'logout']);
});

/*
|--------------------------------------------------------------------------
| Admin Routes - Admin Only
|--------------------------------------------------------------------------
*/

Route::middleware(['auth:sanctum', 'role:admin'])->prefix('admin')->group(function () {
    // Users (admin only)
    Route::apiResource('users', AdminUserController::class);
    Route::patch('users/{user}/password', [AdminUserController::class, 'updatePassword']);
});

/*
|--------------------------------------------------------------------------
| Admin Routes - Admin or Moderator
|--------------------------------------------------------------------------
*/

Route::middleware(['auth:sanctum', 'role:admin|moderator'])->prefix('admin')->group(function () {
    // Dashboard
    Route::get('dashboard', [AdminDashboardController::class, 'index']);

    // Companies
    Route::apiResource('companies', AdminCompanyController::class);
    Route::patch('companies/{company}/status', [AdminCompanyController::class, 'updateStatus']);
    Route::patch('companies/{company}/group', [AdminCompanyController::class, 'updateGroup']);
    Route::patch('companies/{company}/detail-page', [AdminCompanyController::class, 'toggleDetailPage']);

    // Stories
    Route::get('stories/statistics', [AdminStoryController::class, 'statistics']);
    Route::apiResource('stories', AdminStoryController::class);

    // People
    Route::apiResource('people', AdminPersonController::class);

    // Settings
    Route::get('settings', [AdminSettingsController::class, 'index']);
    Route::put('settings', [AdminSettingsController::class, 'update']);
});
