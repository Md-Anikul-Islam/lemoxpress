<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TripRequest extends Model
{
    use HasFactory;
    protected $fillable = [
        'driver_id',
        'fleet_id',
        'origin_address',
        'destination_address',
        'time',
        'total_fare',
    ];
}
