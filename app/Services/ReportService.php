<?php

namespace App\Services;

use App\Events\TransactionUpdated;
use App\Helpers\Helper;
use App\SellLogs;
use App\Transaction;
use DB;

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


    public function generateSellLog($sell_transaction){
        if ($sell_transaction->type == config('constants.transaction.type.buy')){
            return;
        }
        \Log::debug("sell transaction: " . $sell_transaction->id);
        $sell_quantity = $sell_transaction->quantity;
        \Log::debug('sell quantity: ' . $sell_quantity);
        DB::beginTransaction();
        try {
            while($sell_quantity > 0){
                $buy_transaction  = Transaction::where('code', $sell_transaction->code)->where('available', '>',  0)->orderBy('date', 'asc')->first();
                \Log::debug("buy tranacstion: " . $buy_transaction->id);
                if ($sell_quantity > $buy_transaction->quantity){
                    $sell_quantity_miss  = $sell_quantity  - $buy_transaction->available;

                    $sell_log = new SellLogs([
                        'code' => $sell_transaction->code,
                        'buy_id' => $buy_transaction->id,
                        'sell_id' => $sell_transaction->id,
                        'quantity' => $buy_transaction->available,
                        'hold_time' => Helper::diffInDays($buy_transaction->date, $sell_transaction->date),
                    ]);
                    $sell_log->save();

                    $buy_transaction->available = 0;
                    $buy_transaction->update();

                    $sell_quantity = $sell_quantity_miss;

                    continue;
                }else{
                    $sell_log = new SellLogs([
                        'code' => $sell_transaction->code,
                        'buy_id' => $buy_transaction->id,
                        'sell_id' => $sell_transaction->id,
                        'quantity' => $sell_quantity,
                        'hold_time' => Helper::diffInDays($buy_transaction->date, $sell_transaction->date),
                    ]);
                    $sell_log->save();
                    $buy_transaction->available = $buy_transaction->available - $sell_quantity;
                    $buy_transaction->update();
                    break;
                }
            }
            DB::commit();
        }catch(\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
    }

    public function regenerateSellLogForCode($transaction){
        DB::beginTransaction();
        try {
            // rollback stock buy transaction by code
            Transaction::buy()
                        ->where('code', $transaction->code)
                        ->update(['available' => DB::raw("`quantity`")]);

            // Delete sell_logs by code
            SellLogs::where('code', $transaction->code)
                    ->delete();

            //  regenerate sell_log
            $sell_list = Transaction::sell()
                        ->where('code', $transaction->code)
                        ->orderBy('date', 'asc')->get();

            foreach ($sell_list as $sell_transaction) {
                \Log::debug("sell id: ".$sell_transaction->id);
                $stock = Transaction::buy()
                                    ->where('code', $transaction->code)
                                    ->groupBy('code')
                                    ->sum('available');
                \Log::debug("stock: ". $stock);
                if ( $stock >= $sell_transaction->quantity){
                    $this->generateSellLog($sell_transaction);
                }else{
                    Transaction::find($sell_transaction->id)->delete();
                }
            }
            DB::commit();
        }catch(\Exception $e) {
            DB::rollBack();

            throw new \Exception($e->getMessage());
        }
    }
}