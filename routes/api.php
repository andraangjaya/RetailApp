<?php

use App\Http\Controllers\ProductsController;
use Illuminate\Support\Facades\Route;

Route::post('/products', [ProductsController::class, 'createProduct']);
Route::get('/products', [ProductsController::class, 'getAllProducts']);
Route::get('/products/{id}', [ProductsController::class, 'getProduct']);
Route::put('/products/{id}', [ProductsController::class, 'updateProduct']);
Route::delete('/products/{id}', [ProductsController::class, 'deleteProduct']);


