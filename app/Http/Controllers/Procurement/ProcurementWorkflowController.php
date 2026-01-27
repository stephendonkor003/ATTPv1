<?php

namespace App\Http\Controllers\Procurement;

use App\Http\Controllers\Controller;
use App\Models\Procurement;
use App\Services\ProcurementWorkflowService;

class ProcurementWorkflowController extends Controller
{
    public function approve(
        Procurement $procurement,
        ProcurementWorkflowService $service
    ) {
        $service->approve($procurement);
        return back()->with('success', 'Procurement approved');
    }

    public function publish(
        Procurement $procurement,
        ProcurementWorkflowService $service
    ) {
        $service->publish($procurement);
        return back()->with('success', 'Procurement published');
    }

    public function close(
        Procurement $procurement,
        ProcurementWorkflowService $service
    ) {
        $service->close($procurement);
        return back()->with('success', 'Procurement closed');
    }

    public function award(
        Procurement $procurement,
        ProcurementWorkflowService $service
    ) {
        $service->award($procurement);
        return back()->with('success', 'Procurement awarded');
    }
}