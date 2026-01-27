@extends('layouts.app')

@section('content')
    <div class="nxl-container">
        <div class="page-header mb-4 d-flex justify-content-between align-items-center">
            <div>
                <h4 class="fw-bold mb-1">System Audit Logs</h4>
                <p class="text-muted mb-0">Complete activity trail across the platform.</p>
            </div>
        </div>

        <div class="card shadow-sm mb-3">
            <div class="card-body">
                <form method="GET" class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label class="form-label">Action</label>
                        <select name="action" class="form-control">
                            <option value="">All actions</option>
                            <option value="login">Login</option>
                            <option value="logout">Logout</option>
                            <option value="login_failed">Login Failed</option>
                            <option value="request">Request</option>
                        </select>
                    </div>
                    <div class="col-md-5">
                        <label class="form-label">User (name or email)</label>
                        <input type="text" name="user" class="form-control" value="{{ request('user') }}">
                    </div>
                    <div class="col-md-3 text-md-end">
                        <button class="btn btn-primary">Filter</button>
                        <a href="{{ route('system.audit.index') }}" class="btn btn-outline-secondary">Reset</a>
                    </div>
                </form>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Date</th>
                                <th>User</th>
                                <th>Module</th>
                                <th>Action</th>
                                <th>Method</th>
                                <th>URL</th>
                                <th>IP</th>
                                <th>Country</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($logs as $log)
                                <tr>
                                    <td>{{ $log->created_at?->format('Y-m-d H:i:s') }}</td>
                                    <td>
                                        <div class="fw-semibold">{{ $log->user?->name ?? 'Guest' }}</div>
                                        <small class="text-muted">{{ $log->user?->email ?? '—' }}</small>
                                    </td>
                                    <td>
                                        <span class="badge bg-info-subtle text-info">
                                            {{ strtoupper($log->module ?? 'system') }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="fw-semibold">{{ $log->action_message ?? strtoupper($log->action ?? 'N/A') }}</div>
                                        @if ($log->action && $log->action_message)
                                            <small class="text-muted">{{ strtoupper($log->action) }}</small>
                                        @endif
                                    </td>
                                    <td>{{ $log->method ?? '—' }}</td>
                                    <td style="max-width: 320px; word-break: break-all;">
                                        {{ $log->url ?? '—' }}
                                    </td>
                                    <td>{{ $log->ip_address ?? '—' }}</td>
                                    <td>{{ $log->country ?? '—' }}</td>
                                    <td>{{ $log->status_code ?? '—' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center text-muted py-4">
                                        No audit records found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $logs->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
