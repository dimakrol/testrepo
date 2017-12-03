<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Card
 *
 * @property int $id
 * @property int $user_id
 * @property string|null $card_id
 * @property string|null $last4
 * @property string|null $expiryDate
 * @property int $is_default
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Card whereCardId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Card whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Card whereExpiryDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Card whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Card whereIsDefault($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Card whereLast4($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Card whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Card whereUserId($value)
 * @mixin \Eloquent
 */
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
