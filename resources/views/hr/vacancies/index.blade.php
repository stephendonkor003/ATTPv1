@extends('layouts.app')

@section('content')
    <div class="nxl-container">

        {{-- ================= PAGE HEADER ================= --}}
        <div class="page-header mb-4">
            <div class="d-flex flex-column align-items-start gap-2">
                <div>
                    <h4 class="fw-bold mb-1">
                        <i class="feather-megaphone text-primary me-2"></i>
                        HR Vacancies
                    </h4>
                    <p class="text-muted mb-0">
                        Manage job vacancies, approvals, and publication workflow
                    </p>
                </div>
                @can('hrm.vacancies.create')
                    <button class="btn btn-primary d-inline-flex align-items-center" data-bs-toggle="modal"
                        data-bs-target="#addVacancyModal">
                        <i class="feather-plus me-2"></i>
                        Create Vacancy
                    </button>
                @endcan
            </div>
        </div>

        {{-- ================= VACANCIES TABLE ================= --}}
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white border-0 pb-0">
                <h6 class="fw-semibold mb-1">Vacancies List</h6>
                <p class="text-muted small mb-0">
                    All vacancies and their current approval or publication status
                </p>
            </div>

            <div class="card-body pt-3">
                <div class="table-responsive">
                    <table class="table table-hover align-middle w-100 mb-0 hr-vacancies-table">
                        <thead class="table-light">
                            <tr>
                                <th>Vacancy Code</th>
                                <th>Position</th>
                                <th>Employment Type</th>
                                <th>Visibility</th>
                                <th>Status</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($vacancies as $vacancy)
                                <tr>
                                    <td class="fw-semibold">
                                        {{ $vacancy->vacancy_code }}
                                    </td>

                                    <td>
                                        {{ $vacancy->position->title }}
                                    </td>

                                    <td>
                                        <span class="badge bg-info-subtle text-info px-3 py-1">
                                            {{ ucfirst($vacancy->position->employment_type) }}
                                        </span>
                                    </td>

                                    <td>
                                        @if ($vacancy->is_public)
                                            <span class="badge bg-primary-subtle text-primary px-3 py-1">
                                                Public
                                            </span>
                                        @else
                                            <span class="badge bg-secondary-subtle text-secondary px-3 py-1">
                                                Internal
                                            </span>
                                        @endif
                                    </td>

                                    {{-- STATUS --}}
                                    <td>
                                        @php
                                            $statusMap = [
                                                'draft' => 'secondary',
                                                'submitted' => 'warning',
                                                'approved' => 'info',
                                                'published' => 'success',
                                                'closed' => 'dark',
                                            ];
                                        @endphp
                                        <span class="badge bg-{{ $statusMap[$vacancy->status] ?? 'secondary' }} px-3 py-1">
                                            {{ ucfirst($vacancy->status) }}
                                        </span>
                                    </td>

                                    {{-- ACTIONS --}}
                                    <td class="text-end">
                                        <div class="d-inline-flex gap-1">

                                            @if ($vacancy->status === 'draft')
                                                @can('hrm.vacancies.submit')
                                                    <form action="{{ route('hr.vacancies.submit', $vacancy->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        <button class="btn btn-sm btn-outline-warning">
                                                            Submit for Approval
                                                        </button>
                                                    </form>
                                                @endcan
                                            @endif

                                            @if ($vacancy->status === 'submitted')
                                                @can('hr.vacancies.approve')
                                                    <form action="{{ route('hr.vacancies.approve', $vacancy->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        <button class="btn btn-sm btn-outline-info">
                                                            Approve
                                                        </button>
                                                    </form>
                                                @endcan
                                            @endif

                                            @if ($vacancy->status === 'approved')
                                                @can('hr.vacancies.approve')
                                                    <form action="{{ route('hr.vacancies.publish', $vacancy->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        <button class="btn btn-sm btn-outline-success">
                                                            Publish
                                                        </button>
                                                    </form>
                                                @endcan
                                            @endif

                                            @if (in_array($vacancy->status, ['published', 'closed']))
                                                @can('hr.applicants.view')
                                                    <a href="{{ route('hr.vacancies.applicants', $vacancy->id) }}"
                                                        class="btn btn-sm btn-outline-primary">
                                                        Show Applicants
                                                    </a>
                                                @endcan
                                            @endif

                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted">
                                        <i class="feather-inbox fs-4 d-block mb-2"></i>
                                        No vacancies have been created yet
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    {{-- ================= CREATE VACANCY MODAL ================= --}}
    <div class="modal fade" id="addVacancyModal" tabindex="-1">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <form method="POST" action="{{ route('hr.vacancies.store') }}" class="w-100">
                @csrf

                <div class="modal-content border-0 shadow">

                    <div class="modal-header">
                        <h5 class="fw-bold mb-0">
                            <i class="feather-megaphone text-primary me-2"></i>
                            Create Vacancy
                        </h5>
                        <button class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <div class="row g-3">

                            <div class="col-12">
                                <label class="form-label fw-semibold">
                                    Position <span class="text-danger">*</span>
                                </label>
                                <select name="position_id" class="form-select" required>
                                    <option value="">Select Position</option>
                                    @foreach (\App\Models\HrPosition::where('status', 'active')->get() as $position)
                                        <option value="{{ $position->id }}">
                                            {{ $position->title }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Open Date *</label>
                                <input type="date" name="open_date" class="form-control" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Close Date *</label>
                                <input type="date" name="close_date" class="form-control" required>
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-semibold">
                                    Number of Positions
                                </label>
                                <input type="number" name="number_of_positions" class="form-control" value="1"
                                    min="1">
                            </div>

                            <div class="col-12">
                                <div class="form-check form-switch mt-2">
                                    <input class="form-check-input" type="checkbox" name="is_public" value="1" checked>
                                    <label class="form-check-label fw-semibold">
                                        Public Competitive Recruitment
                                    </label>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-light" data-bs-dismiss="modal">
                            Cancel
                        </button>
                        <button class="btn btn-primary">
                            <i class="feather-save me-2"></i>
                            Save Vacancy
                        </button>
                    </div>

                </div>
            </form>
        </div>
    </div>

    {{-- ================= STYLES ================= --}}
    <style>
        .hr-vacancies-table th {
            font-size: 13px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .04em;
        }

        .hr-vacancies-table td {
            vertical-align: middle;
        }

        @media (max-width: 768px) {

            .hr-vacancies-table th:nth-child(3),
            .hr-vacancies-table td:nth-child(3) {
                display: none;
            }
        }
    </style>
@endsection
