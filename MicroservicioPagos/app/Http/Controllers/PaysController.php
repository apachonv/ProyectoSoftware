<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Room;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use DB;

class PaysController extends Controller
{
    protected $apiUrl;
    protected $apiUrlPagos;
    protected $apiKey;

    public function __construct()
    {
        $this->apiUrl = env('MICROSERVICIO_RESERVACIONES');
        $this->apiUrlPagos = env('MICROSERVICIO_NOTIFICACIONES');
        $this->apiKey = env('API_KEY');
    }
    public function payAndReserve(Request $request)
    {
        $user_id = $request->user_id;
        $room_id = $request->room_id;
        $check_in = $request->check_in_date;
        $check_out = $request->check_out_date;

        $overlapping = Reservation::where('room_id', $room_id)
            ->where('status', '!=', 'cancelled')
            ->where(function ($query) use ($check_in, $check_out) {
                $query->whereBetween('check_in_date', [$check_in, $check_out])
                      ->orWhereBetween('check_out_date', [$check_in, $check_out])
                      ->orWhere(function ($q) use ($check_in, $check_out) {
                          $q->where('check_in_date', '<=', $check_in)
                            ->where('check_out_date', '>=', $check_out);
                      });
            })->exists();

        if ($overlapping) {
            return response()->json(['message' => 'La habitación ya está ocupada en esas fechas.'], 400);
        }

        
        $room = Room::find($room_id);
        if (!$room) {
            return response()->json(['message' => 'Habitación no encontrada.'], 404);
        }

        $price_per_night = $room->price_per_night;

        $check_in_date = Carbon::parse($check_in);
        $check_out_date = Carbon::parse($check_out);
        $nights = $check_out_date->diffInDays($check_in_date);
        $total_price = $price_per_night * $nights;

        
        $user = User::find($user_id);
        if (!$user) {
            return response()->json(['message' => 'Usuario no encontrado.'], 404);
        }

        if ($user->fondos < $total_price) {
            return response()->json(['message' => 'Fondos insuficientes.'], 400);
        }

        DB::beginTransaction();

        try {
            $user->fondos -= $total_price;
            $user->save();

            $url = $this->apiUrl . '/reservations/';
            $response = Http::withHeaders(['X-API-Key' => $this->apiKey])->post($url, $request->all());
            return $response->json();

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Error procesando la reserva.', 'error' => $e->getMessage()], 500);
        }
    }
}
