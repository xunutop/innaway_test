<?php

namespace App\Helpers;

use App\Transaction;

class Helper {
    public static function transactionTypeLabel($transaction_type){
        switch ($transaction_type) {
        case config('constants.transaction.type.buy'):
            return 'Mua';
            case config('constants.transaction.type.sell'):
            return 'Bán';
        default:
            return null;
        }
    }

    public static function transactionType(){
        return array_values(config('constants.transaction.type'));
    }

    public static function transactionTypeStr(){
        return implode(',',array_values(config('constants.transaction.type')));
    }

    public  static function diffInDays($start_time, $end_time){
        $start_time = \Carbon\Carbon::parse($start_time);
        $finish_time = \Carbon\Carbon::parse($end_time);

        return $start_time->diffInDays($finish_time, false);

    }

}