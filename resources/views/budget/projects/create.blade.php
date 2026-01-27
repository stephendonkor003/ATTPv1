@extends('layouts.app')
@section('title', 'Create Project')

@section('content')
    <main class="nxl-container">
        <div class="nxl-content">

            <!-- Header -->
            <div class="page-header d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="mb-1">Create New Project</h4>
                    <p class="text-muted mb-0">Assign this project under a program and set its duration and budget
                        allocations.</p>
                </div>
                <a href="{{ route('projects.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left-circle me-1"></i> Back to Projects
                </a>
            </div>

            <!-- Alerts -->
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Form Card -->
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <form action="{{ route('projects.store') }}" method="POST">
                        @csrf

                        <div class="row g-4">

                            <!-- Sector -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Sector <span class="text-danger">*</span></label>
                                <select id="sectorSelect" class="form-select" required>
                                    <option value="">-- Select Sector --</option>
                                    @foreach ($sectors as $sector)
                                        <option value="{{ $sector->id }}">{{ $sector->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Program -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Program <span class="text-danger">*</span></label>
                                <select name="program_id" id="programSelect" class="form-select" required>
                                    <option value="">-- Select Program --</option>
                                    {{-- options will populate dynamically --}}
                                </select>
                                @error('program_id')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Project Name -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Project Name <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control" value="{{ old('name') }}"
                                    required placeholder="Enter project name">
                                @error('name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Total Budget -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Total Budget (GHS) <span
                                        class="text-danger">*</span></label>
                                <input type="number" name="total_budget" class="form-control" step="0.01" min="0"
                                    value="{{ old('total_budget') }}" required placeholder="0.00">
                                @error('total_budget')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Duration -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Project Duration (Years) <span
                                        class="text-danger">*</span></label>
                                <select name="duration_years" class="form-select" required>
                                    <option value="">-- Select Duration --</option>
                                    @for ($i = 1; $i <= 10; $i++)
                                        <option value="{{ $i }}"
                                            {{ old('duration_years') == $i ? 'selected' : '' }}>
                                            {{ $i }} Year{{ $i > 1 ? 's' : '' }}
                                        </option>
                                    @endfor
                                </select>
                                @error('duration_years')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Description -->
                            <div class="col-md-12">
                                <label class="form-label fw-semibold">Description</label>
                                <textarea name="description" rows="4" class="form-control" placeholder="Optional project description">{{ old('description') }}</textarea>
                            </div>

                        </div>

                        <!-- Actions -->
                        <div class="mt-4 text-end">
                            <a href="{{ route('projects.index') }}" class="btn btn-light border">Cancel</a>
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-check2-circle me-1"></i> Save Project
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </main>

    <script>
        // === Populate Programs when Sector changes ===
        const sectorPrograms = @json($sectors);

        document.getElementById('sectorSelect').addEventListener('change', function() {
            const sectorId = this.value;
            const programSelect = document.getElementById('programSelect');
            programSelect.innerHTML = '<option value="">-- Select Program --</option>';

            if (sectorId) {
                const selectedSector = sectorPrograms.find(s => s.id == sectorId);
                if (selectedSector && selectedSector.programs.length > 0) {
                    selectedSector.programs.forEach(program => {
                        const option = document.createElement('option');
                        option.value = program.id;
                        option.textContent = program.name;
                        programSelect.appendChild(option);
                    });
                } else {
                    const opt = document.createElement('option');
                    opt.textContent = 'No programs available';
                    programSelect.appendChild(opt);
                }
            }
        });
    </script>

@endsection
