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
                        <i class="bi bi-plus-circle me-1"></i> New Program
                    </a>
                @endcan
            </div>

            <!-- Program Table -->
            <div class="card shadow-sm">
                <div class="card-body table-responsive">
                    <table class="table table-bordered align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Program ID</th>
                                <th>Program Name</th>
                                <th>Sector</th>
                                <th>Projects Count</th>
                                <th>Created At</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($programs as $index => $program)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td><span class="fw-semibold text-primary">{{ $program->program_id }}</span></td>
                                    <td>{{ $program->name }}</td>
                                    <td>{{ $program->sector->name ?? '—' }}</td>
                                    <td>{{ $program->projects->count() }}</td>
                                    <td>{{ $program->created_at->format('d M, Y') }}</td>
                                    <td class="text-center">
                                        @can('projects.show')
                                            <a href="{{ route('budget.projects.index', $program->id) }}"
                                                class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-folder2-open me-1"></i> View Projects
                                            </a>
                                        @endcan
                                        @can('program.delete')
                                            <form action="{{ route('budget.programs.destroy', $program->id) }}" method="POST"
                                                class="d-inline">

                                                @csrf
                                                @method('DELETE') <!-- 🔥 REQUIRED -->

                                                <button type="submit" class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Delete this program?')">
                                                    <i class="bi bi-trash3"></i>
                                                </button>
                                            </form>
                                        @endcan


                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">
                                        <i class="bi bi-info-circle me-1"></i> No programs found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if ($programs->hasPages())
                    <div class="card-footer bg-light border-top-0">
                        {{ $programs->links() }}
                    </div>
                @endif
            </div>

        </div>
    </main>
@endsection
