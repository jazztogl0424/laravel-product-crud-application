<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductWebController;
use App\Http\Controllers\Api\ProductController;

Route::get('/', function () {
    return redirect()->route('products.index');
});

Route::resource('products', ProductWebController::class);

Route::get('/api-export/products', [ProductController::class, 'export'])->name('api.products.export');
