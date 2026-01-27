<?php

namespace App\Http\Controllers\Procurement;

use App\Http\Controllers\Controller;
use App\Models\FormSubmission;

class ProcurementSubmissionController extends Controller
{
    /**
     * List all procurement submissions
     */
    public function index()
    {
        $submissions = FormSubmission::with([
                'procurement',
                'form',
                'values'
            ])
            ->latest()
            ->paginate(20);

        return view('procurement.procuresubmissions.index', compact('submissions'));
    }

    /**
     * View a single procurement submission
     */
    public function show(FormSubmission $submission)
    {
        $submission->load([
            'procurement',
            'form',
            'values'
        ]);

        return view('procurement.procuresubmissions.show', compact('submission'));
    }
}
