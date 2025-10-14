<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class RoomsController extends Controller
{
    protected $apiUrl;
    protected $apiKey;

    public function __construct()
    {
        $this->apiUrl = env('MICROSERVICIO_HABITACIONES');
        $this->apiKey = env('API_KEY');
    }

    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        $url = $this->apiUrl . '/rooms/';
        $response = Http::withHeaders(['X-API-Key' => $this->apiKey])->get($url);
        return $response->json();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $url = $this->apiUrl . '/rooms/';
        
        $response = Http::withHeaders(['X-API-Key' => $this->apiKey])->post($url, $request->all());
        //dd($response->status(), $response->body());
        return $response->json();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $url = $this->apiUrl . '/rooms/'. $id;
        $response = Http::withHeaders(['X-API-Key' => $this->apiKey])->get($url);
        return $response->json();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $url = $this->apiUrl . '/rooms/'. $id;
        $response = Http::withHeaders(['X-API-Key' => $this->apiKey])->put($url, $request->all());
        return $response->json();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $url = $this->apiUrl . '/rooms/'. $id;
        $response = Http::withHeaders(['X-API-Key' => $this->apiKey])->delete($url);
        return $response->json();
    }
}
