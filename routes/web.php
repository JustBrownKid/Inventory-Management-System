<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/dashboard', [ProductController::class, 'index'])
->middleware(['auth', 'verified'])
->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])
    ->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])
    ->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy']
    )->name('profile.destroy');
});

Route::post('/product', [ProductController::class, 'store'])
->name('products.store');
Route::put('/product/{id}', [ProductController::class, 'update'])
->name('products.update');
Route::delete('/product/{id}/delete', [ProductController::class, 'destroy'])
->name('products.delete');
Route::get('/products/{id}/edit', [ProductController::class, 'edit'])
->name('products.edit');
Route::get('/product/list', [ProductController::class, 'list'])
->name('products.list');






require __DIR__.'/auth.php';
