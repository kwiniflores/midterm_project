<?php
// routes/web.php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleController;
use Illuminate\Support\Facades\Route;

Route::get('/ ', function () {
    Return redirect()->route('sales.index');
});

// Customer Routes
Route::resource('customers', CustomerController::class);

// Product Routes  
Route::resource('products', ProductController::class);

// Sale Routes
Route::resource('sales', SaleController::class);

// API Routes for AJAX requests
Route::get('/api/products/{product}', function ($id) {
    $product = \App\Models\Product::find($id);
    return response()->json($product);
})->name('api.products.show');