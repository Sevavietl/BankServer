<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    protected $table = 'transactions';

    protected $fillable = [
        'card_id',
        'amount',
        'status',
		'token',
    ];
}
