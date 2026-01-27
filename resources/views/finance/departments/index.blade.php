@extends('layouts.app')

@section('content')
    <div class="nxl-container">

        {{-- ================= PAGE HEADER ================= --}}
        <div class="page-header d-flex justify-content-between align-items-center">
            <div>
                <h4 class="fw-bold mb-1">Departments</h4>
                <p class="text-muted mb-0">
                    Institutional units responsible for programs, funding, and execution
                </p>
            </div>
            @can('finance.departments.create')
                <a href="{{ route('finance.departments.create') }}" class="btn btn-primary">
                    <i class="feather-plus-circle me-1"></i> New Department
                </a>
            @endcan
        </div>

        {{-- ================= SEARCH ================= --}}
        <div class="card shadow-sm border-0 mt-3">
            <div class="card-body">

                <div class="row mb-3 align-items-center">
                    <div class="col-md-6">
                        <input type="text" id="departmentSearch" class="form-control"
                            placeholder="Search departments, codes, heads, status…">
                    </div>

                    <div class="col-md-6 text-end">
                        <span class="text-muted small">
                            Total Departments:
                            {{-- <strong>{{ $departments->total() }}</strong> --}}
                        </span>
                    </div>
                </div>

                {{-- ================= TABLE ================= --}}
                <div class="table-responsive">
                    <table class="table table-bordered align-middle" id="departmentsTable">
                        <thead class="table-light">
                            <tr>
                                <th width="100">Code</th>
                                <th>Department</th>
                                <th width="220">Department Head</th>
                                <th width="120">Status</th>
                                <th width="140" class="text-center">Programs</th>
                                <th width="160" class="text-center">Funded</th>
                                <th width="180" class="text-center">Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($departments as $department)
                                <tr>

                                    {{-- CODE --}}
                                    <td class="fw-semibold">
                                        {{ $department->code }}
                                    </td>

                                    {{-- DEPARTMENT --}}
                                    <td>
                                        <div class="fw-semibold">
                                            {{ $department->name }}
                                        </div>
                                        <div class="text-muted small">
                                            {{ \Illuminate\Support\Str::limit($department->description, 70) }}
                                        </div>
                                    </td>

                                    {{-- HEAD --}}
                                    <td>
                                        @if ($department->head)
                                            <div class="fw-semibold">
                                                {{ $department->head->name }}
                                            </div>
                                            <div class="text-muted small">
                                                {{ $department->head->email }}
                                            </div>
                                        @else
                                            <span class="text-danger small fw-semibold">
                                                Not Assigned
                                            </span>
                                        @endif
                                    </td>

                                    {{-- STATUS --}}
                                    <td>
                                        <span
                                            class="badge {{ $department->status === 'active' ? 'bg-success' : 'bg-secondary' }}">
                                            {{ ucfirst($department->status) }}
                                        </span>
                                    </td>

                                    {{-- PROGRAMS --}}
                                    <td class="text-center">
                                        <span class="badge bg-light text-dark">
                                            {{ $department->programs_count }}
                                        </span>
                                    </td>

                                    {{-- FUNDED --}}
                                    <td class="text-center">
                                        <span class="badge bg-primary">
                                            {{ $department->program_fundings_count }}
                                        </span>
                                    </td>

                                    {{-- ACTIONS (INLINE & CLEAN) --}}
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-2">
                                            @can('finance.departments.assign_head')
                                                <button class="btn btn-sm btn-outline-primary" title="Assign Department Head"
                                                    data-bs-toggle="modal" data-bs-target="#assignHeadModal"
                                                    data-id="{{ $department->id }}" data-name="{{ $department->name }}"
                                                    data-head="{{ $department->head_user_id ?? '' }}">
                                                    <i class="feather-user-check"></i>
                                                </button>
                                            @endcan

                                            <a href="{{ route('finance.departments.show', $department) }}"
                                                class="btn btn-sm btn-outline-info" title="View">
                                                <i class="feather-eye"></i>
                                            </a>
                                            @can('finance.departments.edit')
                                                <a href="{{ route('finance.departments.edit', $department) }}"
                                                    class="btn btn-sm btn-outline-warning" title="Edit">
                                                    <i class="feather-edit"></i>
                                                </a>
                                            @endcan

                                        </div>
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">
                                        No departments found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- ================= PAGINATION ================= --}}
                <div class="d-flex justify-content-end mt-3">
                    {{ $departments->links() }}
                </div>

            </div>
        </div>
    </div>

    {{-- ================= ASSIGN HEAD MODAL ================= --}}
    <div class="modal fade" id="assignHeadModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Assign Department Head</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form id="assignHeadForm">
                    @csrf

                    <div class="modal-body">

                        <input type="hidden" id="departmentId">

                        <div class="mb-3">
                            <label class="fw-semibold">Department</label>
                            <input type="text" id="departmentName" class="form-control" disabled>
                        </div>

                        <div class="mb-3">
                            <label class="fw-semibold">Select Employee</label>
                            <select class="form-select" name="head_user_id" required>
                                <option value="">-- Select Employee --</option>
                                @foreach (\App\Models\User::where('user_type', 'employee')->orderBy('name')->get() as $user)
                                    <option value="{{ $user->id }}">
                                        {{ $user->name }} ({{ $user->email }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <button class="btn btn-primary">Assign Head</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    {{-- ================= JS ================= --}}
    <script>
        /* SEARCH */
        document.getElementById('departmentSearch').addEventListener('keyup', function() {
            const filter = this.value.toLowerCase();
            document.querySelectorAll('#departmentsTable tbody tr').forEach(row => {
                row.style.display = row.innerText.toLowerCase().includes(filter) ? '' : 'none';
            });
        });

        /* MODAL BINDING */
        const modal = document.getElementById('assignHeadModal');
        const form = document.getElementById('assignHeadForm');

        modal.addEventListener('show.bs.modal', e => {
            const btn = e.relatedTarget;
            document.getElementById('departmentId').value = btn.dataset.id;
            document.getElementById('departmentName').value = btn.dataset.name;
            if (btn.dataset.head) form.head_user_id.value = btn.dataset.head;
        });

        /* SUBMIT */
        form.addEventListener('submit', e => {
            e.preventDefault();
            const id = document.getElementById('departmentId').value;

            fetch(`/finance/departments/${id}/assign-head`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: new FormData(form)
            }).then(() => location.reload());
        });
    </script>
@endsection
