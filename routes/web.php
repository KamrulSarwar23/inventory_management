<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Inventory\ProductController;
use App\Http\Controllers\Inventory\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\ShipperController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;

Route::middleware('guest')->group(function () {

    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

});

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'profile'])->name('profile.index');
    Route::post('/profile/update', [ProfileController::class, 'updateProfile'])->name('profile.update');
    Route::post('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

Route::resource('products', ProductController::class);
Route::resource('categories', CategoryController::class);
Route::resource('customers', CustomerController::class);
Route::resource('warehouses', WarehouseController::class);
Route::resource('suppliers', SupplierController::class);
Route::resource('shippers', ShipperController::class);

Route::resource('orders', OrderController::class);
Route::get('/orders/{id}/delete',[OrderController::class,'delete']);

Route::resource('purchases', PurchaseController::class);
Route::get('/purchases/{id}/delete',[PurchaseController::class,'delete']);

Route::resource('invoices',InvoiceController::class);
Route::get('/invoices/{id}/delete',[InvoiceController::class,'delete']);
});


