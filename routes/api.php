<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\OrderController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


//Auth
Route::prefix('auth')->group(function () {

    Route::post('/login', [LoginController::class, 'postlogin']);
    Route::get('/me', [LoginController::class, 'me'])->middleware(['auth:sanctum']);

});

//
Route::middleware(['auth:sanctum'])->group(function () {

    //Users (Manager)
    Route::post('/user', [UserController::class, 'store'])->middleware(['ceklevel']);

    //Items
    Route::get('/item', [ItemController::class, 'index']);
    Route::post('/create-item', [ItemController::class, 'store']);
    Route::post('/update-item/{id}', [ItemController::class, 'update']);
    Route::post('/delete-item/{id}', [ItemController::class, 'destroy']);

    //Orders
    Route::get('/order', [OrderController::class, 'index']);
    Route::get('/order/{id}', [OrderController::class, 'show']);
    Route::get('/order/{id}/payment', [OrderController::class, 'payment']);
    Route::post('/create-order', [OrderController::class, 'store']);
    Route::post('/update-order/{id}', [OrderController::class, 'update']);
    Route::post('/delete-order/{id}', [OrderController::class, 'destroy']);

    //Laporan (Manager)
    Route::post('/laporan', [LaporanController::class, 'index'])->middleware('ceklevel');

});
