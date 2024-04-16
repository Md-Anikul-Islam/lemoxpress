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
        'customer_name',
        'customer_phone',
        'origin_address',
        'destination_address',
        'time',
        'total_fare',
    ];

    public function driver()
    {
        return $this->belongsTo(Driver::class, 'driver_id', 'did');
    }

    public function fleet()
    {
        return $this->belongsTo(Fleet::class);
    }
}
