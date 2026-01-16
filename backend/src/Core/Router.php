<?php

namespace App\Core;

class Router
{
    private array $routes;

    public function __construct(array $routes)
    {
        $this->routes = $routes;
    }

    public function dispatch(): void
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        foreach ($this->routes as [$routeMethod, $routePath, $action]) {
            $pattern = preg_replace('#\{[a-zA-Z]+\}#', '([0-9]+)', $routePath);
            $pattern = "#^$pattern$#";

            if ($method === $routeMethod && preg_match($pattern, $uri, $matches)) {
                array_shift($matches);

                [$controller, $methodAction] = $action;
                (new $controller())->$methodAction(...$matches);
                return;
            }
        }

        http_response_code(404);
        echo json_encode(['message' => 'Route not found']);
    }
}
