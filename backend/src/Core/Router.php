<?php

namespace App\Core;

class Router
{
    private array $routes = [];

    public function __construct()
    {
        // volontairement vide
    }

    public function get(string $path, callable $handler): void
    {
        $this->routes['GET'][$path] = $handler;
    }

    public function post(string $path, callable $handler): void
    {
        $this->routes['POST'][$path] = $handler;
    }

    public function put(string $path, callable $handler): void
    {
        $this->routes['PUT'][$path] = $handler;
    }

    public function delete(string $path, callable $handler): void
    {
        $this->routes['DELETE'][$path] = $handler;
    }

    public function patch(string $path, callable $handler): void
    {
        $this->routes['PATCH'][$path] = $handler;
    }

    public function dispatch(string $method, string $uri): void
    {
        $uri = parse_url($uri, PHP_URL_PATH);

        foreach ($this->routes[$method] ?? [] as $route => $handler) {
            $pattern = "#^" . preg_replace('#\{id\}#', '(\d+)', $route) . "$#";

            if (preg_match($pattern, $uri, $matches)) {
                array_shift($matches);
                call_user_func_array($handler, $matches);
                return;
            }
        }

        // If it's an API route (starts with /api/ or known API paths), return 404
        if ($this->isApiRoute($uri)) {
            http_response_code(404);
            echo json_encode([
                'error' => 'Route not found',
                'method' => $method,
                'uri' => $uri
            ]);
            return;
        }

        // For non-API routes (frontend routes), return 200 so frontend router can handle them
        http_response_code(200);
        echo json_encode([
            'redirect' => true,
            'message' => 'Frontend will handle this route'
        ]);
    }

    private function isApiRoute(string $uri): bool
    {
        $apiPaths = [
            '/auth',
            '/products',
            '/cart',
            '/orders',
            '/users',
            '/admin',
            '/test',
        ];

        foreach ($apiPaths as $path) {
            if (strpos($uri, $path) === 0) {
                return true;
            }
        }

        return false;
    }
}
