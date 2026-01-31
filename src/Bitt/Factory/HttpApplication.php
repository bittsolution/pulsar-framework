<?php

namespace Bitt\Factory;

use Bitt\Http\Request;
use Bitt\Http\Response;
use Bitt\Kernel\HttpKernel;
use Bitt\Kernel\Router;

class HttpApplication implements ApplicationInterface
{
    private Router $router;

    public function __construct()
    {
        $this->router = new Router();
    }

    private function initialize(): void
    {
        config();
        container();
    }

    public function boot(): void
    {
        $this->initialize();
    }

    public function run(): void
    {
        $this->boot();
        $request = Request::fromGlobals();
        $response = new Response("", 200);

        $kernel = new HttpKernel($this->router);
        $kernel->handle($request, $response)->send();
    }

    public function setRouter(Router $router): void
    {
        $this->router = $router;
    }

    public function addRoute(
        string $method,
        string $path,
        mixed $controller,
        array $middlewares = []
    ) {
        $this->router->add($method, $path, $controller, $middlewares);
    }
}
