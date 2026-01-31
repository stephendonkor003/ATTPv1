@extends('layouts.app')
@section('title', 'Programs')

@section('content')
    <main class="nxl-container">
        <div class="nxl-content">

            <!-- Page Header -->
            <div class="page-header d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="mb-1">Programs</h4>
                    <p class="text-muted mb-0">List of all programs created under various sectors.</p>
                </div>
                @can('program.create')
                    <a href="{{ route('budget.programs.create') }}" class="btn btn-success">
                        <i class="feather-plus-circle me-1"></i> New Program
                    </a>
                @endcan
            </div>

            <!-- Program Table -->
            <div class="card shadow-sm">
                <div class="card-body">

                    <x-data-table
                        id="programsTable"
                    >
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Program ID</th>
                                <th>Program Name</th>
                                <th>Sector</th>
                                <th>Governance</th>
                                <th>Projects Count</th>
                                <th>Created At</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($programs as $program)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td><span class="fw-semibold text-primary">{{ $program->program_id }}</span></td>
                                    <td>{{ $program->name }}</td>
                                    <td>
                                        <span class="badge bg-info-subtle text-info">
                                            {{ $program->sector->name ?? '—' }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="fw-semibold">
                                            {{ $program->governanceNode->name ?? '-' }}
                                        </div>
                                        <small class="text-muted">
                                            {{ $program->governanceNode->level->name ?? '' }}
                                        </small>
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary">
                                            {{ $program->projects->count() }}
                                        </span>
                                    </td>
                                    <td>{{ $program->created_at->format('d M, Y') }}</td>
                                    <td class="text-center">
                                        @can('program.view')
                                            <a href="{{ route('budget.programs.show', $program->id) }}"
                                                class="btn btn-sm btn-outline-info"
                                                title="View Program">
                                                <i class="feather-eye"></i>
                                            </a>
                                        @endcan
                                        @can('program.edit')
                                            <a href="{{ route('budget.programs.edit', $program->id) }}"
                                                class="btn btn-sm btn-outline-warning"
                                                title="Edit Program">
                                                <i class="feather-edit"></i>
                                            </a>
                                        @endcan
                                        @can('projects.show')
                                            <a href="{{ route('budget.projects.index', $program->id) }}"
                                                class="btn btn-sm btn-outline-primary"
                                                title="View Projects">
                                                <i class="feather-folder"></i>
                                            </a>
                                        @endcan
                                        @can('program.delete')
                                            <form action="{{ route('budget.programs.destroy', $program->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger"
                                                    onclick="return confirm('Delete this program?')"
                                                    title="Delete Program">
                                                    <i class="feather-trash-2"></i>
                                                </button>
                                            </form>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </x-data-table>

                </div>
            </div>

        </div>
    </main>
@endsection
