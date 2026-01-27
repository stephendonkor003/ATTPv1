@extends('layouts.app')

@section('content')
    <div class="nxl-container">

        {{-- ================= PAGE HEADER ================= --}}
        <div class="page-header d-flex justify-content-between align-items-center mb-3">
            <div>
                <h4 class="page-title mb-1">Procurements</h4>
                <p class="text-muted mb-0">
                    Manage procurements and their associated forms
                </p>
            </div>

            <a href="{{ route('procurements.create') }}" class="btn btn-primary btn-sm">
                <i class="feather-plus me-1"></i> New Procurement
            </a>
        </div>

        {{-- ================= EDUCATIVE INFO ================= --}}
        <div class="alert alert-info mb-3">
            <strong>Procurement Lifecycle:</strong>
            <span class="ms-2">Draft → Submitted → Approved → Published → Closed → Awarded</span>
            <div class="small mt-1 text-muted">
                Actions appear automatically based on the current status.
            </div>
        </div>

        {{-- ================= SEARCH ================= --}}
        <div class="card shadow-sm mb-3">
            <div class="card-body">
                <input type="text" id="procurementSearch" class="form-control"
                    placeholder="Search by reference, title, category, fiscal year or status…">
            </div>
        </div>

        {{-- ================= TABLE ================= --}}
        <div class="card shadow-sm">
            <div class="card-body p-0">

                <table class="table table-hover table-bordered align-middle mb-0" id="procurementTable">
                    <thead class="table-light">
                        <tr>
                            <th>Reference</th>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Status</th>
                            <th width="220" class="text-center">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($procurements as $p)
                            <tr>
                                {{-- Reference --}}
                                <td class="fw-semibold">
                                    {{ $p->reference_no ?? '—' }}
                                </td>

                                {{-- Title --}}
                                <td>
                                    <div class="fw-semibold">{{ $p->title }}</div>
                                    <small class="text-muted">
                                        Fiscal Year: {{ $p->fiscal_year ?? '—' }}
                                    </small>
                                </td>

                                {{-- Category --}}
                                <td>
                                    {{ $p->resource->name ?? '—' }}
                                </td>

                                {{-- Status --}}
                                <td>
                                    <span
                                        class="badge
                                        @if ($p->status === 'draft') bg-secondary
                                        @elseif ($p->status === 'submitted') bg-warning text-dark
                                        @elseif ($p->status === 'rejected') bg-danger
                                        @elseif ($p->status === 'approved') bg-success
                                        @elseif ($p->status === 'published') bg-primary
                                        @elseif ($p->status === 'closed') bg-dark
                                        @elseif ($p->status === 'awarded') bg-success @endif">
                                        {{ ucfirst($p->status) }}
                                    </span>
                                </td>

                                {{-- ACTIONS --}}
                                <td class="text-center">

                                    {{-- VIEW --}}
                                    <a href="{{ route('procurements.show', $p) }}"
                                        class="btn btn-sm btn-outline-primary mb-1">
                                        <i class="feather-eye"></i>
                                    </a>

                                    {{-- SUBMIT --}}
                                    @if ($p->status === 'draft')
                                        <form method="POST" action="{{ route('statusProcurement.submit', $p) }}"
                                            class="d-inline">
                                            @csrf
                                            <button class="btn btn-sm btn-outline-warning"
                                                onclick="return confirm('Submit this procurement for approval?')">
                                                Submit
                                            </button>
                                        </form>
                                    @endif

                                    {{-- RESUBMIT --}}
                                    @if ($p->status === 'rejected')
                                        <form method="POST" action="{{ route('statusProcurement.submit', $p) }}"
                                            class="d-inline">
                                            @csrf
                                            <button class="btn btn-sm btn-outline-warning"
                                                onclick="return confirm('Resubmit this procurement for approval?')">
                                                Resubmit
                                            </button>
                                        </form>
                                    @endif

                                    {{-- APPROVE --}}
                                    @if ($p->status === 'submitted')
                                        <form method="POST" action="{{ route('statusProcurement.approve', $p) }}"
                                            class="d-inline">
                                            @csrf
                                            <button class="btn btn-sm btn-outline-success"
                                                onclick="return confirm('Approve this procurement?')">
                                                Approve
                                            </button>
                                        </form>

                                        <button class="btn btn-sm btn-outline-danger ms-1" data-bs-toggle="collapse"
                                            data-bs-target="#rejectProcurementDrawer{{ $p->id }}" aria-expanded="false"
                                            aria-controls="rejectProcurementDrawer{{ $p->id }}">
                                            Reject
                                        </button>
                                    @endif

                                    {{-- PUBLISH --}}
                                    @if ($p->status === 'approved')
                                        <form method="POST" action="{{ route('statusProcurement.publish', $p) }}"
                                            class="d-inline">
                                            @csrf
                                            <button class="btn btn-sm btn-outline-primary"
                                                onclick="return confirm('Publish this procurement?')">
                                                Publish
                                            </button>
                                        </form>
                                    @endif

                                    {{-- CLOSE --}}
                                    @if ($p->status === 'published')
                                        <form method="POST" action="{{ route('statusProcurement.close', $p) }}"
                                            class="d-inline">
                                            @csrf
                                            <button class="btn btn-sm btn-outline-dark"
                                                onclick="return confirm('Close this procurement?')">
                                                Close
                                            </button>
                                        </form>
                                    @endif

                                    {{-- AWARD --}}
                                    @if ($p->status === 'closed')
                                        <form method="POST" action="{{ route('statusProcurement.award', $p) }}"
                                            class="d-inline">
                                            @csrf
                                            <button class="btn btn-sm btn-outline-success"
                                                onclick="return confirm('Award this procurement? This is final.')">
                                                Award
                                            </button>
                                        </form>
                                    @endif

                                </td>
                            </tr>
                            @if ($p->status === 'submitted')
                                <tr class="collapse" id="rejectProcurementDrawer{{ $p->id }}">
                                    <td colspan="5" class="bg-light">
                                        <form method="POST" action="{{ route('statusProcurement.reject', $p) }}"
                                            class="row g-3 align-items-end p-3">
                                            @csrf
                                            <div class="col-md-8">
                                                <label class="form-label fw-semibold">Reason for rejection</label>
                                                <textarea name="rejection_reason" class="form-control" rows="2" required></textarea>
                                            </div>
                                            <div class="col-md-4 text-md-end">
                                                <button type="submit" class="btn btn-danger">
                                                    Reject Procurement
                                                </button>
                                            </div>
                                        </form>
                                    </td>
                                </tr>
                            @endif
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">
                                    No procurements found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

            </div>

            {{-- ================= PAGINATION ================= --}}
            @if ($procurements->hasPages())
                <div class="card-footer">
                    {{ $procurements->links() }}
                </div>
            @endif
        </div>

    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const input = document.getElementById('procurementSearch');
            const rows = document.querySelectorAll('#procurementTable tbody tr');

            input.addEventListener('keyup', function() {
                const value = this.value.toLowerCase();
                rows.forEach(row => {
                    row.style.display = row.innerText.toLowerCase().includes(value) ?
                        '' :
                        'none';
                });
            });
        });
    </script>
@endsection
