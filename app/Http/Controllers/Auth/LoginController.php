<?php

namespace App\Http\Controllers\Auth;

use Bitt\Http\Request;
use Bitt\Http\Response;

class LoginController
{
    public function __invoke(Request $req, Response $res): Response
    {
        $email = $req->body->get("email");
        $password = $req->body->get("password");

        return $res->json([
            "email" => $email,
            "password" => $password,
        ]);
    }
}
