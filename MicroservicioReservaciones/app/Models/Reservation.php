<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $table = 'reservations';
    
    protected $fillable = [
        'room_id', 'user_id',
        'check_in_date', 'check_out_date', 'total_price', 'status'
    ];
}
