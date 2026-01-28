@extends('layouts.app')

@section('content')
    <div class="nxl-container">

        {{-- ===================== PAGE HEADER ===================== --}}
        <div class="page-header d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
            <div>
                <h4 class="fw-bold mb-1">Program Funding</h4>
                <p class="text-muted mb-0">
                    Funding allocations linked to approved programs
                </p>
            </div>
            @can('finance.program_funding.create')
                <a href="{{ route('finance.program-funding.create') }}" class="btn btn-primary">
                    <i class="feather-plus-circle me-1"></i>
                    New Program Funding
                </a>
            @endcan
        </div>

        {{-- ===================== FLASH MESSAGES ===================== --}}
        @if (session('success'))
            <div class="alert alert-success mt-3">
                {{ session('success') }}
            </div>
        @endif

        @if (isset($debug))
            <div class="alert alert-warning mt-3">
                <div class="fw-semibold mb-1">Debug: Governance Scope</div>
                <div class="small">
                    User: {{ $debug['user_name'] ?? '—' }} (ID: {{ $debug['user_id'] ?? '—' }}) |
                    Node ID: {{ $debug['user_node_id'] ?? '—' }} |
                    Admin: {{ $debug['is_admin'] ? 'Yes' : 'No' }} |
                    Visible Nodes: {{ is_array($debug['visible_node_ids']) ? implode(', ', $debug['visible_node_ids']) : 'ALL' }}
                </div>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger mt-3">
                {{ $errors->first() }}
            </div>
        @endif

        {{-- ===================== SEARCH BAR ===================== --}}
        <div class="card shadow-sm mt-4">
            <div class="card-body py-3">
                <div class="row g-2">
                    <div class="col-md-6 col-lg-4">
                        <div class="input-group">
                            <span class="input-group-text bg-light">
                                <i class="feather-search"></i>
                            </span>
                            <input type="text" id="fundingSearch" class="form-control"
                                placeholder="Search program, funder, currency, status…">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ===================== PROGRAM FUNDING TABLE ===================== --}}
        <div class="card shadow-sm mt-3">
            <div class="card-body table-responsive">

                <table class="table table-hover align-middle" id="fundingTable">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Program</th>
                            <th>Funder</th>
                            <th>Governance</th>
                            {{-- <th>Currency</th> --}}
                            <th> Amount</th>
                            <th>Status</th>
                            <th>Created On</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($fundings as $f)
                            <tr>
                                <td>{{ $loop->iteration }}</td>

                                {{-- Program --}}
                                <td class="searchable">
                                    {{ $f->program_name ?? ($f->program->name ?? '—') }}
                                </td>

                                {{-- Funder --}}
                                <td class="searchable">
                                    {{ $f->funder->name ?? '—' }}
                                </td>

                                {{-- Governance --}}
                                <td class="searchable">
                                    <div class="fw-semibold">
                                        {{ $f->governanceNode->name ?? '-' }}
                                    </div>
                                    <div class="text-muted small">
                                        {{ $f->governanceNode->level->name ?? '' }}
                                    </div>
                                </td>

                                {{-- Currency --}}
                                {{-- <td class="searchable">
                                    <span class="badge bg-light text-dark">
                                        {{ $f->program->currency ?? '—' }}
                                    </span>
                                </td> --}}

                                {{-- Amount --}}
                                <td class="fw-bold">
                                    {{ $f->program->currency ?? '' }}
                                    {{ number_format($f->approved_amount ?? 0, 2) }}
                                </td>

                                {{-- Status --}}
                                <td class="searchable">
                                    <span
                                        class="badge
                                {{ $f->status === 'approved'
                                    ? 'bg-success'
                                    : ($f->status === 'pending'
                                        ? 'bg-warning text-dark'
                                        : 'bg-secondary') }}">
                                        {{ ucfirst($f->status) }}
                                    </span>
                                </td>

                                {{-- Created --}}
                                <td>
                                    {{ optional($f->created_at)->format('d M Y') }}
                                </td>

                                {{-- Action --}}
                                <td class="text-end">
                                    <a href="{{ route('finance.program-funding.show', $f->id) }}"
                                        class="btn btn-sm btn-outline-primary">
                                        View
                                    </a>


                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-4">
                                    No program funding records found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                {{-- Pagination --}}
                <div class="mt-3">
                    {{ $fundings->links() }}
                </div>

            </div>
        </div>

    </div>

    {{-- ===================== SEARCH SCRIPT ===================== --}}
    <script>
        document.getElementById('fundingSearch').addEventListener('keyup', function() {
            const term = this.value.toLowerCase();
            const rows = document.querySelectorAll('#fundingTable tbody tr');

            rows.forEach(row => {
                const text = row.innerText.toLowerCase();
                row.style.display = text.includes(term) ? '' : 'none';
            });
        });
    </script>
@endsection
