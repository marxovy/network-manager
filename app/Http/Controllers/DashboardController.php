<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Inertia\Inertia; // Import Inertia class to render components

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $resourceUrl = env('API_URL') . addslashes('/services');

        $servicesResponse = Http::withHeaders([
            'Accept' => 'application/vnd.cloudlx.v1+json',
            'Authorization' => 'Bearer ' . $request->session()->get('access_token')
        ])->get($resourceUrl);

        return Inertia::render('Dashboard', ['services' => $servicesResponse['services']]);
    }

    public function show(Request $request, string $id)
    {
        $resourceUrl = env('API_URL') . addslashes('/services/') . $id . '/service';

        $serviceResponse = Http::withHeaders([
            'Accept' => 'application/vnd.cloudlx.v1+json',
            'Authorization' => 'Bearer ' . $request->session()->get('access_token')
        ])->get($resourceUrl);

        return Inertia::render('Service', ['service' => $serviceResponse->json()]);
    }
}