<?php

use App\Controllers\CartController;
use App\Controllers\IndexController;

$dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $r) {
    $r->addRoute('GET', '/', IndexController::class . '/home');
    
    $r->addRoute('POST', '/cart/add', CartController::class . '/addItem');
    $r->addRoute('POST', '/cart/{cartId:\d+}/add', CartController::class . '/addItem');
    $r->addRoute('GET', '/cart/{cartId:\d+}', CartController::class . '/getCartTotal');
    $r->addRoute('POST', '/cart/{cartId:\d+}/delete', CartController::class . '/deleteCart');
});
