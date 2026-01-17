<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Printer;
use App\Models\PrintJob;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'printers_online' => Printer::where('status', 'online')->count(),
            'printers_offline' => Printer::where('status', 'offline')->count(),
            'jobs_queued' => PrintJob::where('status', 'queued')->count(),
            'jobs_printing' => PrintJob::where('status', 'printing')->count(),
            'jobs_done' => PrintJob::where('status', 'done')->count(),
            'jobs_error' => PrintJob::where('status', 'error')->count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}

