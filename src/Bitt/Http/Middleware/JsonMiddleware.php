<?php

namespace Bitt\Http\Middleware;

use Bitt\Http\Request;
use Bitt\Http\Response;

class JsonMiddleware implements MiddlewareInterface
{
    public function process(Request $request, Response $response, callable $next): Response
    {
        if ($request->getContentType() === "application/json") {
            $raw = file_get_contents('php://input');
            $jsonDecoded = json_decode($raw, true) ?? [];
            $request->body = new \Bitt\Http\Parameter($jsonDecoded);
        }
        return $next($request, $response);
    }
}
