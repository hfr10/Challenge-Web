<?php

namespace App\Middleware;

use App\Core\Request;

class CorsMiddleware
{
    private array $allowedOrigins;
    private array $allowedMethods;
    private array $allowedHeaders;
    private bool $allowCredentials;

    public function __construct()
    {
        $this->allowedOrigins = $this->getAllowedOrigins();
        $this->allowedMethods = ['GET', 'POST', 'PUT', 'DELETE', 'PATCH', 'OPTIONS'];
        $this->allowedHeaders = ['Content-Type', 'Authorization', 'X-Requested-With'];
        $this->allowCredentials = true;
    }

    private function getAllowedOrigins(): array
    {
        $origins = $_ENV['CORS_ALLOWED_ORIGINS'] ?? 'http://localhost:5173';
        return array_map('trim', explode(',', $origins));
    }

    public function handle(Request $request, callable $next): mixed
    {
        $origin = $request->header('Origin', '');

        if ($this->isAllowedOrigin($origin)) {
            header("Access-Control-Allow-Origin: {$origin}");
        } else if (empty($this->allowedOrigins) || in_array('*', $this->allowedOrigins)) {
            header('Access-Control-Allow-Origin: *');
        }

        if ($this->allowCredentials) {
            header('Access-Control-Allow-Credentials: true');
        }

        header('Access-Control-Allow-Methods: ' . implode(', ', $this->allowedMethods));
        header('Access-Control-Allow-Headers: ' . implode(', ', $this->allowedHeaders));
        header('Access-Control-Max-Age: 86400');

        if ($request->isMethod('OPTIONS')) {
            http_response_code(200);
            exit;
        }

        return $next($request);
    }

    private function isAllowedOrigin(string $origin): bool
    {
        return in_array($origin, $this->allowedOrigins);
    }
}
