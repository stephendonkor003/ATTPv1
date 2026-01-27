@extends('layouts.app')
@section('title', 'Sectors')

@section('content')
    <main class="nxl-container">
        <div class="nxl-content">

            <!-- Header -->
            <div class="page-header d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="mb-1">All Sectors</h4>
                    <p class="text-muted mb-0">View and manage all available sectors in the system.</p>
                </div>
                <a href="{{ route('sectors.create') }}" class="btn btn-success">
                    <i class="bi bi-plus-circle me-1"></i> Add New Sector
                </a>
            </div>

            <!-- Sector Table -->
            <div class="card shadow-sm border-0">
                <div class="card-body table-responsive">
                    <table class="table align-middle table-striped">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Programs</th>
                                <th>Created</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($sectors as $sector)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $sector->name }}</td>
                                    <td>{{ Str::limit($sector->description, 50) ?? '—' }}</td>
                                    <td>{{ $sector->programs->count() }}</td>
                                    <td>{{ $sector->created_at->format('d M Y') }}</td>
                                    <td class="text-end">
                                        <a href="{{ route('sectors.show', $sector->id) }}" class="btn btn-sm btn-info">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('sectors.edit', $sector->id) }}" class="btn btn-sm btn-warning">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <form action="{{ route('sectors.destroy', $sector->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-danger"
                                                onclick="return confirm('Delete this sector?')">
                                                <i class="bi bi-trash3"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">No sectors found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </main>
@endsection
