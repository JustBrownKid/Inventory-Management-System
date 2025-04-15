<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\DashboardController;



Route::get('/', function () {
    return view('welcome');
});

Route::get('/graph', [DashboardController::class, 'index']);

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


Route::get('/category', [CategoryController::class, 'index'])
->name('category');
Route::get('/category/{id}/edit', [CategoryController::class, 'edit'])
->name('category.edit');
Route::put('/category/{id}', [CategoryController::class, 'update'])
->name('category.update');
Route::post('/category/store', [CategoryController::class, 'store'])
->name('category.store');
Route::delete('/categories/{id}/delete', [CategoryController::class, 'destroy'])
->name('category.delete');


Route::get('/customer', [CustomerController::class, 'index'])
->name('customer');
Route::get('/customer/list', [CustomerController::class, 'list'])
->name('customer.list');
Route::get('/customer/{id}/edit', [CustomerController::class, 'edit'])
->name('customer.edit');
Route::put('/customer/{id}', [CustomerController::class, 'update'])
->name('customer.update');
Route::post('/customer/store', [CustomerController::class, 'store'])
->name('customer.store');
Route::delete('/customer/{id}/delete', [CustomerController::class, 'destroy'])
->name('customer.delete');


Route::get('/supplier', [SupplierController::class, 'index'])
->name('supplier');
Route::get('/supplier/list', [SupplierController::class, 'list'])
->name('supplier.list');
Route::get('/supplier/{id}/edit', [SupplierController::class, 'edit'])
->name('supplier.edit');
Route::put('/supplier/{id}', [SupplierController::class, 'update'])
->name('supplier.update');
Route::post('/supplier/store', [SupplierController::class, 'store'])
->name('supplier.store');
Route::delete('/supplier/{id}/delete', [SupplierController::class, 'destroy'])
->name('supplier.delete');


Route::get('/purchases', [PurchaseController::class, 'index'])
->name('purchases');
Route::get('/purchases/list', [PurchaseController::class, 'list'])
->name('purchases.list');
Route::get('/purchases/{id}/edit', [PurchaseController::class, 'edit'])
->name('purchases.edit');
Route::get('/purchases/{id}', [PurchaseController::class, 'update'])
->name('purchases.show');
Route::put('/purchases/{id}', [PurchaseController::class, 'update'])
->name('purchases.update');
Route::post('/purchases/store', [PurchaseController::class, 'store'])
->name('purchases.store');
Route::delete('/purchases/{id}/delete', [PurchaseController::class, 'destroy'])
->name('purchases.delete');


Route::get('/sales/create', [SalesController::class, 'index'])
->name('sales');
Route::get('/sales/list', [SalesController::class, 'list'])
->name('sales.list');
Route::get('/sales/{id}/edit', [SalesController::class, 'edit'])
->name('sales.edit');
Route::get('/pursaleschases/{id}', [SalesController::class, 'show'])
->name('sales.show');
Route::put('/sales/{id}', [SalesController::class, 'update'])
->name('sales.update');
Route::post('/sales/store', [SalesController::class, 'store'])
->name('sales.store');
Route::delete('/sales/{id}/delete', [SalesController::class, 'destroy'])
->name('sales.delete');


require __DIR__.'/auth.php';
