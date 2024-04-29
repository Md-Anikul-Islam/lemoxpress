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
        'total_fare',
        'is_complete'
    ];

    public function driver()
    {
        return $this->belongsTo(Driver::class, 'driver_id', 'did');
    }

}
