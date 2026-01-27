@extends('layouts.app')

@section('title', 'Roles Management')

@section('content')
    <div class="nxl-container">

        {{-- ================= PAGE HEADER ================= --}}
        <div class="page-header mb-4 d-flex justify-content-between align-items-center">
            <div>
                <h4 class="fw-bold mb-1">
                    <i class="feather-shield me-2"></i>
                    Roles Management
                </h4>
                <p class="text-muted mb-0">
                    Manage system roles and assign permissions
                </p>
            </div>

            {{-- Add Role --}}
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createRoleModal">
                <i class="feather-plus-circle me-1"></i>
                Add New Role
            </button>
        </div>

        {{-- ================= FLASH MESSAGES ================= --}}
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                {{ $errors->first() }}
            </div>
        @endif

        {{-- ================= ROLES TABLE ================= --}}
        <div class="card shadow-sm border-0">
            <div class="card-body table-responsive">

                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th style="width:60px">#</th>
                            <th>Role Name</th>
                            <th>Description</th>
                            <th class="text-center">Permissions</th>
                            <th class="text-center" style="width:180px">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($roles as $index => $role)
                            <tr>
                                <td>{{ $index + 1 }}</td>

                                <td class="fw-semibold">
                                    {{ $role->name }}
                                </td>

                                <td>
                                    {{ $role->description ?? '—' }}
                                </td>

                                <td class="text-center">
                                    <span class="badge bg-info">
                                        {{ $role->permissions->count() }}
                                    </span>
                                </td>

                                <td class="text-center">

                                    {{-- Assign Permissions --}}
                                    <a href="{{ route('system.permissions.assign', $role->id) }}"
                                        class="btn btn-sm btn-outline-primary me-1" title="Assign Permissions">
                                        <i class="feather-lock"></i>
                                    </a>

                                    {{-- Edit Role --}}
                                    <a href="{{ route('system.roles.edit', $role->id) }}"
                                        class="btn btn-sm btn-outline-warning me-1" title="Edit Role">
                                        <i class="feather-edit"></i>
                                    </a>

                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">
                                    No roles defined yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

            </div>
        </div>
    </div>

    {{-- ================= CREATE ROLE MODAL ================= --}}
    <div class="modal fade" id="createRoleModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content border-0 shadow">

                <form method="POST" action="{{ route('system.roles.store') }}">
                    @csrf

                    <div class="modal-header">
                        <h5 class="modal-title fw-bold">
                            <i class="feather-plus-circle me-1"></i>
                            Create New Role
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">

                        {{-- Role Name --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                Role Name <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="name" class="form-control" placeholder="e.g. Administrator"
                                required>
                        </div>

                        {{-- Description --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                Description
                            </label>
                            <textarea name="description" class="form-control" rows="3" placeholder="Optional role description"></textarea>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                            Cancel
                        </button>

                        <button type="submit" class="btn btn-primary">
                            <i class="feather-save me-1"></i>
                            Save Role
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
@endsection
