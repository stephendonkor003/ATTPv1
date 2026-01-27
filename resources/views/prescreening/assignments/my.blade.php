@extends('layouts.app')

@section('content')
    <div class="nxl-container">

        <div class="page-header mb-4">
            <h4 class="fw-bold mb-1">My Prescreening Assignments</h4>
            <p class="text-muted mb-0">
                Procurements and submissions assigned to you for prescreening.
            </p>
        </div>

        <div class="card shadow-sm mb-4">
            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-semibold">Procurement Assignments (All Submissions)</h6>
                <span class="badge bg-secondary">{{ $procurements->count() }} Procurements</span>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover table-bordered align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Reference</th>
                            <th>Title</th>
                            <th>Submissions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($procurements as $procurement)
                            <tr>
                                <td>{{ $procurement->reference_no ?? '—' }}</td>
                                <td>{{ $procurement->title }}</td>
                                <td>{{ $procurement->submissions_count }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted py-3">
                                    No procurement-wide assignments found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card shadow-sm mb-4">
            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-semibold">Submissions From Assigned Procurements</h6>
                <span class="badge bg-secondary">{{ $procurementSubmissions->count() }} Submissions</span>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover table-bordered align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Submission Code</th>
                            <th>Procurement</th>
                            <th>Status</th>
                            <th width="140" class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($procurementSubmissions as $submission)
                            <tr>
                                <td>{{ $submission->procurement_submission_code }}</td>
                                <td>{{ $submission->procurement->title ?? '—' }}</td>
                                <td>{{ ucfirst(str_replace('_', ' ', $submission->status ?? 'submitted')) }}</td>
                                <td class="text-center">
                                    @if ($submission->prescreeningResult)
                                        <span class="badge bg-success">Prescreening Done</span>
                                    @else
                                        <a href="{{ route('prescreening.submissions.show', $submission) }}"
                                            class="btn btn-sm btn-primary">
                                            Start
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-3">
                                    No submissions found for your assigned procurements.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-semibold">Specific Submission Assignments</h6>
                <span class="badge bg-secondary">{{ $submissions->count() }} Submissions</span>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover table-bordered align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Submission Code</th>
                            <th>Procurement</th>
                            <th>Status</th>
                            <th width="140" class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($submissions as $submission)
                            <tr>
                                <td>{{ $submission->procurement_submission_code }}</td>
                                <td>{{ $submission->procurement->title ?? '—' }}</td>
                                <td>{{ ucfirst(str_replace('_', ' ', $submission->status ?? 'submitted')) }}</td>
                                <td class="text-center">
                                    @if ($submission->prescreeningResult)
                                        <span class="badge bg-success">Prescreening Done</span>
                                    @else
                                        <a href="{{ route('prescreening.submissions.show', $submission) }}"
                                            class="btn btn-sm btn-primary">
                                            Start
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-3">
                                    No specific submission assignments found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection
