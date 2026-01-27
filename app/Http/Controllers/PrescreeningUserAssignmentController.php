<?php
namespace App\Http\Controllers;

use App\Models\Procurement;
use App\Models\User;
use App\Models\PrescreeningAssignment;
use Illuminate\Http\Request;

class PrescreeningUserAssignmentController extends Controller
{
    /**
     * INDEX
     * Accordion view: each procurement + assigned users
     */
    public function index()
    {
        $procurements = Procurement::with('prescreeningUsers')
            ->latest()
            ->get();

        return view(
            'prescreening.assignments.index',
            compact('procurements')
        );
    }

    /**
     * EDIT
     * Assign users to one procurement
     */
    public function edit(Procurement $procurement)
    {
        $users = User::orderBy('name')->get();

        return view(
            'prescreening.assignments.edit',
            compact('procurement', 'users')
        );
    }

    /**
     * STORE
     * Save user assignments
     */
    public function store(Request $request, Procurement $procurement)
    {
        $request->validate([
            'users'   => 'required|array',
            'users.*' => 'exists:users,id',
        ]);

        // Reset assignments (simple + safe)
        PrescreeningAssignment::where('procurement_id', $procurement->id)->delete();

        foreach ($request->users as $userId) {
            PrescreeningAssignment::create([
                'procurement_id' => $procurement->id,
                'user_id'        => $userId,
                'assigned_by'    => auth()->id(),
                'assigned_at'    => now(),
            ]);
        }

        return redirect()
            ->route('prescreening.assignments.index')
            ->with('success', 'Prescreening users assigned successfully.');
    }
}