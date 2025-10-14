<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;

class PaysMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        Log::info('Entró al Middleware');
        $ApiKeyReceived = $request->header("X-API-key");
        $ApiKey = env("API_KEY");
        if ($ApiKeyReceived !== $ApiKey ){
            return response()->json(["message"=>"Acceso Denegado"], 403);
        }
        return $next($request);
    }
}
