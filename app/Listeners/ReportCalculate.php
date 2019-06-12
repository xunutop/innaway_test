<?php

namespace App\Listeners;

use App\Events\TransactionCreated;
use App\Transaction;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use DB;
use App\SellLogs;
use App\Helpers\Helper;
use App\Services\ReportService;

class ReportCalculate
{

    public $reportService;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(ReportService $reportService)
    {
        $this->reportService = $reportService;
    }

    /**
     * Handle the event.
     *
     * @param  TransactionCreated  $event
     * @return void
     */
    public function handle(TransactionCreated $event)
    {
        $sell_transaction = $event->transaction;
        $this->reportService->generateSellLog($sell_transaction);
    }



}

