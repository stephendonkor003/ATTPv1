<?php

namespace App\Http\Controllers;

use App\Models\FormSubmission;
use App\Models\PrescreeningEvaluation;
use App\Models\PrescreeningResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class PrescreeningEvaluationController extends Controller
{
    /**
     * ===============================
     * LIST PRESCREENING SUBMISSIONS
     * ===============================
     */
    public function index()
    {
        $query = FormSubmission::with(
            'procurement',
            'submitter',
            'prescreeningResult'
        );

        if (Gate::allows('prescreening.view_all')) {

            $submissions = $query->latest()->get();

        } else {

            // ✅ FIX: filter by ASSIGNMENT, not evaluation
            $submissions = $query
                ->whereHas('procurement.prescreeningAssignments', function ($q) {
                    $q->where('user_id', auth()->id());
                })
                ->latest()
                ->get();
        }

        return view('prescreening.submissions.index', compact('submissions'));
    }

    /**
     * ===============================
     * SHOW PRESCREENING EVALUATION
     * ===============================
     */
    public function show(FormSubmission $submission)
    {
        // ✅ Authorization FIRST (assignment-based)
        if (
            Gate::denies('prescreening.view_all') &&
            !$submission->procurement
                ->prescreeningAssignments()
                ->where('user_id', auth()->id())
                ->exists()
        ) {
            abort(403);
        }

        $template = $submission->procurement
            ->prescreeningTemplate
            ?->load('criteria');

        abort_if(!$template, 404);

        // Result MAY be null (pending submission)
        $result = $submission->prescreeningResult;

        // Editable only if:
        // - assigned to user
        // - not locked
        $canEdit = $result
            ? !$result->is_locked && $result->evaluated_by === auth()->id()
            : true;

        $evaluations = PrescreeningEvaluation::where(
                'submission_id',
                $submission->id
            )
            ->get()
            ->keyBy('criterion_id');

        return view(
            'prescreening.submissions.show',
            compact('submission', 'template', 'result', 'canEdit', 'evaluations')
        );
    }

    /**
     * ===============================
     * STORE / UPDATE PRESCREENING
     * ===============================
     */
    public function store(Request $request, FormSubmission $submission)
    {
        // ✅ Assignment enforcement
        if (
            Gate::denies('prescreening.view_all') &&
            !$submission->procurement
                ->prescreeningAssignments()
                ->where('user_id', auth()->id())
                ->exists()
        ) {
            abort(403);
        }

        $template = $submission->procurement->prescreeningTemplate;
        abort_if(!$template, 404);

        $result = $submission->prescreeningResult;

        // 🔒 Prevent edits when locked
        if ($result && $result->is_locked) {
            abort(403, 'Evaluation is locked. Rework must be requested.');
        }

        DB::transaction(function () use ($request, $submission, $template) {

            $criteria = $template->criteria;
            $passed = 0;
            $failed = 0;

            foreach ($criteria as $criterion) {

                $pass = (bool) $request->input(
                    "criteria.{$criterion->id}.passed"
                );

                PrescreeningEvaluation::updateOrCreate(
                    [
                        'submission_id' => $submission->id,
                        'criterion_id'  => $criterion->id,
                    ],
                    [
                        'prescreening_template_id' => $template->id,
                        'evaluator_id'             => auth()->id(),
                        'evaluation_value'         => $request->input(
                            "criteria.{$criterion->id}.value"
                        ),
                        'is_passed'                => $pass,
                        'remarks'                  => $request->input(
                            "criteria.{$criterion->id}.remarks"
                        ),
                        'evaluated_at'             => now(),
                    ]
                );

                $pass ? $passed++ : $failed++;
            }

            $finalStatus = $failed === 0 ? 'passed' : 'failed';

            PrescreeningResult::updateOrCreate(
                ['submission_id' => $submission->id],
                [
                    'prescreening_template_id' => $template->id,
                    'total_criteria'           => $criteria->count(),
                    'passed_criteria'          => $passed,
                    'failed_criteria'          => $failed,
                    'final_status'             => $finalStatus,
                    'evaluated_by'             => auth()->id(),
                    'evaluated_at'             => now(),
                    'is_locked'                => true,
                ]
            );

            $submission->update([
                'status' => $finalStatus === 'passed'
                    ? 'prescreen_passed'
                    : 'prescreen_failed',
            ]);
        });

        return redirect()
            ->route('prescreening.submissions.index')
            ->with('success', 'Prescreening evaluation saved successfully.');
    }

    /**
     * ===============================
     * REQUEST REWORK (UNLOCK)
     * ===============================
     */
    public function requestRework(FormSubmission $submission)
    {
        abort_if(Gate::denies('prescreening.request_rework'), 403);

        $result = $submission->prescreeningResult;
        abort_if(!$result, 404);

        $result->update([
            'is_locked'           => false,
            'rework_requested_by' => auth()->id(),
            'rework_requested_at' => now(),
        ]);

        return back()->with('success', 'Rework requested successfully.');
    }
}
