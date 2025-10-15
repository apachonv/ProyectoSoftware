<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Models\Reservation;

class ReservationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         Reservation::insert([
            [
                'room_id' => 1,
                'user_id' => 3,
                'check_in_date' => Carbon::now()->addDays(1)->format('Y-m-d'),
                'check_out_date' => Carbon::now()->addDays(3)->format('Y-m-d'),
                'total_price' => 120000.00 * 2, // 2 noches
                'status' => 'confirmed',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'room_id' => 2,
                'user_id' => 4,
                'check_in_date' => Carbon::now()->addDays(5)->format('Y-m-d'),
                'check_out_date' => Carbon::now()->addDays(8)->format('Y-m-d'),
                'total_price' => 100000.00 * 3, // 3 noches
                'status' => 'pending',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'room_id' => 3,
                'user_id' => 5,
                'check_in_date' => Carbon::now()->subDays(10)->format('Y-m-d'),
                'check_out_date' => Carbon::now()->subDays(7)->format('Y-m-d'),
                'total_price' => 180000.00 * 3,
                'status' => 'completed',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'room_id' => 4,
                'user_id' => 3,
                'check_in_date' => Carbon::now()->addDays(2)->format('Y-m-d'),
                'check_out_date' => Carbon::now()->addDays(4)->format('Y-m-d'),
                'total_price' => 200000.00 * 2,
                'status' => 'cancelled',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'room_id' => 5,
                'user_id' => 4,
                'check_in_date' => Carbon::now()->addDays(7)->format('Y-m-d'),
                'check_out_date' => Carbon::now()->addDays(10)->format('Y-m-d'),
                'total_price' => 130000.00 * 3,
                'status' => 'pending',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
