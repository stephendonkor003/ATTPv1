<?php

namespace App\Http\Controllers;

use App\Models\EvaluationAssignment;
use App\Models\Evaluation;
use App\Models\Procurement;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EvaluationAssignmentController extends Controller
{
    /**
     * =====================================================
     * ASSIGNMENT HUB
     * Lists ALL procurements as accordions
     * =====================================================
     */
    public function hub()
    {
        $procurements = Procurement::with([
            'evaluationAssignments.evaluator',
            'evaluationAssignments.evaluation'
        ])
        ->orderBy('created_at', 'desc')
        ->get();

        // Only ACTIVE evaluations can be assigned
        $evaluations = Evaluation::where('status', 'active')->get();

        // ✅ ANY user can be an evaluator
        $evaluators = User::orderBy('name')->get();

        return view('evaluations.assign-hub', compact(
            'procurements',
            'evaluations',
            'evaluators'
        ));
    }

    /**
     * =====================================================
     * STORE ASSIGNMENT
     * =====================================================
     */
    public function store(Request $request)
    {
        $request->validate([
            'evaluation_id'  => 'required|exists:evaluations,id',
            'procurement_id' => 'required|exists:procurements,id',
            'user_id'        => 'required|exists:users,id',
        ]);

        // Prevent assignment to CLOSED evaluations
        $evaluation = Evaluation::findOrFail($request->evaluation_id);
        if ($evaluation->status === 'close') {
            return back()->with('error', 'Cannot assign evaluators to a closed evaluation.');
        }

        // Prevent duplicate assignment
        $exists = EvaluationAssignment::where([
            'evaluation_id'  => $request->evaluation_id,
            'procurement_id' => $request->procurement_id,
            'user_id'        => $request->user_id,
        ])->exists();

        if ($exists) {
            return back()->with('error', 'This user is already assigned as an evaluator.');
        }

        EvaluationAssignment::create([
            'evaluation_id'  => $request->evaluation_id,
            'procurement_id' => $request->procurement_id,
            'user_id'        => $request->user_id,
            'assigned_by'    => Auth::id(),
            'assigned_at'    => now(),
            'status'         => 'assigned',
        ]);

        return back()->with('success', 'Evaluator assigned successfully.');
    }

    /**
     * =====================================================
     * REMOVE ASSIGNMENT
     * =====================================================
     */
    public function destroy(EvaluationAssignment $assignment)
    {
        // Governance rule: do not remove after submission
        if ($assignment->status === 'submitted') {
            return back()->with('error', 'Cannot remove evaluator after submission.');
        }

        $assignment->delete();

        return back()->with('success', 'Evaluator removed successfully.');
    }
}