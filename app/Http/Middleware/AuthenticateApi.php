<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class AuthenticateApi
{
    /**
     * @param Request $request
     * @param Closure $next
     * @return ResponseAlias
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->header('Authorization');

        if ($token !== 'Bearer ' . env('BLOCKCHAIN_INFO_BEARER_TOKEN')) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid token',
            ], ResponseAlias::HTTP_UNAUTHORIZED);
        }

        return $next($request);
    }
}
