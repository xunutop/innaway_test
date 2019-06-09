<?php

namespace App\Services;

use App\SellLogs;
use App\Transaction;

class ReportService {
    public function transactionReport(){
            $report = [];
            Transaction::select('code')->groupBy('code')->each(function($i, $k) use(&$report) {
            $min_hold_time_query = SellLogs::where('code', $i->code)->orderBy('hold_time', 'asc')->first();
            if ($min_hold_time_query !== null){
                $i->min_hold_time = $min_hold_time_query->hold_time;
            }
            $max_hold_time_query = SellLogs::where('code', $i->code)->orderBy('hold_time', 'desc')->first();
            if ($max_hold_time_query !== null){
                $i->max_hold_time = $max_hold_time_query->hold_time;
            }

            $i->available = Transaction::where('code', $i->code)->sum('available');
            $report[] = $i;
        });
        return $report;
    }
}