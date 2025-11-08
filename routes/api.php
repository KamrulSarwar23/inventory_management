<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\PurchaseController;
// use App\Http\Controllers\api\OrderController;
use App\Http\Controllers\api\InvoiceController;



Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


// Route::apiResources([
//     'purchases'=>PurchaseController::class,
//     'orders'=>OrderController::class,
//     'invoices'=>InvoiceController::class,
    
// ]);

// Route::post('/invoices', [InvoiceController::class, 'store']);