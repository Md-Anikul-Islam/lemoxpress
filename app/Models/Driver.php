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
    public function histories()
    {
        return $this->hasMany(DriverHistory::class, 'did', 'did');
    }

    public function car()
    {
        return $this->belongsTo(Fleet::class, 'car_id');
    }
}
