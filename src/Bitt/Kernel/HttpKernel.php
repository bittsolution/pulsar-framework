<?php

namespace Bitt\Kernel;

use Bitt\Http\ControllerResolver;
use Bitt\Http\Middleware\CookieMiddleware;
use Bitt\Http\Middleware\CorsMiddleware;
use Bitt\Http\Middleware\LoggerMiddleware;
use Bitt\Http\Middleware\MiddlewarePipeline;
use Bitt\Http\Request;
use Bitt\Http\Response;
use Bitt\Http\RouterInterface;

class HttpKernel implements KernelInterface
{
    private MiddlewarePipeline $pipeline;

    public function __construct(
        private RouterInterface $router
    ) {
        $this->pipeline = new MiddlewarePipeline(
            new ControllerResolver()
        );
    }

    public function handle(Request $request, Response $response): Response
    {
        $route = $this->router->match($request);
        $this->pipeline->setMiddlewares(array_merge($this->frameworkMiddlewares(), $route->middlewares()));
        return $this->pipeline->handle($request, $response, $route);
    }

    private function frameworkMiddlewares(): array
    {
        return [
            CorsMiddleware::class,
            CookieMiddleware::class,
            LoggerMiddleware::class,
        ];
    }
}
