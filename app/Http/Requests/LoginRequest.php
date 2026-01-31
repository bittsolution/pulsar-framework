<?php

namespace App\Http\Requests;

use Bitt\Http\CustomRequest;

class LoginRequest extends CustomRequest
{
    public function rules(): array
    {
        return [
            'email' => ['required'],
            'password' => ['required'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    public function email(): string
    {
        return $this->input('email');
    }

    public function password(): string
    {
        return $this->input('password');
    }
}
