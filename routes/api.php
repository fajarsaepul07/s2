<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PrioritasController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TiketController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// CSRF untuk SPA / front-end
Route::get('/sanctum/csrf-cookie', \Laravel\Sanctum\Http\Controllers\CsrfCookieController::class . '@show');

// API Auth
Route::post('/login', [AuthController::class, 'loginApi']);
Route::post('/register', [AuthController::class, 'registerApi']);
Route::post('/logout', [AuthController::class, 'logoutApi'])->middleware('auth:sanctum');

// Google Login (optional, web only)
Route::get('/auth-google-redirect', [AuthController::class, 'google_redirect']);
Route::get('/auth-google-callback', [AuthController::class, 'google_callback']);

// API Protected Routes
Route::middleware(['auth:sanctum', 'check_role:customer'])->group(function () {
    Route::get('/home', [HomeController::class, 'index']);
});

Route::middleware(['auth:sanctum', 'check_role:admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);

    Route::get('/roles', [RoleController::class, 'index']);
    Route::post('/roles', [RoleController::class, 'store']);
    Route::get('/roles/{id}', [RoleController::class, 'show']);
    Route::put('/roles/{id}', [RoleController::class, 'update']);
    Route::delete('/roles/{id}', [RoleController::class, 'destroy']);

    Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

    Route::get('/users', [UserController::class, 'index']);
    Route::post('/users', [UserController::class, 'store']);
    Route::put('/users/{id}', [UserController::class, 'update']);
    Route::delete('/users/{id}', [UserController::class, 'destroy']);
});

// Reports API
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/reports', [ReportController::class, 'index']);
    Route::post('/reports', [ReportController::class, 'store']);
    Route::get('/reports/{id}', [ReportController::class, 'show']);
    Route::put('/reports/{id}', [ReportController::class, 'update']);
    Route::delete('/reports/{id}', [ReportController::class, 'destroy']);
});

// Tikets API
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/tikets', [TiketController::class, 'index']);
    Route::post('/tikets', [TiketController::class, 'store']);
    Route::get('/tikets/{tiket_id}', [TiketController::class, 'show']);
    Route::put('/tikets/{tiket_id}', [TiketController::class, 'update']);
    Route::delete('/tikets/{tiket_id}', [TiketController::class, 'destroy']);
});

// Kategori & Status Tiket API
Route::middleware(['auth:sanctum'])->group(function () {
    Route::apiResource('/kategoris', \App\Http\Controllers\KategoriController::class);
    Route::apiResource('/tiket-statuses', \App\Http\Controllers\TiketStatusController::class);
});

// Prioritas API
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/prioritas', [PrioritasController::class, 'index']);
    Route::post('/prioritas', [PrioritasController::class, 'store']);
    Route::put('/prioritas/{id}', [PrioritasController::class, 'update']);
    Route::delete('/prioritas/{id}', [PrioritasController::class, 'destroy']);
});