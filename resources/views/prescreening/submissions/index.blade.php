@extends('layouts.app')

@section('content')
    <div class="nxl-container">

        {{-- ================= PAGE HEADER ================= --}}
        <div class="page-header d-flex justify-content-between align-items-center">
            <div>
                <h4 class="fw-bold mb-1">Prescreening Evaluations</h4>
                <p class="text-muted mb-0">
                    Review prescreening outcomes submitted by evaluators.
                    Locked evaluations can only be edited when a rework is requested.
                </p>
            </div>
        </div>

        {{-- ================= STATUS LEGEND ================= --}}
        <div class="card mt-3 border-0 shadow-sm">
            <div class="card-body">
                <h6 class="fw-bold mb-3">Status Guide</h6>

                <div class="row g-3">
                    <div class="col-md-4">
                        <span class="badge bg-secondary me-2">Submitted</span>
                        <small class="text-muted">Awaiting prescreening.</small>
                    </div>

                    <div class="col-md-4">
                        <span class="badge bg-success me-2">Prescreen Passed</span>
                        <small class="text-muted">All criteria satisfied.</small>
                    </div>

                    <div class="col-md-4">
                        <span class="badge bg-danger me-2">Prescreen Failed</span>
                        <small class="text-muted">One or more criteria failed.</small>
                    </div>
                </div>
            </div>
        </div>

        {{-- ================= SEARCH BAR ================= --}}
        <div class="card mt-3 shadow-sm">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h6 class="fw-bold mb-0">Search Evaluations</h6>
                        <small class="text-muted">
                            Type to filter by submission code, procurement, evaluator, or status.
                        </small>
                    </div>

                    <div class="col-md-6 text-md-end mt-2 mt-md-0">
                        <input type="text" id="evaluationSearch" class="form-control" placeholder="🔍 Search...">
                    </div>
                </div>
            </div>
        </div>

        {{-- ================= TABLE CARD ================= --}}
        <div class="card mt-4 shadow-sm">
            <div class="card-body">

                <table class="table table-hover table-bordered align-middle" id="evaluationTable">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Submission Code</th>
                            <th>Procurement</th>
                            <th>Status</th>
                            <th>Evaluator</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($submissions as $submission)
                            @php
                                $statusColors = [
                                    'submitted' => 'secondary',
                                    'prescreen_passed' => 'success',
                                    'prescreen_failed' => 'danger',
                                    'under_review' => 'warning',
                                    'approved' => 'success',
                                    'rejected' => 'danger',
                                ];

                                $status = $submission->status;
                                $badge = $statusColors[$status] ?? 'info';
                            @endphp

                            <tr class="search-row">
                                <td>{{ $loop->iteration }}</td>

                                <td class="searchable">
                                    <strong>{{ $submission->procurement_submission_code }}</strong>
                                    <br>
                                    <small class="text-muted">
                                        {{ $submission->created_at?->diffForHumans() }}
                                    </small>
                                </td>

                                <td class="searchable">
                                    {{ $submission->procurement->title }}
                                </td>

                                <td class="searchable">
                                    <span class="badge bg-{{ $badge }}">
                                        {{ str_replace('_', ' ', ucfirst($status)) }}
                                    </span>

                                    @if ($submission->prescreeningResult?->is_locked)
                                        <br>
                                        <small class="text-muted">
                                            <i class="feather-lock"></i> Locked
                                        </small>
                                    @endif
                                </td>

                                <td class="searchable">
                                    {{ optional($submission->prescreeningResult?->evaluator)->name ?? '—' }}
                                </td>

                                <td class="text-nowrap">
                                    <a href="{{ route('prescreening.submissions.show', $submission) }}"
                                        class="btn btn-sm btn-outline-primary">
                                        View
                                    </a>

                                    @can('prescreening.request_rework')
                                        @if ($submission->prescreeningResult && $submission->prescreeningResult->is_locked)
                                            <form method="POST"
                                                action="{{ route('prescreening.submissions.rework', $submission) }}"
                                                class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-warning"
                                                    onclick="return confirm('Request rework for this evaluation?')">
                                                    Rework
                                                </button>
                                            </form>
                                        @endif
                                    @endcan
                                </td>
                            </tr>

                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">
                                    <i class="feather-inbox fs-4"></i><br>
                                    No prescreening evaluations found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

            </div>
        </div>

    </div>

    {{-- ================= AUTO SEARCH SCRIPT ================= --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('evaluationSearch');
            const rows = document.querySelectorAll('#evaluationTable tbody tr.search-row');

            searchInput.addEventListener('keyup', function() {
                const query = this.value.toLowerCase().trim();

                rows.forEach(row => {
                    const text = row.innerText.toLowerCase();
                    row.style.display = text.includes(query) ? '' : 'none';
                });
            });
        });
    </script>
@endsection
