<?php

use App\Http\Controllers\ProductsController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\ReceiptsController;
use Illuminate\Support\Facades\Route;

Route::prefix('products')->group(function () {
    Route::post('/', [ProductsController::class, 'store'])->name('products.store');
    Route::get('/', [ProductsController::class, 'index'])->name('products.index');
    Route::get('{product}', [ProductsController::class, 'show'])->name('products.show');
    Route::put('{product}', [ProductsController::class, 'update'])->name('products.update');
    Route::put('{product}/stock', [ProductsController::class, 'updateStock'])->name('products.updateStock');
    Route::delete('{product}', [ProductsController::class, 'destroy'])->name('products.destroy');
});

Route::post('/orders', [OrdersController::class, 'store'])->name('orders.store');
Route::get('/orders', [OrdersController::class, 'index'])->name('orders.index');

Route::post('/receipts/create', [ReceiptsController::class, 'store'])->name('receipts.store');
Route::get('/receipts', [ReceiptsController::class, 'index'])->name('receipts.index');
