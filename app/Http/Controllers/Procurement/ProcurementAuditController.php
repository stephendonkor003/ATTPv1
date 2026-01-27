<?php

namespace App\Http\Controllers\Procurement;

use App\Http\Controllers\Controller;
use App\Models\ProcurementAuditLog;

class ProcurementAuditController extends Controller
{
    public function index()
    {
        $logs = ProcurementAuditLog::latest()->paginate(50);
        return view('procurement.audit.index', compact('logs'));
    }
}