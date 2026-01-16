<?php

namespace App\Middleware;

use App\Core\Request;
use App\Core\Response;

class AdminMiddleware
{
    public function handle(Request $request, callable $next): mixed
    {
        if (!isset($request->user)) {
            Response::json([
                'error' => 'Non authentifié',
                'message' => 'Vous devez être authentifié pour accéder à cette ressource'
            ], 401);
            exit;
        }

        if ($request->user['role'] !== 'admin') {
            Response::json([
                'error' => 'Accès refusé',
                'message' => 'Vous devez être administrateur pour accéder à cette ressource'
            ], 403);
            exit;
        }

        return $next($request);
    }
}
