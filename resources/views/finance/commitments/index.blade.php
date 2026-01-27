@extends('layouts.app')

@section('content')
    <div class="nxl-container">

        {{-- ===================== PAGE HEADER ===================== --}}
        <div class="page-header d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
            <div>
                <h4 class="fw-bold mb-1">Budget Commitments</h4>
                <p class="text-muted mb-0">
                    All committed resources across projects, activities, and sub-activities
                </p>
            </div>

            @can('finance.commitments.create')
                <a href="{{ route('finance.commitments.create') }}" class="btn btn-primary">
                    <i class="feather-plus-circle me-1"></i>
                    New Commitment
                </a>
            @endcan
        </div>

        {{-- ===================== FLASH MESSAGES ===================== --}}
        @if (session('success'))
            <div class="alert alert-success mt-3">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger mt-3">
                {{ $errors->first() }}
            </div>
        @endif

        {{-- ===================== SEARCH BAR ===================== --}}
        <div class="card shadow-sm mt-4">
            <div class="card-body py-3">
                <div class="row g-2 align-items-center">
                    <div class="col-md-6 col-lg-9">
                        <div class="input-group">
                            <span class="input-group-text bg-light">
                                <i class="feather-search"></i>
                            </span>
                            <input type="text" id="commitmentSearch" class="form-control"
                                placeholder="Search program, allocation, resource, year, status…">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ===================== COMMITMENTS TABLE ===================== --}}
        <div class="card shadow-sm mt-3">
            <div class="card-body table-responsive">

                <table class="table table-hover align-middle" id="commitmentsTable">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Program</th>
                            <th>Allocation</th>
                            <th>Resource</th>
                            <th class="text-end">Amount</th>
                            <th>Year</th>
                            <th>Status</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($commitments as $c)
                            <tr>

                                <td>{{ $loop->iteration }}</td>

                                {{-- Program --}}
                                <td class="searchable">
                                    {{ $c->programFunding->program->name ?? '—' }}
                                </td>

                                {{-- Allocation --}}
                                <td class="searchable">
                                    <span
                                        class="badge mb-1
                                {{ $c->allocation_level === 'project'
                                    ? 'bg-primary'
                                    : ($c->allocation_level === 'activity'
                                        ? 'bg-warning text-dark'
                                        : 'bg-success') }}">
                                        {{ ucfirst(str_replace('_', ' ', $c->allocation_level)) }}
                                    </span>

                                    <div class="small text-muted mt-1">
                                        @php
                                            $label = null;
                                            if ($c->allocation_level === 'project') {
                                                $label = \App\Models\Project::find($c->allocation_id)?->name;
                                            }
                                            if ($c->allocation_level === 'activity') {
                                                $label = \App\Models\Activity::find($c->allocation_id)?->name;
                                            }
                                            if ($c->allocation_level === 'sub_activity') {
                                                $label = \App\Models\SubActivity::find($c->allocation_id)?->name;
                                            }
                                        @endphp

                                        {{ $label ?? 'Allocation not found' }}
                                    </div>
                                </td>

                                {{-- Resource --}}
                                <td class="searchable">
                                    <div class="fw-semibold">{{ $c->resource->name ?? '—' }}</div>
                                    <small class="text-muted">{{ $c->resourceCategory->name ?? '—' }}</small>
                                </td>

                                {{-- Amount --}}
                                <td class="text-end fw-bold">
                                    <span class="text-muted me-1">
                                        {{ $c->programFunding->program->currency ?? '' }}
                                    </span>
                                    {{ number_format($c->commitment_amount, 2) }}
                                </td>


                                {{-- Year --}}
                                <td class="searchable">
                                    <span class="badge bg-light text-dark">
                                        {{ $c->commitment_year }}
                                    </span>
                                </td>

                                {{-- Status --}}
                                <td class="searchable">
                                    <span
                                        class="badge
                                {{ $c->status === 'approved'
                                    ? 'bg-success'
                                    : ($c->status === 'submitted'
                                        ? 'bg-warning text-dark'
                                        : ($c->status === 'cancelled'
                                            ? 'bg-danger'
                                            : 'bg-secondary')) }}">
                                        {{ ucfirst($c->status) }}
                                    </span>
                                </td>

                                {{-- Action --}}
                                <td class="text-end">
                                    <a href="{{ route('finance.commitments.show', $c->id) }}"
                                        class="btn btn-sm btn-outline-primary">
                                        View
                                    </a>
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-4">
                                    No budget commitments found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                {{-- Pagination --}}
                <div class="mt-3">
                    {{ $commitments->links() }}
                </div>

            </div>
        </div>

    </div>

    {{-- ===================== SEARCH SCRIPT ===================== --}}
    <script>
        document.getElementById('commitmentSearch').addEventListener('keyup', function() {
            const term = this.value.toLowerCase();
            const rows = document.querySelectorAll('#commitmentsTable tbody tr');

            rows.forEach(row => {
                const text = row.innerText.toLowerCase();
                row.style.display = text.includes(term) ? '' : 'none';
            });
        });
    </script>
@endsection
