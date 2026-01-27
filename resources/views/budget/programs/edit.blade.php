@extends('layouts.app')
@section('title', 'Edit Program')

@section('content')
    <main class="nxl-container">
        <div class="nxl-content">

            <!-- Header -->
            <div class="page-header d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="mb-1">Edit Program</h4>
                    <p class="text-muted mb-0">Update program information below.</p>
                </div>
                <a href="{{ route('programs.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left-circle me-1"></i> Back to Programs
                </a>
            </div>

            <!-- Card -->
            <div class="card shadow-sm">
                <div class="card-body">
                    <form action="{{ route('programs.update', $program->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row g-4">
                            <!-- Sector -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Sector <span class="text-danger">*</span></label>
                                <select name="sector_id" class="form-select" required>
                                    @foreach ($sectors as $sector)
                                        <option value="{{ $sector->id }}"
                                            {{ $program->sector_id == $sector->id ? 'selected' : '' }}>
                                            {{ $sector->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('sector_id')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Program Name -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Program Name <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control"
                                    value="{{ old('name', $program->name) }}" required>
                                @error('name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Description -->
                            <div class="col-md-12">
                                <label class="form-label fw-semibold">Description</label>
                                <textarea name="description" class="form-control" rows="3">{{ old('description', $program->description) }}</textarea>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="mt-4 d-flex justify-content-end gap-2">
                            <a href="{{ route('programs.index') }}" class="btn btn-light border">Cancel</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save2 me-1"></i> Update Program
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </main>
@endsection
