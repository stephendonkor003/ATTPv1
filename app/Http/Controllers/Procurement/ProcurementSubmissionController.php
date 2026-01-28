<?php

namespace App\Http\Controllers\Procurement;

use App\Http\Controllers\Controller;
use App\Models\FormSubmission;
use App\Http\Controllers\Procurement\Concerns\GovernanceScope;

class ProcurementSubmissionController extends Controller
{
    use GovernanceScope;

    /**
     * List all procurement submissions
     */
    public function index()
    {
        $scopedNodeIds = $this->scopedNodeIds();
        if ($scopedNodeIds !== null && empty($scopedNodeIds)) {
            abort(403, 'You do not have access to submissions.');
        }

        $submissions = FormSubmission::with([
                'procurement',
                'form',
                'values'
            ])
            ->when($scopedNodeIds !== null, function ($query) use ($scopedNodeIds) {
                $query->whereHas('procurement', function ($proc) use ($scopedNodeIds) {
                    $proc->whereIn('governance_node_id', $scopedNodeIds)
                        ->whereNotNull('governance_node_id');
                });
            })
            ->latest()
            ->paginate(20);

        return view('procurement.procuresubmissions.index', compact('submissions'));
    }

    /**
     * View a single procurement submission
     */
    public function show(FormSubmission $submission)
    {
        $this->assertSubmissionInScope($submission);
        $submission->load([
            'procurement',
            'form',
            'values'
        ]);

        return view('procurement.procuresubmissions.show', compact('submission'));
    }
}
