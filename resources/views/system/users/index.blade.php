@extends('layouts.app')
@section('title', 'Users')

@section('content')
    <main class="nxl-container">
        <div class="nxl-content">

            {{-- PAGE HEADER --}}
            <div class="page-header d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="mb-1">Users</h4>
                    <p class="text-muted mb-0">
                        Manage users, roles, and access permissions.
                    </p>
                </div>

                <a href="{{ route('system.users.create') }}" class="btn btn-success">
                    <i class="bi bi-person-plus me-1"></i> Create User
                </a>
            </div>

            {{-- FLASH --}}
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <div class="card shadow-sm border-0">
                <div class="card-body table-responsive">
                    <table class="table table-striped align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>User</th>
                                <th>Email</th>
                                <th>Governance</th>
                                <th>Role</th>
                                <th>Permissions</th>
                                <th>Created</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($users as $index => $user)
                                <tr>
                                    <td>{{ $index + 1 }}</td>

                                    <td>
                                        <div class="fw-semibold">{{ $user->name }}</div>
                                        <small class="text-muted">{{ ucfirst($user->user_type) }}</small>
                                    </td>

                                    <td>{{ $user->email }}</td>

                                    <td>
                                        <div class="fw-semibold">
                                            {{ $user->governanceNode->name ?? '-' }}
                                        </div>
                                        <small class="text-muted">
                                            {{ $user->governanceNode->level->name ?? '' }}
                                        </small>
                                    </td>

                                    {{-- ROLE --}}
                                    <td>
                                        @if ($user->role && $user->role->name === 'Super Admin')
                                            <span class="badge bg-danger">
                                                <i class="bi bi-shield-lock me-1"></i>
                                                Super Admin
                                            </span>
                                            <div class="small text-muted mt-1">Locked</div>
                                        @else
                                            <form method="POST"
                                                action="{{ route('system.users.role.update', $user->id) }}">
                                                @csrf
                                                @method('PUT')

                                                <select name="role_id" class="form-select form-select-sm"
                                                    onchange="this.form.submit()">
                                                    <option value="">Select role</option>
                                                    @foreach ($roles as $role)
                                                        <option value="{{ $role->id }}"
                                                            {{ $user->role_id === $role->id ? 'selected' : '' }}>
                                                            {{ $role->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </form>
                                        @endif
                                    </td>

                                    {{-- PERMISSIONS --}}
                                    <td>
                                        @if ($user->role && $user->role->permissions->count())
                                            <span class="badge bg-info">
                                                {{ $user->role->permissions->count() }} permissions
                                            </span>
                                            <div class="small text-muted mt-1">
                                                {{ $user->role->permissions->pluck('name')->take(2)->join(', ') }}
                                                @if ($user->role->permissions->count() > 2)
                                                    …
                                                @endif
                                            </div>
                                        @else
                                            <span class="badge bg-secondary">None</span>
                                        @endif
                                    </td>

                                    <td>{{ $user->created_at->format('d M, Y') }}</td>

                                    {{-- ACTIONS --}}
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-2">

                                            {{-- EDIT --}}
                                            <a href="{{ route('system.users.edit', $user->id) }}"
                                                class="btn btn-sm btn-outline-success" title="Edit User">
                                                <i class="bi bi-pencil"></i>
                                            </a>

                                            {{-- DIRECT PERMISSIONS --}}
                                            @if (!$user->role || $user->role->name !== 'Super Admin')
                                                <a href="{{ route('system.users.permissions', $user->id) }}"
                                                    class="btn btn-sm btn-outline-primary"
                                                    title="Assign Direct Permissions">
                                                    <i class="bi bi-lock"></i>
                                                </a>
                                            @else
                                                <span class="badge bg-secondary">
                                                    <i class="bi bi-shield-lock"></i>
                                                </span>
                                            @endif

                                            {{-- RESET PASSWORD --}}
                                            @if (!$user->role || $user->role->name !== 'Super Admin')
                                                <form action="{{ route('system.users.reset-password', $user->id) }}"
                                                    method="POST" onsubmit="return confirm('Reset password and email user?');">
                                                    @csrf
                                                    <button class="btn btn-sm btn-outline-warning" title="Reset Password">
                                                        <i class="bi bi-key"></i>
                                                    </button>
                                                </form>
                                            @endif

                                            {{-- DELETE --}}
                                            @if (!$user->role || $user->role->name !== 'Super Admin')
                                                <form action="{{ route('system.users.destroy', $user->id) }}"
                                                    method="POST" onsubmit="return confirm('Delete this user?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-sm btn-outline-danger">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            @endif

                                        </div>
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted py-4">
                                        No users found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </main>
@endsection
