<?php

use App\Controllers\ProductController;
use App\Controllers\AuthController;
use App\Controllers\OrderController;

return [
    ['GET', '/products', [ProductController::class, 'index']],
    ['GET', '/products/{id}', [ProductController::class, 'show']],

    ['POST', '/register', [AuthController::class, 'register']],
    ['POST', '/login', [AuthController::class, 'login']],

    ['POST', '/orders', [OrderController::class, 'store']],
    ['GET', '/orders/me', [OrderController::class, 'myOrders']],
];
