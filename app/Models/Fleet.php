<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fleet extends Model
{
    use HasFactory;
    protected $fillable = [
        'car_type_id',
        'car_name',
        'car_model',
        'car_color',
        'car_base',
        'car_image',
        'passengers',
        'status',
    ];

    public function fleetType()
    {
        return $this->belongsTo(FleetType::class, 'car_type_id');
    }
}
