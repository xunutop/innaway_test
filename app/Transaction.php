<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Events\SellItemCreated;


class Transaction extends Model
{

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'code',
        'type',
        'quantity',
        'available',
        'date',
    ];

    protected $dispatchesEvents = [
        'saved' => SellItemCreated::class,
    ];
}
