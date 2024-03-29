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
        'driver_id',
        'origin_address',
        'destination_address',
        'time',
        'total_fare',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
