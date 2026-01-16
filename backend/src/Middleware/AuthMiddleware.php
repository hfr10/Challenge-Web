<?php

namespace App\Middleware;

use App\Core\Request;
use App\Core\Response;
use App\Services\AuthService;

class AuthMiddleware
{
    private AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function handle(Request $request, callable $next): mixed
    {
        $token = $request->bearerToken();

        if (!$token) {
            Response::json([
                'error' => 'Token non fourni',
                'message' => 'Vous devez être authentifié pour accéder à cette ressource'
            ], 401);
            exit;
        }

        $user = $this->authService->validateToken($token);

        if (!$user) {
            Response::json([
                'error' => 'Token invalide ou expiré',
                'message' => 'Votre session a expiré, veuillez vous reconnecter'
            ], 401);
            exit;
        }

        $request->user = $user;

        return $next($request);
    }
}
