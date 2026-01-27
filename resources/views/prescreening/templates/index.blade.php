@extends('layouts.app')

@section('content')
    <div class="nxl-container">

        {{-- ================= HEADER ================= --}}
        <div class="page-header d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold">Prescreening Templates</h4>
                <p class="text-muted mb-0">
                    Manage prescreening configurations used for procurement evaluations
                </p>
            </div>

            <a href="{{ route('prescreening.templates.create') }}" class="btn btn-primary btn-sm">
                <i class="feather-plus me-1"></i> New Template
            </a>
        </div>

        {{-- ================= TABLE ================= --}}
        <div class="card shadow-sm">
            <div class="card-body p-0">
                <table class="table table-hover table-bordered align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th>Criteria</th>
                            <th width="160">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($templates as $template)
                            <tr>
                                <td class="fw-semibold">
                                    {{ $template->name }}
                                </td>

                                <td class="text-muted">
                                    {{ Str::limit($template->description, 80) ?? '—' }}
                                </td>

                                <td>
                                    <span class="badge {{ $template->is_active ? 'bg-success' : 'bg-secondary' }}">
                                        {{ $template->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>

                                <td class="text-center">
                                    {{ $template->criteria_count ?? $template->criteria->count() }}
                                </td>

                                <td class="text-center">
                                    <a href="{{ route('prescreening.templates.show', $template) }}"
                                        class="btn btn-sm btn-outline-primary">
                                        View
                                    </a>

                                    <a href="{{ route('prescreening.templates.edit', $template) }}"
                                        class="btn btn-sm btn-outline-secondary">
                                        Edit
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">
                                    No prescreening templates created yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection
