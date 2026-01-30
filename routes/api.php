<?php

use App\Http\Controllers\CustomersController;
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

Route::prefix('orders')->group(function(){
    Route::post('/', [OrdersController::class, 'store'])->name('orders.store');
    Route::get('/', [OrdersController::class, 'index'])->name('orders.index');
});

Route::prefix('receipts')->group(function(){
    Route::post('/create', [ReceiptsController::class, 'store'])->name('receipts.store');
    Route::get('/', [ReceiptsController::class, 'index'])->name('receipts.index');
});

Route::prefix('customers')->group(function(){
    Route::post('/', [CustomersController::class, 'store'])->name('customers.store');
    Route::get('/', [CustomersController::class, 'index'])->name('customers.index');
    Route::get('{customer}', [CustomersController::class, 'show'])->name('customers.show');
    Route::put('{customer}', [CustomersController::class, 'update'])->name('customers.update');
    Route::delete('{customer}', [CustomersController::class, 'destroy'])->name('customers.destroy');
});

