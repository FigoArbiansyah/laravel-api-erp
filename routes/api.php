<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('v1')->group(function($router) {
    Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
    Route::post('/register', [AuthController::class, 'register'])->name('auth.register');
    Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');

    Route::get('me', [AuthController::class, 'me'])->middleware('auth:sanctum');

    Route::middleware('auth:sanctum')->prefix('categories')->group(function($router) {
        $router->get('/', [CategoryController::class, 'index']); // Mendapatkan semua kategori
        $router->get('/{id}', [CategoryController::class, 'show']); // Mendapatkan kategori berdasarkan ID
        $router->post('/', [CategoryController::class, 'store']); // Menambahkan kategori baru
        $router->post('/{id}', [CategoryController::class, 'update']); // Memperbarui kategori berdasarkan ID
        $router->delete('/{id}', [CategoryController::class, 'destroy']); // Menghapus kategori berdasarkan ID
    });
});
