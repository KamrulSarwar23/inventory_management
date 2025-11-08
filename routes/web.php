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
use App\Http\Controllers\InvoiceController;

Route::get('/', function () {
    return view('pages.Dashboard.home');
});

Route::resource('categories', CategoryController::class);
Route::resource('products', ProductController::class);
Route::resource('customers', CustomerController::class);
Route::resource('warehouses', WarehouseController::class);
Route::resource('suppliers', SupplierController::class);
Route::resource('shippers', ShipperController::class);

Route::resource('purchases', PurchaseController::class);
Route::get('/purchases/{id}/delete',[PurchaseController::class,'delete']);

Route::resource('orders', OrderController::class);
Route::get('/orders/{id}/delete',[OrderController::class,'delete']);

Route::resource('invoices',InvoiceController::class);
Route::get('/invoices/{id}/delete',[InvoiceController::class,'delete']);