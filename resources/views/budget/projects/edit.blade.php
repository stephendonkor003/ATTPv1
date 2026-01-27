@extends('layouts.app')
@section('title', 'Edit Project')

@section('content')
    <main class="nxl-container">
        <div class="nxl-content">

            <div class="page-header d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="mb-1">Edit Project</h4>
                    <p class="text-muted mb-0">Modify details for this project.</p>
                </div>
                <a href="{{ route('projects.index', $project->program_id) }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left-circle me-1"></i> Back to Projects
                </a>
            </div>

            <div class="card shadow-sm">
                <div class="card-body">
                    <form action="{{ route('projects.update', $project->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Project Name</label>
                                <input type="text" name="name" class="form-control"
                                    value="{{ old('name', $project->name) }}" required>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label fw-semibold">Total Budget (GHS)</label>
                                <input type="number" step="0.01" name="total_budget" class="form-control"
                                    value="{{ old('total_budget', $project->total_budget) }}" required>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label fw-semibold">Duration (Years)</label>
                                <input type="number" name="duration_years" class="form-control" min="1"
                                    max="10" value="{{ old('duration_years', $project->duration_years) }}" required>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label fw-semibold">Description</label>
                                <textarea name="description" class="form-control" rows="3">{{ old('description', $project->description) }}</textarea>
                            </div>
                        </div>

                        <div class="mt-4 d-flex justify-content-end gap-2">
                            <a href="{{ route('projects.index', $project->program_id) }}"
                                class="btn btn-light border">Cancel</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save2 me-1"></i> Update Project
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </main>
@endsection
