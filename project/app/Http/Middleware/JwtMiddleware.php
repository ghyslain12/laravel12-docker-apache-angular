<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Exception;

class JwtMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $token = $request->bearerToken();

        if (!$token) {
            return response()->json(['error' => 'Token non fourni'], 401);
        }

        try {
            $key = env('JWT_SECRET');
            $decoded = JWT::decode($token, new Key($key, 'HS256')); // Décodage du token
            $request->attributes->add(['user' => (array) $decoded]); // Optionnel : Ajoute les données décodées à la requête
        } catch (Exception $e) {
            return response()->json(['error' => 'Token invalide ou expiré'], 401);
        }

        return $next($request);
    }
}
