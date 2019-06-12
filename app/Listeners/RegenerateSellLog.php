<?php

namespace App\Listeners;

use App\Events\TransactionUpdated;
use App\SellLogs;
use App\Services\ReportService;
use App\Transaction;
use DB;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class RegenerateSellLog
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
     * @param  TransactionUpdated  $event
     * @return void
     */
    public function handle(TransactionUpdated $event)
    {

        $this->reportService->regenerateSellLogForCode($event->transaction);

    }


}

