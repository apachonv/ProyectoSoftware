<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use Illuminate\Support\Facades\Log;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rooms = Reservation::all();
        return response()->json($rooms);
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        Log::info('Entró al show');
        $reservations = Reservation::where('user_id', $id)->get();
        return response()->json($reservations); 
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
        $reservation = Reservation::find($id);
        if (!$reservation) {
            return response()->json([
                'success' => false,
                'message' => 'Reservacion no encontrada.'
            ], 404);
        }
        $reservation->room_id = $request->room_id;
        $reservation->user_id = $request->user_id;
        $reservation->check_in_date = $request->check_in_date;
        $reservation->check_out_date = $request->check_out_date;
        $reservation->total_price = $request->total_price;
        $reservation->save();
        return response()->json(['message'=> 'Se modfico', $reservation]); 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $reservation = Reservation::find($id);
        $reservation->delete();
        return response()->json(['message' => 'Reservacion eliminada']);
    }

    public function destroyUser(string $id)
    {
        $reservation = Reservation::find($id);
        $reservation->status = 'cancelled';
        $reservation->save();
        return response()->json(['message' => 'Reservación cancelada correctamente']);
    }
}
