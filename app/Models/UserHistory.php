<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserHistory extends Model
{
    use HasFactory;
    protected $fillable = [
        'uid',
        'user_id',
        'did',
        'origin_address',
        'destination_address',
        'time',
        'total_fare',
        'trip_type'
    ];
    public function user()
    {
        //return $this->belongsTo(User::class);
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class, 'did', 'did');
    }

    public function tripRequest()
    {
        return $this->belongsTo(TripRequest::class, 'did', 'driver_id');
    }
}
