<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the user is authenticated via Sanctum
        if (Auth::guard('sanctum')->check()) {
            return $next($request);
        }
        return response()->json([
            "message" => "Unauthorized",
        ], HttpResponse::HTTP_UNAUTHORIZED);
    }
}
