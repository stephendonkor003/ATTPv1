@extends('layouts.app')

@section('content')
    <div class="nxl-container">
        <div class="page-header d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
            <div>
                <h4 class="fw-bold mb-1">Governance Structure</h4>
                <p class="text-muted mb-0">
                    Configure organizational levels, reporting lines, and assignments with effective dates.
                </p>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success mt-3">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger mt-3">
                {{ $errors->first() }}
            </div>
        @endif

        <ul class="nav nav-tabs mt-3" id="governanceTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="nodes-tab" data-bs-toggle="tab" data-bs-target="#nodesTab"
                    type="button" role="tab" aria-controls="nodesTab" aria-selected="true">
                    Structure Nodes
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="lines-tab" data-bs-toggle="tab" data-bs-target="#linesTab" type="button"
                    role="tab" aria-controls="linesTab" aria-selected="false">
                    Reporting Lines
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="assignments-tab" data-bs-toggle="tab" data-bs-target="#assignmentsTab"
                    type="button" role="tab" aria-controls="assignmentsTab" aria-selected="false">
                    Assignments
                </button>
            </li>
        </ul>

        <div class="tab-content mt-3">
            <div class="tab-pane fade show active" id="nodesTab" role="tabpanel" aria-labelledby="nodes-tab">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2">
                            <div>
                                <h6 class="fw-bold mb-1">Structure Nodes</h6>
                                <p class="text-muted small mb-0">Define Organ &rarr; Commission &rarr; Department &rarr; Directorate &rarr;
                                    Division/Unit.</p>
                            </div>
                        </div>

                        @canany(['finance.governance_structure.create', 'finance.governance_structure.manage'])
                            <hr>
                            <form method="POST" action="{{ route('finance.governance.nodes.store') }}" class="row g-3">
                                @csrf
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Level</label>
                                    <select name="level_id" class="form-select" required>
                                        <option value="">-- Select Level --</option>
                                        @foreach ($levels as $level)
                                            <option value="{{ $level->id }}">{{ $level->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Name</label>
                                    <input type="text" name="name" class="form-control" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Code</label>
                                    <input type="text" name="code" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Effective Start</label>
                                    <input type="date" name="effective_start" class="form-control">
                                </div>
                                <div class="col-md-8">
                                    <label class="form-label fw-semibold">Description</label>
                                    <input type="text" name="description" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Status</label>
                                    <select name="status" class="form-select" required>
                                        <option value="active">Active</option>
                                        <option value="inactive">Inactive</option>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <button class="btn btn-primary">
                                        <i class="feather-plus-circle me-1"></i> Add Node
                                    </button>
                                </div>
                            </form>
                        @endcanany
                    </div>
                </div>

                <div class="card shadow-sm border-0 mt-3">
                    <div class="card-body table-responsive">
                        <table class="table table-bordered align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Level</th>
                                    <th>Name</th>
                                    <th>Code</th>
                                    <th>Status</th>
                                    <th>Effective Start</th>
                                    <th width="140" class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($nodes as $node)
                                    <tr>
                                        <td>{{ $node->level->name ?? '-' }}</td>
                                        <td>
                                            <div class="fw-semibold">{{ $node->name }}</div>
                                            <div class="text-muted small">
                                                {{ $node->description ?? '-' }}
                                            </div>
                                        </td>
                                        <td>{{ $node->code ?? '-' }}</td>
                                        <td>
                                            <span
                                                class="badge {{ $node->status === 'active' ? 'bg-success' : 'bg-secondary' }}">
                                                {{ ucfirst($node->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="small">
                                                {{ $node->effective_start?->format('d M Y') ?? '-' }}
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center gap-2">
                                                @canany(['finance.governance_structure.edit', 'finance.governance_structure.manage'])
                                                    <button class="btn btn-sm btn-outline-warning" type="button"
                                                        data-bs-toggle="collapse"
                                                        data-bs-target="#editNodeRow{{ $node->id }}"
                                                        aria-expanded="false" aria-controls="editNodeRow{{ $node->id }}">
                                                        Edit
                                                    </button>
                                                @endcanany
                                                @canany(['finance.governance_structure.delete', 'finance.governance_structure.manage'])
                                                    <form method="POST"
                                                        action="{{ route('finance.governance.nodes.destroy', $node) }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-sm btn-outline-danger"
                                                            onclick="return confirm('Delete this node?')">
                                                            Delete
                                                        </button>
                                                    </form>
                                                @endcanany
                                            </div>
                                        </td>
                                    </tr>
                                    @canany(['finance.governance_structure.edit', 'finance.governance_structure.manage'])
                                        <tr class="collapse" id="editNodeRow{{ $node->id }}">
                                            <td colspan="6">
                                                <div class="border rounded p-3 bg-light">
                                                    <form method="POST"
                                                        action="{{ route('finance.governance.nodes.update', $node) }}"
                                                        class="row g-3">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="col-md-4">
                                                            <label class="form-label fw-semibold">Level</label>
                                                            <select name="level_id" class="form-select" required>
                                                                @foreach ($levels as $level)
                                                                    <option value="{{ $level->id }}"
                                                                        @selected($node->level_id == $level->id)>
                                                                        {{ $level->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="form-label fw-semibold">Name</label>
                                                            <input type="text" name="name" class="form-control"
                                                                value="{{ $node->name }}" required>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="form-label fw-semibold">Code</label>
                                                            <input type="text" name="code" class="form-control"
                                                                value="{{ $node->code }}">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label fw-semibold">Effective Start</label>
                                                            <input type="date" name="effective_start"
                                                                class="form-control"
                                                                value="{{ optional($node->effective_start)->format('Y-m-d') }}">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label fw-semibold">Status</label>
                                                            <select name="status" class="form-select" required>
                                                                <option value="active"
                                                                    @selected($node->status === 'active')>Active</option>
                                                                <option value="inactive"
                                                                    @selected($node->status === 'inactive')>Inactive</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <label class="form-label fw-semibold">Description</label>
                                                            <input type="text" name="description" class="form-control"
                                                                value="{{ $node->description }}">
                                                        </div>
                                                        <div class="col-12 d-flex gap-2">
                                                            <button class="btn btn-primary">Save Changes</button>
                                                            <button class="btn btn-light" type="button"
                                                                data-bs-toggle="collapse"
                                                                data-bs-target="#editNodeRow{{ $node->id }}">
                                                                Cancel
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endcanany
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted py-4">No nodes created yet.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="linesTab" role="tabpanel" aria-labelledby="lines-tab">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2">
                            <div>
                                <h6 class="fw-bold mb-1">Reporting Lines</h6>
                                <p class="text-muted small mb-0">Use primary lines for hierarchy, dotted/advisory for
                                    matrix structures.</p>
                                <div class="small text-muted mt-2">
                                    <div><strong>Primary:</strong> formal hierarchy (one active primary per node).</div>
                                    <div><strong>Dotted:</strong> matrix reporting for cross-functional work.</div>
                                    <div><strong>Advisory:</strong> guidance relationship without line authority.</div>
                                    <div><strong>Effective dates:</strong> define when each line is valid.</div>
                                </div>
                            </div>
                        </div>

                        @canany(['finance.governance_structure.create', 'finance.governance_structure.manage'])
                            <hr>
                            <form method="POST" action="{{ route('finance.governance.lines.store') }}" class="row g-3">
                                @csrf
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Child Node</label>
                                    <select name="child_node_id" class="form-select" required>
                                        <option value="">-- Select Node --</option>
                                        @foreach ($nodes as $node)
                                            <option value="{{ $node->id }}">
                                                {{ $node->name }} ({{ $node->level->name ?? 'Level' }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Parent Node</label>
                                    <select name="parent_node_id" class="form-select" required>
                                        <option value="">-- Select Node --</option>
                                        @foreach ($nodes as $node)
                                            <option value="{{ $node->id }}">
                                                {{ $node->name }} ({{ $node->level->name ?? 'Level' }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Line Type</label>
                                    <select name="line_type" class="form-select" required>
                                        <option value="primary">Primary (Hierarchy)</option>
                                        <option value="dotted">Dotted (Matrix)</option>
                                        <option value="advisory">Advisory</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Effective Start</label>
                                    <input type="date" name="effective_start" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Effective End</label>
                                    <input type="date" name="effective_end" class="form-control">
                                </div>
                                <div class="col-12">
                                    <button class="btn btn-primary">
                                        <i class="feather-plus-circle me-1"></i> Add Reporting Line
                                    </button>
                                </div>
                            </form>
                        @endcanany
                    </div>
                </div>

                <div class="card shadow-sm border-0 mt-3">
                    <div class="card-body table-responsive">
                        <table class="table table-bordered align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Child Node</th>
                                    <th>Parent Node</th>
                                    <th>Type</th>
                                    <th>Effective</th>
                                    <th width="140" class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($lines as $line)
                                    <tr>
                                        <td>
                                            {{ $line->child->name ?? '-' }}
                                            <div class="text-muted small">{{ $line->child->level->name ?? '' }}</div>
                                        </td>
                                        <td>
                                            {{ $line->parent->name ?? '-' }}
                                            <div class="text-muted small">{{ $line->parent->level->name ?? '' }}</div>
                                        </td>
                                        <td>
                                            <span class="badge bg-light text-dark">{{ ucfirst($line->line_type) }}</span>
                                        </td>
                                        <td>
                                            <div class="small">
                                                {{ $line->effective_start?->format('d M Y') ?? '-' }}
                                                &rarr;
                                                {{ $line->effective_end?->format('d M Y') ?? 'Open' }}
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center gap-2">
                                                @canany(['finance.governance_structure.edit', 'finance.governance_structure.manage'])
                                                    <button class="btn btn-sm btn-outline-warning" type="button"
                                                        data-bs-toggle="collapse"
                                                        data-bs-target="#editLineRow{{ $line->id }}"
                                                        aria-expanded="false" aria-controls="editLineRow{{ $line->id }}">
                                                        Edit
                                                    </button>
                                                @endcanany
                                                @canany(['finance.governance_structure.delete', 'finance.governance_structure.manage'])
                                                    <form method="POST"
                                                        action="{{ route('finance.governance.lines.destroy', $line) }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-sm btn-outline-danger"
                                                            onclick="return confirm('Delete this reporting line?')">
                                                            Delete
                                                        </button>
                                                    </form>
                                                @endcanany
                                            </div>
                                        </td>
                                    </tr>
                                    @canany(['finance.governance_structure.edit', 'finance.governance_structure.manage'])
                                        <tr class="collapse" id="editLineRow{{ $line->id }}">
                                            <td colspan="5">
                                                <div class="border rounded p-3 bg-light">
                                                    <form method="POST"
                                                        action="{{ route('finance.governance.lines.update', $line) }}"
                                                        class="row g-3">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="col-md-6">
                                                            <label class="form-label fw-semibold">Child Node</label>
                                                            <select name="child_node_id" class="form-select" required>
                                                                @foreach ($nodes as $node)
                                                                    <option value="{{ $node->id }}"
                                                                        @selected($line->child_node_id == $node->id)>
                                                                        {{ $node->name }} ({{ $node->level->name ?? 'Level' }})
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label fw-semibold">Parent Node</label>
                                                            <select name="parent_node_id" class="form-select" required>
                                                                @foreach ($nodes as $node)
                                                                    <option value="{{ $node->id }}"
                                                                        @selected($line->parent_node_id == $node->id)>
                                                                        {{ $node->name }} ({{ $node->level->name ?? 'Level' }})
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="form-label fw-semibold">Line Type</label>
                                                            <select name="line_type" class="form-select" required>
                                                                <option value="primary"
                                                                    @selected($line->line_type === 'primary')>Primary (Hierarchy)</option>
                                                                <option value="dotted"
                                                                    @selected($line->line_type === 'dotted')>Dotted (Matrix)</option>
                                                                <option value="advisory"
                                                                    @selected($line->line_type === 'advisory')>Advisory</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="form-label fw-semibold">Effective Start</label>
                                                            <input type="date" name="effective_start"
                                                                class="form-control"
                                                                value="{{ optional($line->effective_start)->format('Y-m-d') }}">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="form-label fw-semibold">Effective End</label>
                                                            <input type="date" name="effective_end"
                                                                class="form-control"
                                                                value="{{ optional($line->effective_end)->format('Y-m-d') }}">
                                                        </div>
                                                        <div class="col-12 d-flex gap-2">
                                                            <button class="btn btn-primary">Save Changes</button>
                                                            <button class="btn btn-light" type="button"
                                                                data-bs-toggle="collapse"
                                                                data-bs-target="#editLineRow{{ $line->id }}">
                                                                Cancel
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endcanany
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-4">No reporting lines created yet.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="assignmentsTab" role="tabpanel" aria-labelledby="assignments-tab">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2">
                            <div>
                                <h6 class="fw-bold mb-1">Assignments</h6>
                                <p class="text-muted small mb-0">Assign employees and roles to governance nodes with
                                    effective dates.</p>
                            </div>
                        </div>

                        @canany(['finance.governance_structure.create', 'finance.governance_structure.manage'])
                            <hr>
                            <form method="POST" action="{{ route('finance.governance.assignments.store') }}"
                                class="row g-3">
                                @csrf
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Node</label>
                                    <select name="node_id" class="form-select" required>
                                        <option value="">-- Select Node --</option>
                                        @foreach ($nodes as $node)
                                            <option value="{{ $node->id }}">
                                                {{ $node->name }} ({{ $node->level->name ?? 'Level' }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Employee</label>
                                    <input type="text" class="form-control user-search mb-2"
                                        placeholder="Search employee name or email">
                                    <select name="user_id" class="form-select" required>
                                        <option value="">-- Select Employee --</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }} - {{ $user->email }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Role Title</label>
                                    <input type="text" name="role_title" class="form-control">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label fw-semibold">Effective Start</label>
                                    <input type="date" name="effective_start" class="form-control">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label fw-semibold">Effective End</label>
                                    <input type="date" name="effective_end" class="form-control">
                                </div>
                                <div class="col-md-3">
                                    <div class="form-check mt-4">
                                        <input class="form-check-input" type="checkbox" value="1" name="is_primary"
                                            id="assignmentPrimary">
                                        <label class="form-check-label fw-semibold" for="assignmentPrimary">
                                            Primary Assignment
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check mt-4">
                                        <input class="form-check-input" type="checkbox" value="1" name="notify_user"
                                            id="assignmentNotify">
                                        <label class="form-check-label fw-semibold" for="assignmentNotify">
                                            Email notification to user
                                        </label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button class="btn btn-primary">
                                        <i class="feather-plus-circle me-1"></i> Add Assignment
                                    </button>
                                </div>
                            </form>
                        @endcanany
                    </div>
                </div>

                <div class="card shadow-sm border-0 mt-3">
                    <div class="card-body table-responsive">
                        <table class="table table-bordered align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Node</th>
                                    <th>Employee</th>
                                    <th>Role</th>
                                    <th>Primary</th>
                                    <th>Effective</th>
                                    <th width="140" class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($assignments as $assignment)
                                    <tr>
                                        <td>
                                            {{ $assignment->node->name ?? '-' }}
                                            <div class="text-muted small">{{ $assignment->node->level->name ?? '' }}</div>
                                        </td>
                                        <td>
                                            {{ $assignment->user->name ?? '-' }}
                                            <div class="text-muted small">{{ $assignment->user->email ?? '' }}</div>
                                        </td>
                                        <td>{{ $assignment->role_title ?? '-' }}</td>
                                        <td>
                                            <span
                                                class="badge {{ $assignment->is_primary ? 'bg-success' : 'bg-secondary' }}">
                                                {{ $assignment->is_primary ? 'Yes' : 'No' }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="small">
                                                {{ $assignment->effective_start?->format('d M Y') ?? '-' }}
                                                &rarr;
                                                {{ $assignment->effective_end?->format('d M Y') ?? 'Open' }}
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center gap-2">
                                                @canany(['finance.governance_structure.edit', 'finance.governance_structure.manage'])
                                                    <button class="btn btn-sm btn-outline-warning" type="button"
                                                        data-bs-toggle="collapse"
                                                        data-bs-target="#editAssignmentRow{{ $assignment->id }}"
                                                        aria-expanded="false"
                                                        aria-controls="editAssignmentRow{{ $assignment->id }}">
                                                        Edit
                                                    </button>
                                                @endcanany
                                                @canany(['finance.governance_structure.delete', 'finance.governance_structure.manage'])
                                                    <form method="POST"
                                                        action="{{ route('finance.governance.assignments.destroy', $assignment) }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-sm btn-outline-danger"
                                                            onclick="return confirm('Delete this assignment?')">
                                                            Delete
                                                        </button>
                                                    </form>
                                                @endcanany
                                            </div>
                                        </td>
                                    </tr>
                                    @canany(['finance.governance_structure.edit', 'finance.governance_structure.manage'])
                                        <tr class="collapse" id="editAssignmentRow{{ $assignment->id }}">
                                            <td colspan="6">
                                                <div class="border rounded p-3 bg-light">
                                                    <form method="POST"
                                                        action="{{ route('finance.governance.assignments.update', $assignment) }}"
                                                        class="row g-3">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="col-md-6">
                                                            <label class="form-label fw-semibold">Node</label>
                                                            <select name="node_id" class="form-select" required>
                                                                @foreach ($nodes as $node)
                                                                    <option value="{{ $node->id }}"
                                                                        @selected($assignment->node_id == $node->id)>
                                                                        {{ $node->name }} ({{ $node->level->name ?? 'Level' }})
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label fw-semibold">Employee</label>
                                                            <input type="text" class="form-control user-search mb-2"
                                                                placeholder="Search employee name or email">
                                                            <select name="user_id" class="form-select" required>
                                                                @foreach ($users as $user)
                                                                    <option value="{{ $user->id }}"
                                                                        @selected($assignment->user_id == $user->id)>
                                                                        {{ $user->name }} - {{ $user->email }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label fw-semibold">Role Title</label>
                                                            <input type="text" name="role_title" class="form-control"
                                                                value="{{ $assignment->role_title }}">
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label class="form-label fw-semibold">Effective Start</label>
                                                            <input type="date" name="effective_start"
                                                                class="form-control"
                                                                value="{{ optional($assignment->effective_start)->format('Y-m-d') }}">
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label class="form-label fw-semibold">Effective End</label>
                                                            <input type="date" name="effective_end"
                                                                class="form-control"
                                                                value="{{ optional($assignment->effective_end)->format('Y-m-d') }}">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-check mt-4">
                                                                <input class="form-check-input" type="checkbox"
                                                                    value="1" name="is_primary"
                                                                    id="editAssignmentPrimary{{ $assignment->id }}"
                                                                    @checked($assignment->is_primary)>
                                                                <label class="form-check-label fw-semibold"
                                                                    for="editAssignmentPrimary{{ $assignment->id }}">
                                                                    Primary Assignment
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-check mt-4">
                                                                <input class="form-check-input" type="checkbox"
                                                                    value="1" name="notify_user"
                                                                    id="editAssignmentNotify{{ $assignment->id }}">
                                                                <label class="form-check-label fw-semibold"
                                                                    for="editAssignmentNotify{{ $assignment->id }}">
                                                                    Email notification to user
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 d-flex gap-2">
                                                            <button class="btn btn-primary">Save Changes</button>
                                                            <button class="btn btn-light" type="button"
                                                                data-bs-toggle="collapse"
                                                                data-bs-target="#editAssignmentRow{{ $assignment->id }}">
                                                                Cancel
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endcanany
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted py-4">No assignments created yet.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <script>
            document.querySelectorAll('.user-search').forEach(input => {
                const form = input.closest('form');
                const select = form ? form.querySelector('select[name="user_id"]') : null;
                if (!select) return;

                input.addEventListener('input', () => {
                    const term = input.value.toLowerCase();
                    Array.from(select.options).forEach(option => {
                        if (option.value === '') {
                            option.hidden = false;
                            return;
                        }
                        const text = option.text.toLowerCase();
                        option.hidden = term && !text.includes(term);
                    });
                });
            });
        </script>
    </div>
@endsection
