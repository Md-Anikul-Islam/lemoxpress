<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DriverRatting extends Model
{
    use HasFactory;
    protected $fillable = [
        'did',
        'uid',
        'ratting',
    ];
}
