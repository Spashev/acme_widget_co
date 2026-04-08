<?php

use App\Controllers\CartController;
use App\Controllers\IndexController;

$dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $r) {
    $r->addRoute('GET', '/', IndexController::class . '/home');
    
    $r->addRoute('POST', '/cart/add', CartController::class . '/addItem');
});
