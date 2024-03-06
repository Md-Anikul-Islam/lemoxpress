<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fleet extends Model
{
    use HasFactory;
    protected $fillable = [
        'fleet_type_id',
        'model',
        'color',
        'number',
        'base_fare_amount',
        'status',
    ];

    public function fleetType()
    {
        return $this->belongsTo(FleetType::class);
    }
}
