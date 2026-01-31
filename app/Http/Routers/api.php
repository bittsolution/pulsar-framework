<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\TestController;
use Bitt\Http\Middleware\CookieMiddleware;
use Bitt\Http\Middleware\CorsMiddleware;
use Bitt\Http\Middleware\LoggerMiddleware;
use Bitt\Kernel\Router;

$router = new Router();

$router->add('GET', '/', HomeController::class, [
    CookieMiddleware::class,
    LoggerMiddleware::class,
    CorsMiddleware::class
]);

$router->add('GET', '/test', TestController::class, [
    CookieMiddleware::class,
    LoggerMiddleware::class,
    CorsMiddleware::class
]);

return $router;
