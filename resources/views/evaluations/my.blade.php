@extends('layouts.app')

@section('content')
    <div class="nxl-container my-evaluations">

        {{-- ================= PAGE HEADER ================= --}}
        <div class="page-header mb-4 d-flex justify-content-between align-items-center">
            <div>
                <h4 class="page-title mb-1">My Evaluations</h4>
                <p class="text-muted mb-0">
                    You are assigned to evaluate the following procurements.
                    Each applicant must be evaluated independently.
                </p>
            </div>

            <span class="badge bg-info fs-6">
                {{ $assignments->count() }} Assignments
            </span>
        </div>

        {{-- ================= INFO BANNER ================= --}}
        <div class="alert alert-primary d-flex align-items-start mb-4">
            <i class="feather-info fs-4 me-3 mt-1"></i>
            <div>
                <strong>Evaluation Guidelines</strong>
                <ul class="mb-0 ps-3">
                    <li>Each applicant is evaluated independently.</li>
                    <li>You may save drafts before final submission.</li>
                    <li>Once submitted, an applicant’s evaluation is locked.</li>
                    <li>
                        <em>
                            Services evaluations use numeric scoring.
                            Goods evaluations use Yes / No with comments.
                        </em>
                    </li>
                </ul>
            </div>
        </div>

        {{-- ================= ASSIGNMENTS ================= --}}
        @forelse ($assignments as $assignment)
            @php
                $evalType = $assignment->evaluation->type ?? 'services';

                $typeColor = $evalType === 'goods' ? 'warning' : 'primary';
                $typeLabel = $evalType === 'goods' ? 'Goods (Yes / No)' : 'Services (Scored)';
            @endphp

            <div class="card shadow-sm mb-4">

                {{-- PROCUREMENT HEADER --}}
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <div>
                        <strong>{{ $assignment->procurement->title }}</strong>

                        <span class="badge bg-secondary ms-2">
                            {{ $assignment->evaluation->name }}
                        </span>

                        <span class="badge bg-{{ $typeColor }} ms-1">
                            {{ $typeLabel }}
                        </span>
                    </div>

                    <span class="badge bg-{{ $assignment->status === 'submitted' ? 'success' : 'warning text-dark' }}">
                        {{ ucfirst($assignment->status) }}
                    </span>
                </div>

                {{-- SUBMISSIONS TABLE --}}
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Submission Code</th>
                                <th>Form</th>
                                <th>Applicant</th>
                                <th>Date</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            @forelse ($submissions->where('procurement_id', $assignment->procurement_id) as $submission)
                                @php
                                    $evalSubmission = \App\Models\EvaluationSubmission::where([
                                        'evaluation_id' => $assignment->evaluation_id,
                                        'procurement_id' => $assignment->procurement_id,
                                        'evaluator_id' => auth()->id(),
                                        'form_submission_id' => $submission->id,
                                    ])->first();
                                @endphp

                                <tr>
                                    <td>
                                        <span class="badge bg-light text-dark border">
                                            {{ $submission->procurement_submission_code }}
                                        </span>
                                    </td>

                                    <td>{{ $submission->form->name }}</td>

                                    <td>{{ optional($submission->submitter)->name }}</td>

                                    <td>{{ $submission->created_at->format('d M Y') }}</td>

                                    <td class="text-end">
                                        @if ($evalSubmission?->submitted_at)
                                            <a href="{{ route('eval.assign.view', [$assignment->id, $submission->id]) }}"
                                                class="btn btn-outline-success btn-sm">
                                                <i class="feather-eye me-1"></i>
                                                View
                                            </a>
                                        @elseif ($evalSubmission)
                                            <a href="{{ route('eval.assign.start', [$assignment->id, $submission->id]) }}"
                                                class="btn btn-outline-primary btn-sm">
                                                <i class="feather-edit me-1"></i>
                                                Continue
                                            </a>
                                        @else
                                            <a href="{{ route('eval.assign.start', [$assignment->id, $submission->id]) }}"
                                                class="btn btn-primary btn-sm">
                                                <i class="feather-play me-1"></i>
                                                Start
                                            </a>
                                        @endif
                                    </td>
                                </tr>

                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">
                                        No applications submitted yet.
                                    </td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>

            </div>

        @empty
            <div class="text-center py-5">
                <i class="feather-inbox fs-1 text-muted mb-2"></i>
                <p class="mb-0 text-muted">
                    You currently have no evaluation assignments.
                </p>
            </div>
        @endforelse

    </div>

    <style>
        .my-evaluations .badge {
            font-size: 0.85rem;
        }
    </style>
@endsection
