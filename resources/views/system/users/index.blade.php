@extends('layouts.app')
@section('title', 'Users')

@section('content')
    <div class="nxl-container">

        {{-- PAGE HEADER --}}
        <div class="page-header d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold mb-1">
                    <i class="feather-users text-primary me-2"></i>
                    Users Management
                </h4>
                <p class="text-muted mb-0">
                    Manage users, roles, and access permissions.
                </p>
            </div>

            <a href="{{ route('system.users.create') }}" class="btn btn-primary btn-sm">
                <i class="feather-user-plus me-1"></i> Create User
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
            <div class="card-body">
                <x-data-table id="usersTable">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">User</th>
                            <th>Email</th>
                            <th>Governance</th>
                            <th>Role</th>
                            <th class="text-center">Permissions</th>
                            <th>Created</th>
                            <th class="text-center" width="180">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td class="ps-4">
                                    <div class="fw-semibold">{{ $user->name }}</div>
                                    <small class="text-muted">{{ ucfirst($user->user_type) }}</small>
                                </td>

                                <td>{{ $user->email }}</td>

                                <td>
                                    <div class="fw-medium">
                                        {{ $user->governanceNode->name ?? '—' }}
                                    </div>
                                    <small class="text-muted">
                                        {{ $user->governanceNode->level->name ?? '' }}
                                    </small>
                                </td>

                                {{-- ROLE --}}
                                <td>
                                    @if ($user->role && $user->role->name === 'Super Admin')
                                        <span class="badge bg-danger px-3 py-1">
                                            <i class="feather-shield me-1"></i>
                                            Super Admin
                                        </span>
                                    @else
                                        <form method="POST"
                                            action="{{ route('system.users.role.update', $user->id) }}">
                                            @csrf
                                            @method('PUT')

                                            <select name="role_id" class="form-select form-select-sm"
                                                onchange="this.form.submit()" style="min-width: 140px;">
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
                                <td class="text-center">
                                    @if ($user->role && $user->role->permissions->count())
                                        <span class="badge bg-info px-3 py-1">
                                            {{ $user->role->permissions->count() }}
                                        </span>
                                    @else
                                        <span class="badge bg-secondary px-3 py-1">0</span>
                                    @endif
                                </td>

                                <td>{{ $user->created_at->format('d M Y') }}</td>

                                {{-- ACTIONS --}}
                                <td class="text-center">
                                    <div class="d-inline-flex gap-1">
                                        <a href="{{ route('system.users.edit', $user->id) }}"
                                            class="btn btn-sm btn-outline-success" title="Edit User">
                                            <i class="feather-edit"></i>
                                        </a>

                                        @if (!$user->role || $user->role->name !== 'Super Admin')
                                            <a href="{{ route('system.users.permissions', $user->id) }}"
                                                class="btn btn-sm btn-outline-primary"
                                                title="Assign Direct Permissions">
                                                <i class="feather-lock"></i>
                                            </a>

                                            <form action="{{ route('system.users.reset-password', $user->id) }}"
                                                method="POST" class="d-inline"
                                                onsubmit="return confirm('Reset password and email user?');">
                                                @csrf
                                                <button class="btn btn-sm btn-outline-warning" title="Reset Password">
                                                    <i class="feather-key"></i>
                                                </button>
                                            </form>

                                            <form action="{{ route('system.users.destroy', $user->id) }}"
                                                method="POST" class="d-inline"
                                                onsubmit="return confirm('Delete this user?');">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-outline-danger" title="Delete User">
                                                    <i class="feather-trash-2"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </x-data-table>
            </div>
        </div>

    </div>
@endsection
