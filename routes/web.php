<?php

use App\Models\Order;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;

Route::get('/', function() {

    $order = Order::find(2);
    return response(['data' => $order->sumOrderPrice()]);

});
