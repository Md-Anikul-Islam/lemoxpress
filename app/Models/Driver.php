<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    use HasFactory;

    protected $fillable = [
        'did',
        'car_id',
        'name',
        'email',
        'gender',
        'dob',
        'phone',
        'address',
        'profile',
        'driving_licence_font_image',
        'driving_licence_back_image',
        'rta_card_font_image',
        'rta_card_back_image',
        'ratting',
        'status',
    ];

    protected $casts = [
        'car_id' => 'integer',
    ];
    public function driverHistory()
    {
        return $this->hasMany(DriverHistory::class, 'did', 'did');
    }



    public function car()
    {
        return $this->belongsTo(Fleet::class, 'car_id');
    }

    public function tripRequest()
    {
        return $this->hasMany(TripRequest::class, 'driver_id');
    }
}
