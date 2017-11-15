<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    protected $fillable = [
        'user_id',
        'card_id',
        'last4',
        'expiryDate',
        'is_default',
    ];
}
