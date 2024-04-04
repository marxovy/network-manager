<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Inertia\Middleware;
use Symfony\Component\HttpFoundation\Response;

class EnsureTokenIsValid extends Middleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $refreshAuthUrl = env('API_URL') . '/oauth2/refresh-token';

        if( session('access_token_expires_in') < time() ) {
            $response = Http::withHeaders([
                'Accept' => 'application/vnd.cloudlx.v1+json',
            ])->post($refreshAuthUrl, [
                'refresh_token' => $request->session()->get('refresh_token'),
                'grant_type' => 'refresh_token',
                'client_id' => env('CLIENT_ID'),
                'client_secret' => env('CLIENT_SECRET')
            ]);

            $request->session()->put('access_token', $response['access_token']);
            $request->session()->put('access_token_expires_in', time() + $response['expires_in']);
            $request->session()->put('refresh_token', $response['refresh_token']);
        }
        return $next($request);
    }
}
