@extends('layouts.app')
@section('title', 'Projects under ' . ($program->name ?? 'Program'))

@section('content')

    <!-- =======================
                         PROGRAM INFO MODAL
                    ======================= -->
    <div class="modal fade" id="programInfoModal" tabindex="-1" aria-labelledby="programInfoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="programInfoModalLabel">
                        <i class="feather-folder me-2"></i> Program Information
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Program Name:</strong> {{ $program->name }}</p>
                    <p><strong>Sector:</strong> {{ $program->sector->name ?? 'N/A' }}</p>
                    <p><strong>Description:</strong></p>
                    <p class="text-muted">{{ $program->description ?? 'No description provided.' }}</p>
                    <hr>
                    <p class="mb-0">
                        <strong>Created On:</strong>
                        {{ $program->created_at ? $program->created_at->format('d M, Y') : 'N/A' }}
                    </p>
                    <p>
                        <strong>Total Projects:</strong> {{ $program->projects->count() }}
                    </p>

                </div>
                <div class="modal-footer">
                    <button class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        <i class="feather-x-circle me-1"></i> Close
                    </button>
                </div>
            </div>
        </div>
    </div>
    <main class="nxl-container">
        <div class="nxl-content">

            <!-- =======================
                         PAGE HEADER
                    ======================= -->
            <div class="page-header d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="mb-1">
                        <i class="feather-folder me-2 text-success"></i>
                        Projects under {{ $program->name }}
                    </h4>
                    <p class="text-muted mb-0">
                        Manage all projects created within the <strong>{{ $program->name }}</strong> portfolio.
                    </p>
                </div>
                <a href="{{ route('projects.create') }}" class="btn btn-success">
                    <i class="feather-plus-circle me-1"></i> Add Project
                </a>
            </div>

            <!-- =======================
                         ALERT MESSAGES
                    ======================= -->
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="feather-check-circle me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    <i class="feather-alert-triangle me-2"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- =======================
                         PROJECTS TABLE
                    ======================= -->
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="fw-semibold mb-0">
                            <i class="feather-list me-2 text-primary"></i> Total Projects:
                            <span class="text-dark">{{ $projects->count() }}</span>
                        </h6>
                        <button class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal"
                            data-bs-target="#programInfoModal">
                            <i class="feather-info me-1"></i> Program Details
                        </button>
                    </div>

                    <x-data-table
                        id="projectsTable"
                        :config="[
                            'order' => [[1, 'asc']],
                            'pageLength' => 25,
                            'lengthMenu' => [[10, 25, 50, 100, -1], [10, 25, 50, 100, 'All']],
                            'dom' => 'Bfrtip',
                            'buttons' => [
                                [
                                    'extend' => 'copy',
                                    'text' => '<i class=\"feather-copy\"></i> Copy',
                                    'className' => 'btn btn-sm btn-secondary'
                                ],
                                [
                                    'extend' => 'excel',
                                    'text' => '<i class=\"feather-file\"></i> Excel',
                                    'className' => 'btn btn-sm btn-success',
                                    'exportOptions' => ['columns' => ':visible:not(:last-child)']
                                ],
                                [
                                    'extend' => 'pdf',
                                    'text' => '<i class=\"feather-file-text\"></i> PDF',
                                    'className' => 'btn btn-sm btn-danger',
                                    'exportOptions' => ['columns' => ':visible:not(:last-child)']
                                ],
                                [
                                    'extend' => 'print',
                                    'text' => '<i class=\"feather-printer\"></i> Print',
                                    'className' => 'btn btn-sm btn-info',
                                    'exportOptions' => ['columns' => ':visible:not(:last-child)']
                                ],
                                [
                                    'extend' => 'colvis',
                                    'text' => '<i class=\"feather-eye\"></i> Columns',
                                    'className' => 'btn btn-sm btn-primary'
                                ]
                            ],
                            'columnDefs' => [
                                ['orderable' => false, 'targets' => [0, -1]],
                                ['searchable' => false, 'targets' => [0, -1]],
                                ['width' => '50px', 'targets' => 0],
                                ['width' => '120px', 'targets' => 1],
                                ['width' => '120px', 'targets' => -1]
                            ]
                        ]"
                    >
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Project ID</th>
                                <th>Project Name</th>
                                <th>Program</th>
                                <th>Total Budget (GHS)</th>
                                <th>Duration (Yrs)</th>
                                <th>Created On</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($projects as $project)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td><span class="fw-semibold text-primary">{{ $project->project_id }}</span></td>
                                    <td>{{ $project->name }}</td>
                                    <td>
                                        <span class="badge bg-success-subtle text-success">
                                            {{ $project->program->name ?? 'N/A' }}
                                        </span>
                                    </td>
                                    <td>{{ number_format($project->total_budget, 2) }}</td>
                                    <td>
                                        <span class="badge bg-secondary">
                                            {{ $project->duration_years }}
                                        </span>
                                    </td>
                                    <td>{{ $project->created_at->format('d M, Y') }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('projects.show', $project->id) }}"
                                            class="btn btn-sm btn-outline-info" title="View Details">
                                            <i class="feather-eye"></i>
                                        </a>
                                        <a href="{{ route('projects.edit', $project->id) }}"
                                            class="btn btn-sm btn-outline-warning" title="Edit Project">
                                            <i class="feather-edit"></i>
                                        </a>
                                        <form action="{{ route('projects.destroy', $project->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger"
                                                onclick="return confirm('Are you sure you want to delete this project?')"
                                                title="Delete Project">
                                                <i class="feather-trash-2"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted py-4">
                                        <i class="feather-info"></i>
                                        No projects have been added under this program yet.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </x-data-table>
                </div>
            </div>

        </div>
    </main>
@endsection
