<?php

use App\Controllers\IndexController;

$dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $r) {
    $r->addRoute('GET', '/', IndexController::class . '/home');
});
