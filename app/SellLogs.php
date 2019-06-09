<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SellLogs extends Model
{
    protected  $fillable = [
        'code',
        'sell_id',
        'buy_id',
        'quantity',
        'hold_time',
    ];
}
