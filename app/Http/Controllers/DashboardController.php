<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ReportService;

class DashboardController extends Controller
{
    protected  $reportService;

    public function __construct(ReportService $reportService)
    {
        $this->reportService = $reportService;
    }
    public function  index() {
        $dashboard['transactions']  = $this->reportService->transactionReport();
        return view('index', compact('dashboard'));

    }
}
