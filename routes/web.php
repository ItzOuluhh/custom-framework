<?php

use Cloudstorage\Core\Route;
use Cloudstorage\App\Middleware\AuthMiddleware;

use Cloudstorage\App\Controllers\AuthController;
use Cloudstorage\App\Controllers\DashboardController;

/**
 * GET routes
 */
// Auth
Route::get('/auth/login', [AuthController::class, 'showLogin']);
Route::get('/auth/register', [AuthController::class, 'showRegister']);
Route::get('/auth/reset', [AuthController::class, 'showForgotPassword']);
// Dashboard
Route::get('/dashboard', [DashboardController::class, 'showDashboard']);

/**
 * POST routes
 */
Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/reset', [AuthController::class, 'forgotPassword']);
