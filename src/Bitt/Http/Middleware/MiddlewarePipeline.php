<?php

namespace Bitt\Http\Middleware;

use Bitt\Http\ControllerArgumentResolver;
use Bitt\Http\Request;
use Bitt\Http\Response;
use Bitt\Http\Route;
use Bitt\Http\ControllerResolver;

final class MiddlewarePipeline
{
    private array $middlewares = [];

    public function __construct(
        private ControllerResolver $resolver
    ) {}

    public function setMiddlewares(array $middlewares): void
    {
        $this->middlewares = $middlewares;
    }

    public function handle(Request $request, Response $response, Route $route): Response
    {
        $next = fn(Request $req, Response $res) => $this->callController($route, $req, $res);

        foreach (array_reverse($this->middlewares) as $middleware) {
            $next = function (Request $req, Response $res) use ($middleware, $next) {
                $instance = container()->get($middleware);
                return $instance->process($req, $res, $next);
            };
        }

        return $next($request, $response);
    }

    private function callController(Route $route, Request $request, Response $response): Response
    {
        $controller = $this->resolver->resolve($route);
        $argumentResolver = new ControllerArgumentResolver();
        $requestResolved = $argumentResolver->resolve($controller, $request);
        return $controller($requestResolved, $response);
    }
}
