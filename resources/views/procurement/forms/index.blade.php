@extends('layouts.app')

@section('content')
    <div class="nxl-container">

        {{-- ================= PAGE HEADER ================= --}}
        <div class="page-header d-flex justify-content-between align-items-center mb-3">
            <div>
                <h4 class="page-title mb-1">Procurement Forms</h4>
                <p class="text-muted mb-0">
                    Manage submission and evaluation forms and link them to procurements
                </p>
            </div>

            @can('forms.manage')
                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#createFormModal">
                    <i class="feather-plus me-1"></i> Create Form
                </button>
            @endcan
        </div>

        {{-- ================= ALERTS ================= --}}
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        {{-- ================= TABLE ================= --}}
        <div class="card shadow-sm">
            <div class="card-body p-0">

                <table class="table table-hover table-bordered align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th width="50">#</th>
                            <th>Form</th>
                            <th>Category</th>
                            <th>Stage</th>
                            <th>Status</th>
                            <th>Attachment</th>
                            <th width="160" class="text-center">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($forms as $index => $form)
                            <tr>
                                <td>{{ $index + 1 }}</td>

                                <td>
                                    <div class="fw-semibold">{{ $form->name }}</div>
                                    <small class="text-muted">
                                        Created by {{ $form->creator->name ?? '—' }}
                                    </small>
                                </td>

                                <td>{{ $form->resource->name ?? '—' }}</td>

                                <td>
                                    <span class="badge bg-info">
                                        {{ ucfirst($form->applies_to) }}
                                    </span>
                                </td>

                                <td>
                                    @if ($form->is_active)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-secondary">Inactive</span>
                                    @endif
                                </td>

                                {{-- ATTACHMENT STATUS --}}
                                <td>
                                    @if ($form->procurement)
                                        <span class="badge bg-success mb-1">
                                            <i class="feather-check-circle me-1"></i>
                                            Attached
                                        </span>
                                        <div class="small text-muted">
                                            {{ $form->procurement->title }}
                                        </div>
                                    @else
                                        <span class="badge bg-warning text-dark">
                                            <i class="feather-alert-circle me-1"></i>
                                            Not Attached
                                        </span>
                                    @endif
                                </td>

                                {{-- ACTIONS --}}
                                <td class="text-center">

                                    {{-- EDIT --}}
                                    <a href="{{ route('forms.edit', $form->id) }}" class="btn btn-sm btn-outline-primary"
                                        title="Edit Form">
                                        <i class="feather-edit"></i>
                                    </a>

                                    {{-- ATTACH / CHANGE (ALWAYS MODAL) --}}
                                    @if ($form->isApproved())
                                        <button type="button" class="btn btn-sm btn-outline-success ms-1 attachFormBtn"
                                            data-form-id="{{ $form->id }}" data-form-name="{{ $form->name }}"
                                            data-current-procurement="{{ $form->procurement_id }}" data-bs-toggle="modal"
                                            data-bs-target="#attachFormModal"
                                            title="{{ $form->procurement ? 'Change Procurement' : 'Attach to Procurement' }}">
                                            <i class="feather-link"></i>
                                        </button>
                                    @endif

                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">
                                    No procurement forms available.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

            </div>
        </div>
    </div>

    {{-- =====================================================
| CREATE FORM MODAL
===================================================== --}}
    <div class="modal fade" id="createFormModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">

                <form method="POST" action="{{ route('forms.store') }}">
                    @csrf

                    <div class="modal-header">
                        <h5 class="modal-title fw-bold">Create Procurement Form</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <div class="row">

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Category</label>
                                <select name="resource_id" class="form-control" required>
                                    <option value="">-- Select Category --</option>
                                    @foreach ($resources as $resource)
                                        <option value="{{ $resource->id }}">
                                            {{ $resource->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Stage</label>
                                <select name="applies_to" class="form-control" required>
                                    <option value="">-- Select Stage --</option>
                                    <option value="submission">Bid Submission</option>
                                    <option value="prescreening">Prescreening</option>
                                    <option value="technical">Technical Evaluation</option>
                                    <option value="financial">Financial Evaluation</option>
                                </select>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label fw-semibold">Form Name</label>
                                <input type="text" name="name" class="form-control"
                                    placeholder="e.g. Technical Evaluation Form" required>
                            </div>

                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            Cancel
                        </button>

                        <button type="submit" class="btn btn-primary">
                            <i class="feather-save me-1"></i> Create Form
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>

    {{-- =====================================================
| ATTACH / CHANGE PROCUREMENT MODAL
===================================================== --}}
    <div class="modal fade" id="attachFormModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">

                <form method="POST" action="{{ route('attach-form') }}">
                    @csrf
                    <input type="hidden" name="form_id" id="attachFormId">

                    <div class="modal-header">
                        <h5 class="modal-title fw-bold" id="attachModalTitle">
                            Attach Form to Procurement
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">

                        <div class="alert alert-info">
                            Form:
                            <strong id="attachFormName"></strong>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                Select Procurement
                            </label>
                            <select name="procurement_id" id="procurementSelect" class="form-control" required>
                                <option value="">-- Select Procurement --</option>
                                @foreach ($procurements as $procurement)
                                    <option value="{{ $procurement->id }}">
                                        {{ $procurement->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="small text-muted">
                            You can change the linked procurement at any time before publishing.
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            Cancel
                        </button>

                        <button type="submit" class="btn btn-success">
                            <i class="feather-save me-1"></i>
                            Save Attachment
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>

    {{-- ================= SCRIPTS ================= --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            document.querySelectorAll('.attachFormBtn').forEach(btn => {
                btn.addEventListener('click', function() {

                    const formId = this.dataset.formId;
                    const formName = this.dataset.formName;
                    const currentProcurement = this.dataset.currentProcurement;

                    document.getElementById('attachFormId').value = formId;
                    document.getElementById('attachFormName').innerText = formName;

                    const select = document.getElementById('procurementSelect');
                    select.value = currentProcurement ?? '';

                    document.getElementById('attachModalTitle').innerText =
                        currentProcurement ?
                        'Change Procurement for Form' :
                        'Attach Form to Procurement';
                });
            });

        });
    </script>
@endsection
