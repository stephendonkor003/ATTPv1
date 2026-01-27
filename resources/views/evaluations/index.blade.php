@extends('layouts.app')

@section('content')
    <div class="nxl-container evaluation-index">

        {{-- ================= HEADER ================= --}}
        <div class="page-header d-flex justify-content-between align-items-start mb-4">
            <div>
                <h4 class="page-title mb-1">Evaluation Configuration</h4>
                <p class="text-muted mb-1">
                    Manage evaluation structures used for procurement assessments.
                </p>
                <small class="text-muted">
                    Lifecycle: <b>Draft</b> → <b>Active</b> → <b>Close</b>
                </small>
            </div>

            <a href="{{ route('evals.cfg.new') }}" class="btn btn-primary btn-sm">
                <i class="feather-plus me-1"></i> New Evaluation
            </a>
        </div>

        {{-- ================= INFO ================= --}}
        <div class="alert alert-info mb-4">
            <strong>Guidelines:</strong>
            <ul class="mb-0">
                <li>Create and configure evaluations while in <b>Draft</b></li>
                <li>Activate an evaluation before assigning it to procurements</li>
                <li>Closed evaluations are locked and cannot be modified</li>
            </ul>
        </div>

        {{-- ================= FILTERS ================= --}}
        <div class="card shadow-sm mb-3">
            <div class="card-body">
                <div class="row g-2 align-items-end">
                    <div class="col-md-6">
                        <label class="form-label">Search Evaluation</label>
                        <input type="text" id="searchInput" class="form-control"
                            placeholder="Search by name or description">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Filter by Status</label>
                        <select id="statusFilter" class="form-select">
                            <option value="">All Statuses</option>
                            <option value="draft">Draft</option>
                            <option value="active">Active</option>
                            <option value="close">Close</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        {{-- ================= TABLE ================= --}}
        <div class="card shadow-sm">
            <table class="table table-hover align-middle mb-0" id="evaluationTable">
                <thead class="table-light">
                    <tr>
                        <th>Evaluation</th>
                        <th class="text-center">Type</th>
                        <th class="text-center">Sections</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($evaluations as $eval)
                        @php
                            $statusColor = match ($eval->status) {
                                'draft' => 'secondary',
                                'active' => 'success',
                                'close' => 'danger',
                                default => 'secondary',
                            };

                            $typeColor = $eval->type === 'goods' ? 'warning' : 'primary';
                            $typeLabel = $eval->type === 'goods' ? 'Goods (Yes / No)' : 'Services (Scored)';

                            $desc = $eval->description ?? '';
                        @endphp

                        <tr data-status="{{ $eval->status }}">
                            {{-- NAME --}}
                            <td>
                                <strong class="eval-name">{{ $eval->name }}</strong><br>
                                <small class="text-muted eval-desc">
                                    {{ \Illuminate\Support\Str::limit($desc, 80) }}
                                </small>
                            </td>

                            {{-- TYPE --}}
                            <td class="text-center">
                                <span class="badge bg-{{ $typeColor }}">
                                    {{ $typeLabel }}
                                </span>
                            </td>

                            {{-- SECTIONS --}}
                            <td class="text-center">
                                <span class="badge bg-dark fs-6">
                                    {{ $eval->sections_count }}
                                </span>
                            </td>

                            {{-- STATUS --}}
                            <td>
                                <span class="badge bg-{{ $statusColor }}">
                                    {{ ucfirst($eval->status) }}
                                </span>
                            </td>

                            {{-- ACTIONS --}}
                            <td class="text-end">
                                <a href="{{ route('evals.cfg.show', $eval) }}" class="btn btn-sm btn-outline-primary">
                                    Configure
                                </a>

                                @if ($eval->status === 'draft')
                                    <form method="POST" action="{{ route('evals.cfg.update', $eval) }}" class="d-inline">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="active">
                                        <button class="btn btn-sm btn-outline-success">
                                            Activate
                                        </button>
                                    </form>
                                @elseif ($eval->status === 'active')
                                    <form method="POST" action="{{ route('evals.cfg.update', $eval) }}" class="d-inline"
                                        onsubmit="return confirm('Closing an evaluation is final. Continue?')">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="close">
                                        <button class="btn btn-sm btn-outline-danger">
                                            Close
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr class="no-results">
                            <td colspan="5" class="text-center text-muted py-4">
                                No evaluations created yet
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>

    {{-- ================= INLINE STYLES ================= --}}
    <style>
        .evaluation-index .badge.fs-6 {
            padding: .45rem .7rem;
        }

        .evaluation-index table td {
            vertical-align: middle;
        }
    </style>

    {{-- ================= INLINE JS (SEARCH + FILTER) ================= --}}
    <script>
        const searchInput = document.getElementById('searchInput');
        const statusFilter = document.getElementById('statusFilter');
        const rows = document.querySelectorAll('#evaluationTable tbody tr:not(.no-results)');

        function filterTable() {
            const searchText = searchInput.value.toLowerCase();
            const statusValue = statusFilter.value;

            rows.forEach(row => {
                const name = row.querySelector('.eval-name')?.textContent.toLowerCase() || '';
                const desc = row.querySelector('.eval-desc')?.textContent.toLowerCase() || '';
                const rowStatus = row.dataset.status;

                const matchesSearch = name.includes(searchText) || desc.includes(searchText);
                const matchesStatus = statusValue === '' || rowStatus === statusValue;

                row.style.display = (matchesSearch && matchesStatus) ? '' : 'none';
            });
        }

        searchInput.addEventListener('keyup', filterTable);
        statusFilter.addEventListener('change', filterTable);
    </script>
@endsection
