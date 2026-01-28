@extends('layouts.app')

@section('title', 'Edit User')

@section('content')
    <main class="nxl-container">
        <div class="nxl-content">

            {{-- ================= PAGE HEADER ================= --}}
            <div class="page-header d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="mb-1">
                        <i class="bi bi-pencil-square me-1"></i>
                        Edit User
                    </h4>
                    <p class="text-muted mb-0">
                        Update user information and role assignment.
                    </p>
                </div>

                <a href="{{ route('system.users.index') }}" class="btn btn-light">
                    <i class="bi bi-arrow-left me-1"></i>
                    Back to Users
                </a>
            </div>

            {{-- ================= FLASH / ERRORS ================= --}}
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- ================= EDIT FORM ================= --}}
            <form method="POST" action="{{ route('system.users.update', $user->id) }}">
                @csrf
                @method('PUT')

                <div class="card shadow-sm border-0">
                    <div class="card-body">

                        <div class="row">

                            {{-- NAME --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">
                                    Full Name <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="name" class="form-control"
                                    value="{{ old('name', $user->name) }}" required
                                    {{ $user->role && $user->role->name === 'Super Admin' ? 'readonly' : '' }}>
                            </div>

                            {{-- EMAIL --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">
                                    Email Address <span class="text-danger">*</span>
                                </label>
                                <input type="email" name="email" class="form-control"
                                    value="{{ old('email', $user->email) }}" required
                                    {{ $user->role && $user->role->name === 'Super Admin' ? 'readonly' : '' }}>
                            </div>

                            {{-- ROLE --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">
                                    Role <span class="text-danger">*</span>
                                </label>

                                @if ($user->role && $user->role->name === 'Super Admin')
                                    <input type="text" class="form-control" value="Super Admin" disabled>
                                    <small class="text-muted">
                                        Super Admin role is protected and cannot be changed.
                                    </small>
                                @else
                                    <select name="role_id" class="form-select" required>
                                        <option value="">-- Select Role --</option>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->id }}"
                                                {{ old('role_id', $user->role_id) == $role->id ? 'selected' : '' }}>
                                                {{ $role->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <small class="text-muted">
                                        Changing role updates the user’s permissions.
                                    </small>
                                @endif
                            </div>

                            {{-- GOVERNANCE NODE --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">
                                    Governance Node <span class="text-danger">*</span>
                                </label>
                                <select name="governance_node_id" class="form-select" required
                                    {{ $user->role && $user->role->name === 'Super Admin' ? 'disabled' : '' }}>
                                    <option value="">-- Select Node --</option>
                                    @foreach ($nodes as $node)
                                        <option value="{{ $node->id }}"
                                            {{ old('governance_node_id', $user->governance_node_id) == $node->id ? 'selected' : '' }}>
                                            {{ $node->name }} ({{ $node->level->name ?? 'Level' }})
                                        </option>
                                    @endforeach
                                </select>
                                <small class="text-muted">
                                    Users can manage accounts in their node and all descendants.
                                </small>
                            </div>

                            {{-- PASSWORD INFO --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">
                                    Password
                                </label>
                                <input type="text" class="form-control" value="Not editable here" disabled>
                                <small class="text-muted">
                                    Use password reset to change user password.
                                </small>
                            </div>

                        </div>

                    </div>

                    {{-- ================= ACTION BUTTONS ================= --}}
                    <div class="card-footer bg-light d-flex justify-content-end gap-2">
                        <a href="{{ route('system.users.index') }}" class="btn btn-light">
                            Cancel
                        </a>

                        @if (!$user->role || $user->role->name !== 'Super Admin')
                            <form action="{{ route('system.users.reset-password', $user->id) }}"
                                method="POST" onsubmit="return confirm('Reset password and email user?');">
                                @csrf
                                <button type="submit" class="btn btn-outline-warning">
                                    <i class="bi bi-key me-1"></i>
                                    Reset Password
                                </button>
                            </form>
                        @endif

                        @if (!$user->role || $user->role->name !== 'Super Admin')
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="bi bi-save me-1"></i>
                                Update User
                            </button>
                        @endif
                    </div>
                </div>
            </form>

        </div>
    </main>
@endsection
