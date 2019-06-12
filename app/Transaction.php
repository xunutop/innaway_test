<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Events\TransactionCreated;
use App\Events\TransactionUpdated;

class Transaction extends Model
{

    use SoftDeletes;

    public $sell_type;
    public $buy_type;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'code',
        'type',
        'quantity',
        'available',
        'date',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->sell_type = config('constants.transaction.type.sell');
        $this->buy_type = config('constants.transaction.type.buy');
    }

    public function scopeSell($query){
        return $query->where('type', $this->sell_type);
    }

    public function scopeBuy($query){
        return $query->where('type', $this->buy_type);
    }

    public function isSellTransaction(){
        return $this->type == $this->sell_type;
    }

    public function isBuyTransaction(){
        return $this->type == $this->buy_type;
    }
}
