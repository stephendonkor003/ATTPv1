@extends('layouts.app')

@section('content')
    <div class="nxl-container">

        {{-- ================= HEADER ================= --}}
        <div class="page-header d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold mb-1">Program Funding Details</h4>
                <p class="text-muted mb-0">
                    Funding governance record and supporting documentation
                </p>
            </div>

            <div class="d-flex gap-2">
                @can('finance.program_funding.edit')
                    @if ($programFunding->status === 'draft')
                        <a href="{{ route('finance.program-funding.edit', $programFunding) }}" class="btn btn-warning">
                            <i class="feather-edit me-1"></i> Edit
                        </a>
                    @endif
                @endcan

                <a href="{{ route('finance.program-funding.index') }}" class="btn btn-light">
                    <i class="feather-arrow-left me-1"></i> Back
                </a>
            </div>
        </div>

        {{-- ================= SUMMARY CARDS ================= --}}
        <div class="row g-3 mb-4">

            <div class="col-md-3">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body">
                        <small class="text-muted">Department</small>
                        <h6 class="fw-bold mb-0">
                            {{ optional($programFunding->department)->name ?? '—' }}
                        </h6>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body">
                        <small class="text-muted">Program</small>
                        <h6 class="fw-bold mb-0">
                            {{ optional($programFunding->program)->name ?? '—' }}
                        </h6>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body">
                        <small class="text-muted">Funder</small>
                        <h6 class="fw-bold mb-0">
                            {{ optional($programFunding->funder)->name ?? '—' }}
                        </h6>
                    </div>
                </div>
            </div>

            @php
                $statusClass =
                    [
                        'draft' => 'bg-warning',
                        'submitted' => 'bg-primary',
                        'approved' => 'bg-success',
                        'rejected' => 'bg-danger',
                    ][$programFunding->status] ?? 'bg-secondary';
            @endphp

            <div class="col-md-3">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body">
                        <small class="text-muted">Status</small>
                        <div>
                            <span class="badge {{ $statusClass }}">
                                {{ ucfirst($programFunding->status) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        {{-- ================= FUNDING INFORMATION ================= --}}
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body">
                <h6 class="fw-bold mb-3">Funding Information</h6>

                <div class="row g-3">
                    <div class="col-md-3">
                        <small class="text-muted">Funding Type</small>
                        <div class="fw-semibold">
                            {{ ucfirst($programFunding->funding_type) }}
                        </div>
                    </div>

                    <div class="col-md-3">
                        <small class="text-muted">Approved Amount</small>
                        <div class="fw-semibold">
                            {{ number_format($programFunding->approved_amount, 2) }}
                            {{ $programFunding->currency }}
                        </div>
                    </div>

                    <div class="col-md-3">
                        <small class="text-muted">Funding Period</small>
                        <div class="fw-semibold">
                            {{ $programFunding->start_year }} – {{ $programFunding->end_year }}
                        </div>
                    </div>

                    <div class="col-md-3">
                        <small class="text-muted">Submitted By</small>
                        <div class="fw-semibold">
                            {{ optional($programFunding->creator)->name ?? 'System' }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ================= SUPPORTING DOCUMENTS ================= --}}
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body">
                @can('finance.program_funding.documents')
                    <h6 class="fw-bold mb-3">Supporting Documents</h6>

                    @if ($programFunding->documents->count())
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Document Type</th>
                                        <th>Submitted Date</th>
                                        <th>System Recieved Date</th>
                                        <th class="text-center">File</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($programFunding->documents as $doc)
                                        <tr>
                                            <td>{{ $doc->document_type ?? '—' }}</td>
                                            <td>{{ $doc->created_at ?? '—' }}</td>
                                            <td>{{ $doc->created_at ?? '—' }}</td>
                                            <td class="text-center">
                                                <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank"
                                                    class="btn btn-sm btn-outline-primary">
                                                    <i class="feather-download me-1"></i> View
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted mb-0">
                            No supporting documents uploaded.
                        </p>
                    @endif
                @endcan
            </div>
        </div>

        {{-- ================= GOVERNANCE ACTIONS ================= --}}
        <div class="card shadow-sm border-0">
            <div class="card-body d-flex justify-content-between align-items-center">

                <div class="text-muted small">
                    Funding records must be approved before budgets or commitments can be created.
                </div>

                <div class="d-flex gap-2">

                    @if ($programFunding->status === 'draft')
                        @can('finance.program_funding.submit')
                            <form method="POST" action="{{ route('finance.program-funding.submit', $programFunding) }}">
                                @csrf
                                <button class="btn btn-primary">
                                    <i class="feather-send me-1"></i> Submit for Approval
                                </button>
                            </form>
                        @endcan
                    @endif

                    @if ($programFunding->status === 'submitted')
                        @can('finance.program_funding.approve')
                            <form method="POST" action="{{ route('finance.program-funding.approve', $programFunding) }}">
                                @csrf
                                <button class="btn btn-success">
                                    <i class="feather-check me-1"></i> Approve
                                </button>
                            </form>

                            <form method="POST" action="{{ route('finance.program-funding.reject', $programFunding) }}">
                                @csrf
                                <button class="btn btn-danger">
                                    <i class="feather-x me-1"></i> Reject
                                </button>
                            </form>
                        @endcan
                    @endif

                </div>
            </div>
        </div>

    </div>
@endsection
