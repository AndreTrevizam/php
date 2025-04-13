<?php

use App\Models\Sale;
use App\Models\Product;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;

Route::get('/', [HomeController::class, 'index']);

Route::post('/register', [UserController::class, 'register']);
Route::post('/logout', [UserController::class, 'logout']);
Route::post('/login', [UserController::class, 'login']);

// Rota relacionadas a produtos
Route::post('/create-product', [ProductController::class, 'createProduct']);
Route::get('/edit-product/{product}', [ProductController::class, 'showEditScreen']);
Route::put('/edit-product/{product}', [ProductController::class, 'updateProduct']);
Route::delete('/delete-product/{product}', [ProductController::class, 'deleteProduct']);

// Rota relacionada a vendas
Route::post('/create-sale', [SaleController::class, 'store'])->middleware('auth');
Route::get('/sale-report', [SaleController::class, 'report'])->middleware('auth');
