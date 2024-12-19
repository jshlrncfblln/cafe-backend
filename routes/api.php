<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/* Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum'); */



Route::middleware('auth:sanctum')->group(function () {
    Route::post('/login', [AuthController::class, 'login'])->withoutMiddleware('auth:sanctum');
    Route::get('/user' , [AuthController::class, 'user']);

    // USER MANAGEMENT
    Route::get('/users', [UserController::class, 'index']);
    Route::get('/users/{id}', [UserController::class, 'show']);
    Route::post('/users', [UserController::class, 'create']);
    Route::put('/users/{id}', [UserController::class, 'update']);
    Route::delete('/users/{id}', [UserController::class, 'destroy']);

    // INVENTORY MANAGEMENT
    Route::get('/inventories', [InventoryController::class, 'index']);
    Route::get('/inventories/{id}', [InventoryController::class, 'show']);
    Route::post('/inventories', [InventoryController::class, 'create']);
    Route::put('/inventories/{id}', [InventoryController::class, 'update']);
    Route::delete('/inventories/{id}', [InventoryController::class, 'destroy']);
    Route::post('/inventories/{id}/restock', [InventoryController::class, 'restock']);

    // PRODUCT MANAGEMENT
    Route::get('/products', [ProductsController::class, 'index']);
    Route::get('/products/{id}', [ProductsController::class, 'show']);
    Route::post('/products', [ProductsController::class, 'create']);
});
