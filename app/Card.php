<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    protected $table = 'cards';

    protected $fillable = [
        'card_number',
        'card_expiration',
        'balance',
        'user_id',
    ];
}
