@extends('layouts.app')

@section('content')
    <div class="nxl-container">

        <div class="page-header d-flex justify-content-between align-items-center mb-3">
            <div>
                <h4 class="fw-bold">Prescreening Criteria</h4>
                <p class="text-muted mb-0">
                    Template: <strong>{{ $template->name }}</strong>
                </p>
            </div>

            <a href="{{ route('prescreening.criteria.create', $template) }}" class="btn btn-primary btn-sm">
                <i class="feather-plus me-1"></i> Add Criterion
            </a>
        </div>

        <div class="card shadow-sm">
            <div class="card-body p-0">
                <table class="table table-hover table-bordered align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Order</th>
                            <th>Name</th>
                            <th>Field Key</th>
                            <th>Type</th>
                            <th>Mandatory</th>
                            <th width="160">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($criteria as $criterion)
                            <tr>
                                <td>{{ $criterion->sort_order }}</td>
                                <td class="fw-semibold">{{ $criterion->name }}</td>
                                <td><code>{{ $criterion->field_key }}</code></td>
                                <td>{{ ucfirst(str_replace('_', ' ', $criterion->evaluation_type)) }}</td>
                                <td>
                                    <span class="badge {{ $criterion->is_mandatory ? 'bg-success' : 'bg-secondary' }}">
                                        {{ $criterion->is_mandatory ? 'Yes' : 'No' }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('prescreening.criteria.show', [$template, $criterion]) }}"
                                        class="btn btn-sm btn-outline-primary">View</a>

                                    <a href="{{ route('prescreening.criteria.edit', [$template, $criterion]) }}"
                                        class="btn btn-sm btn-outline-secondary">Edit</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">
                                    No criteria defined yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection
