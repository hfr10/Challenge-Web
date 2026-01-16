<?php

namespace App\Controllers;

use App\Services\AuthService;
use App\Core\Response;

class AuthController
{
    private AuthService $service;

    public function __construct()
    {
        $this->service = new AuthService();
    }

    public function register(): void
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $this->service->register($data['email'], $data['password']);
        Response::json(['message' => 'User created'], 201);
    }

    public function login(): void
    {
        $data = json_decode(file_get_contents('php://input'), true);

        if (!$this->service->login($data['email'], $data['password'])) {
            Response::json(['message' => 'Invalid credentials'], 401);
            return;
        }

        Response::json(['message' => 'Login successful']);
    }
}
