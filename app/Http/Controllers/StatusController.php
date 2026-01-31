<?php

namespace App\Http\Controllers;

use Bitt\Http\Request;
use Bitt\Http\Response;
use Bitt\Logger\LoggerInterface;

class StatusController
{
    public function __construct(private LoggerInterface $logger) {}

    public function __invoke(Request $req, Response $res): Response
    {
        return $res->json(["status" => "( •_•) API is running!"]);
    }
}
