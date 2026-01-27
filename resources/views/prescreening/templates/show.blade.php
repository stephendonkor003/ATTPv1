@extends('layouts.app')

@section('content')
    <div class="nxl-container">

        {{-- ================= HEADER ================= --}}
        <div class="page-header d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold">Prescreening Template</h4>
                <p class="text-muted mb-0">
                    Template details and defined criteria
                </p>
            </div>

            <div>
                <a href="{{ route('prescreening.templates.edit', $template) }}" class="btn btn-outline-secondary btn-sm">
                    <i class="feather-edit me-1"></i> Edit
                </a>

                <a href="{{ route('prescreening.templates.index') }}" class="btn btn-outline-secondary btn-sm">
                    Back
                </a>
            </div>
        </div>

        {{-- ================= TEMPLATE INFO ================= --}}
        <div class="card shadow-sm mb-4">
            <div class="card-body row g-3">

                <div class="col-md-6">
                    <div class="text-muted small">Template Name</div>
                    <div class="fw-semibold fs-6">
                        {{ $template->name }}
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="text-muted small">Status</div>
                    <span class="badge {{ $template->is_active ? 'bg-success' : 'bg-secondary' }}">
                        {{ $template->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </div>

                <div class="col-md-12">
                    <div class="text-muted small">Description</div>
                    <div class="border rounded p-3 bg-light">
                        {{ $template->description ?? 'No description provided.' }}
                    </div>
                </div>

            </div>
        </div>

        {{-- ================= CRITERIA ================= --}}
        <div class="card shadow-sm">
            <div class="card-header bg-light">
                <h6 class="fw-semibold mb-0">Defined Criteria</h6>
            </div>

            <div class="card-body p-0">
                <table class="table table-bordered align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Criterion</th>
                            <th>Field Key</th>
                            <th>Type</th>
                            <th>Mandatory</th>
                            <th>Min Value</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($template->criteria as $index => $criterion)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td class="fw-semibold">{{ $criterion->name }}</td>
                                <td><code>{{ $criterion->field_key }}</code></td>
                                <td>{{ ucfirst(str_replace('_', ' ', $criterion->evaluation_type)) }}</td>
                                <td>
                                    <span class="badge {{ $criterion->is_mandatory ? 'bg-success' : 'bg-secondary' }}">
                                        {{ $criterion->is_mandatory ? 'Yes' : 'No' }}
                                    </span>
                                </td>
                                <td>{{ $criterion->min_value ?? '—' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">
                                    No criteria defined.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection
