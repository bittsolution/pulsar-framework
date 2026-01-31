<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\TestController;
use Bitt\Http\Router;

$router = new Router();

$router->add('GET', '/', HomeController::class, []);
$router->add('GET', '/test', TestController::class, []);

return $router;
