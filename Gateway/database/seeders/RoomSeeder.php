<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Room;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Room::insert([
            [
                'room_number' => 101,
                'type' => 'Individual',
                'description' => 'Habitación individual con baño privado y TV por cable.',
                'price_per_night' => 120000.00,
                'status' => 'Desocupada',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'room_number' => 102,
                'type' => 'Individual',
                'description' => 'Habitación sencilla con vista al jardín.',
                'price_per_night' => 100000.00,
                'status' => 'Ocupada',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'room_number' => 201,
                'type' => 'Doble',
                'description' => 'Habitación doble con aire acondicionado y balcón.',
                'price_per_night' => 180000.00,
                'status' => 'Desocupada',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'room_number' => 202,
                'type' => 'Doble',
                'description' => 'Habitación doble ideal para familias, con minibar incluido.',
                'price_per_night' => 200000.00,
                'status' => 'Mantenimiento',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'room_number' => 301,
                'type' => 'Individual',
                'description' => 'Habitación moderna con escritorio y buena iluminación.',
                'price_per_night' => 130000.00,
                'status' => 'Desocupada',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    
    }
}
