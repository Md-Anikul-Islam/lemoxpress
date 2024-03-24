<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;
    protected $fillable = [
        'code',
        'discount_type',
        'discount_amount',
        'valid_from',
        'valid_to',
        'max_uses',
        'max_amount_to_apply',
        'short_note'
    ];
}
