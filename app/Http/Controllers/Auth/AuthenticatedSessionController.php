<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Inertia\Response;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Login', [
            'canResetPassword' => Route::has('password.request'),
            'status' => session('status'),
        ]);
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $authURl = env('API_URL') . '/oauth2/access-token';

        $response = Http::withHeaders([
            'Accept' => 'application/vnd.cloudlx.v1+json',
        ])->post($authURl, [
            'grant_type' => 'client_credentials',
            'client_id' => env('CLIENT_ID'),
            'client_secret' => env('CLIENT_SECRET')
        ]);

        $request->session()->regenerate();

        $request->session()->put('access_token', $response['access_token']);
        $request->session()->put('access_token_expires_in', time() + $response['expires_in']);
        $request->session()->put('refresh_token', $response['refresh_token']);

        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
