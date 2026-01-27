<?php

namespace App\Http\Controllers\Procurement;

use App\Http\Controllers\Controller;
use App\Models\Procurement;

class ProcurementStatusController extends Controller
{
    /* ===============================
     | STATUS TRANSITIONS ONLY
     =============================== */

    public function submit(Procurement $procurement)
    {
        if ($procurement->status !== 'draft') {
            return back()->with('error', 'Only draft procurements can be submitted.');
        }

        $procurement->update([
            'status' => 'submitted',
        ]);

        return back()->with('success', 'Procurement submitted.');
    }

    public function approve(Procurement $procurement)
    {
        if ($procurement->status !== 'submitted') {
            return back()->with('error', 'Only submitted procurements can be approved.');
        }

        $procurement->update([
            'status' => 'approved',
        ]);

        return back()->with('success', 'Procurement approved.');
    }

    public function publish(Procurement $procurement)
    {
        if ($procurement->status !== 'approved') {
            return back()->with('error', 'Only approved procurements can be published.');
        }

        $procurement->update([
            'status' => 'published',
        ]);

        return back()->with('success', 'Procurement published.');
    }

    public function close(Procurement $procurement)
    {
        if ($procurement->status !== 'published') {
            return back()->with('error', 'Only published procurements can be closed.');
        }

        $procurement->update([
            'status' => 'closed',
        ]);

        return back()->with('success', 'Procurement closed.');
    }

    public function award(Procurement $procurement)
    {
        if ($procurement->status !== 'closed') {
            return back()->with('error', 'Only closed procurements can be awarded.');
        }

        $procurement->update([
            'status' => 'awarded',
        ]);

        return back()->with('success', 'Procurement awarded.');
    }
}