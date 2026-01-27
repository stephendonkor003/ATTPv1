<?php

namespace App\Http\Controllers\Procurement;

use App\Http\Controllers\Controller;
use App\Models\Procurement;
use Illuminate\Http\Request;

class ProcurementStatusController extends Controller
{
    /* ===============================
     | STATUS TRANSITIONS ONLY
     =============================== */

    public function submit(Procurement $procurement)
    {
        if (!in_array($procurement->status, ['draft', 'rejected'])) {
            return back()->with('error', 'Only draft or rejected procurements can be submitted.');
        }

        $procurement->update([
            'status' => 'submitted',
            'rejection_reason' => null,
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
            'rejection_reason' => null,
        ]);

        return back()->with('success', 'Procurement approved.');
    }

    public function reject(Request $request, Procurement $procurement)
    {
        if ($procurement->status !== 'submitted') {
            return back()->with('error', 'Only submitted procurements can be rejected.');
        }

        $request->validate([
            'rejection_reason' => 'required|string|min:5',
        ]);

        $procurement->update([
            'status' => 'rejected',
            'rejection_reason' => $request->rejection_reason,
        ]);

        return back()->with('success', 'Procurement rejected.');
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
