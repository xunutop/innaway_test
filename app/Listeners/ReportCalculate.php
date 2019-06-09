<?php

namespace App\Listeners;

use App\Events\SellItemCreated;
use App\Transaction;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use DB;
use App\SellLogs;
use App\Helpers\Helper;

class ReportCalculate
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  SellItemCreated  $event
     * @return void
     */
    public function handle(SellItemCreated $event)
    {
        $sell_transaction = $event->transaction;
        if ($sell_transaction->type == config('constants.transaction.type.buy')){
            return;
        }
        $sell_quantity = $sell_transaction->quantity;
        DB::beginTransaction();
        try {
            while($sell_quantity > 0){
                $buy_transaction  = Transaction::where('code', $sell_transaction->code)->where('available', '>',  0)->orderBy('date')->first();

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

}

