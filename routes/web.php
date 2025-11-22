<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

Route::get('/', [ProductController::class, 'index'])->name('products.index');
Route::get('/products', [ProductController::class, 'fetch'])->name('products.fetch');

Route::post('/product/store', [ProductController::class, 'store'])->name('products.store');
Route::get('/product/edit/{id}', [ProductController::class, 'edit'])->name('products.edit');
Route::put('/product/update/{id}', [ProductController::class, 'update'])->name('products.update');
Route::delete('/product/delete/{id}', [ProductController::class, 'destroy'])->name('products.destroy');
