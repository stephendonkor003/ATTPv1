@extends('layouts.app')

@section('title', 'Projects')

@section('content')
    <main class="nxl-container">
        <div class="nxl-content">

            {{-- PAGE HEADER --}}
            <div class="page-header d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="mb-1">Projects Management</h4>
                    <p class="text-muted m-0">Manage all projects and their activities under each program.</p>
                </div>

                {{-- CREATE PROJECT --}}
                @can('project.create')
                    <a href="{{ route('budget.projects.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle me-1"></i> New Project
                    </a>
                @endcan
            </div>

            {{-- ALERTS --}}
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            {{-- PROJECT LIST TABLE --}}
            <div class="card shadow-sm border-0">
                <div class="card-body table-responsive">

                    <table class="table table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Project ID</th>
                                <th>Name</th>
                                <th>Program</th>
                                <th>Total Budget</th>
                                <th>Years</th>
                                <th>Activities</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($projects as $index => $p)
                                <tr>
                                    <td>{{ $projects->firstItem() + $index }}</td>

                                    <td class="fw-bold">
                                        {{ $p->project_id }}
                                    </td>

                                    <td>{{ $p->name }}</td>

                                    <td>
                                        <span class="badge bg-secondary">
                                            {{ $p->program->program_id }}
                                        </span>
                                        <br>
                                        <small>{{ $p->program->name }}</small>
                                    </td>

                                    <td>
                                        {{ number_format($p->total_budget, 2) }}
                                        <small class="text-muted">{{ $p->currency }}</small>
                                    </td>

                                    <td>
                                        {{ $p->start_year }} → {{ $p->end_year }}
                                        <br>
                                        <small class="text-muted">{{ $p->total_years }} years</small>
                                    </td>

                                    {{-- ACTIVITIES COUNT --}}
                                    <td>
                                        <span class="badge bg-info text-dark">
                                            {{ $p->activities->count() }} Activities
                                        </span>
                                    </td>

                                    <td class="text-center">
                                        @can('activities.create')
                                            {{-- ADD ACTIVITY --}}
                                            <a href="{{ route('budget.activities.create', $p->id) }}"
                                                class="btn btn-sm btn-success mb-1" title="Add New Activity">
                                                <i class="bi bi-plus-circle"></i> Add Activity
                                            </a>
                                        @endcan

                                        {{-- VIEW PROJECT --}}
                                        <a href="{{ route('budget.projects.show', $p->id) }}"
                                            class="btn btn-sm btn-info mb-1" title="View Details">
                                            <i class="bi bi-eye"></i>
                                        </a>

                                        {{-- EDIT PROJECT --}}
                                        @can('project.edit')
                                            <a href="{{ route('budget.projects.edit', $p->id) }}"
                                                class="btn btn-sm btn-warning mb-1" title="Edit Project">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                        @endcan

                                        {{-- DELETE --}}
                                        @can('project.delete')
                                            <form action="{{ route('budget.projects.destroy', $p->id) }}" method="POST"
                                                class="d-inline"
                                                onsubmit="return confirm('Are you sure you want to delete this project?');">
                                                @csrf @method('DELETE')
                                                <button class="btn btn-sm btn-danger" title="Delete Project">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        @endcan

                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted py-4">
                                        <i class="bi bi-inbox fs-3 d-block"></i>
                                        No projects found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    {{-- PAGINATION --}}
                    <div class="mt-3">
                        {{ $projects->links() }}
                    </div>

                </div>
            </div>

        </div>
    </main>
@endsection
