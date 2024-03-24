<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DriverHistory extends Model
{
    use HasFactory;
    protected $fillable = [
        'did',
        'origin_address',
        'destination_address',
        'time',
        'total_fare',
    ];
    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }
}
