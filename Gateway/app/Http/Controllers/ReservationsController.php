<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App\Models\Reservation;

class ReservationsController extends Controller
{
    protected $apiUrl;
    protected $apiUrlPagos;
    protected $apiKey;

    public function __construct()
    {
        $this->apiUrl = env('MICROSERVICIO_RESERVACIONES');
        $this->apiUrlPagos = env('MICROSERVICIO_PAGOS');
        $this->apiKey = env('API_KEY');
    }

    public function index()
    {
        $url = $this->apiUrl . '/reservations/';
        $response = Http::withHeaders(['X-API-Key' => $this->apiKey])->get($url);
        return $response->json();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function store(Request $request)
    {
        $url = $this->apiUrlPagos . '/procesar_pago';
        $response = Http::withHeaders(['X-API-Key' => $this->apiKey])->post($url, $request->all());
        return $response->json();
    }

    public function storeUser(Request $request)
    {
        $request->user_id = Auth::id();
        $url = $this->apiUrlPagos . '/procesar_pago';
        $response = Http::withHeaders(['X-API-Key' => $this->apiKey])->post($url, $request->all());
        return $response->json();
    }

    /**
     * Store a newly created resource in storage.
     */

    /**
     * Display the specified resource.
     */
    public function showUser()
    {
        $id = Auth::id();
        $url = $this->apiUrl . '/reservations/'. $id;
        $response = Http::withHeaders(['X-API-Key' => $this->apiKey])->get($url);
        return $response->json();
    }

    public function show(int $id)
    {
        $url = $this->apiUrl . '/reservations/'. $id;
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
    public function update(Request $request, int $id)
    {
        $url = $this->apiUrl . '/reservations/'. $id;
        $response = Http::withHeaders(['X-API-Key' => $this->apiKey])->put($url, $request->all());
        return $response->json();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroyUser(int $id)
    {
        $reservation = Reservation::find($id);
        $user = Auth::id();
        // Validar que exista
        if (!$reservation) {
            return response()->json(['message' => 'Reservación no encontrada'], 404);
        }

        
        if ($reservation->user_id !== $user) {
            return response()->json(['message' => 'No tienes permiso para cancelar esta reservación'], 403);
        }

        $url = $this->apiUrl . '/reservationsUser/'. $id;
        $response = Http::withHeaders(['X-API-Key' => $this->apiKey])->delete($url);
        return $response->json();
        
        
        
    }

    public function destroy(string $id)
    {
        $url = $this->apiUrl . '/reservations/'. $id;
        $response = Http::withHeaders(['X-API-Key' => $this->apiKey])->delete($url);
        return $response->json();
    }
}
