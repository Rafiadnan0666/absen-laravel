<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserActive
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && $user->status_akun !== 'active') {
            return response()->json([
                'message' => 'Account is inactive. Please contact administrator.'
            ], 401);
        }

        return $next($request);
    }
}