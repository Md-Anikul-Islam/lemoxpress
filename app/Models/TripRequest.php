<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TripRequest extends Model
{
    use HasFactory;
    protected $fillable = [
        'driver_id',
        'passenger_name',
        'passenger_phone',
        'origin_address',
        'destination_address',
        'time',
        'estimated_fare',
        'calculated_fare',
        'fare_received_status',
        'is_complete',
        'trip_type'
    ];

    public function driver()
    {
        return $this->belongsTo(Driver::class, 'driver_id', 'did');
    }

    public function userHistories()
    {
        return $this->hasMany(UserHistory::class, 'did', 'driver_id');
    }

}
