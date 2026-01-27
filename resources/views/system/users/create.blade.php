@extends('layouts.app')

@section('title', 'Create User')

@section('content')
    <main class="nxl-container">
        <div class="nxl-content">

            {{-- ================= PAGE HEADER ================= --}}
            <div class="page-header d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="mb-1">
                        <i class="bi bi-person-plus me-1"></i>
                        Create User
                    </h4>
                    <p class="text-muted mb-0">
                        Create a new system user and assign an access role.
                    </p>
                </div>

                <a href="{{ route('system.users.index') }}" class="btn btn-light">
                    <i class="bi bi-arrow-left me-1"></i>
                    Back to Users
                </a>
            </div>

            {{-- ================= VALIDATION ERRORS ================= --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- ================= CREATE USER FORM ================= --}}
            <form method="POST" action="{{ route('system.users.store') }}">
                @csrf

                <div class="card shadow-sm border-0">
                    <div class="card-body">

                        <div class="row">

                            {{-- NAME --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">
                                    Full Name <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="name" class="form-control" value="{{ old('name') }}"
                                    placeholder="Enter full name" required>
                            </div>

                            {{-- EMAIL --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">
                                    Email Address <span class="text-danger">*</span>
                                </label>
                                <input type="email" name="email" class="form-control" value="{{ old('email') }}"
                                    placeholder="Enter email address" required>
                            </div>

                            {{-- ROLE --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">
                                    Role <span class="text-danger">*</span>
                                </label>
                                <select name="role_id" class="form-select" required>
                                    <option value="">-- Select Role --</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}"
                                            {{ old('role_id') == $role->id ? 'selected' : '' }}>
                                            {{ $role->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <small class="text-muted">
                                    Determines what the user can access in the system.
                                </small>
                            </div>

                            {{-- PASSWORD INFO --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">
                                    Password
                                </label>
                                <input type="text" class="form-control" value="Auto-generated" disabled>
                                <small class="text-muted">
                                    A secure password will be generated automatically and emailed to the user.
                                </small>
                            </div>

                        </div>

                    </div>

                    {{-- ================= ACTION BUTTONS ================= --}}
                    <div class="card-footer bg-light d-flex justify-content-end gap-2">
                        <a href="{{ route('system.users.index') }}" class="btn btn-light">
                            Cancel
                        </a>

                        <button type="submit" class="btn btn-success px-4">
                            <i class="bi bi-check-circle me-1"></i>
                            Create User
                        </button>
                    </div>
                </div>
            </form>

        </div>
    </main>
@endsection
