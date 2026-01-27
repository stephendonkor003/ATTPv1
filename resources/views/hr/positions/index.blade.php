@extends('layouts.app')

@section('content')
    <div class="nxl-container">

        {{-- ================= PAGE HEADER ================= --}}
        <div class="page-header mb-4">
            <div class="d-flex flex-column align-items-start gap-2">

                <div>
                    <h4 class="fw-bold mb-1">
                        <i class="feather-briefcase text-primary me-2"></i>
                        HR Positions
                    </h4>
                    <p class="text-muted mb-0">
                        Define and manage job roles available for recruitment and workforce planning
                    </p>
                </div>
                @can('hrm.positions.create')
                    <button class="btn btn-primary d-inline-flex align-items-center" data-bs-toggle="modal"
                        data-bs-target="#addPositionModal">
                        <i class="feather-plus me-2"></i>
                        New Position
                    </button>
                @endcan

            </div>
        </div>

        {{-- ================= FEEDBACK ================= --}}
        @if (session('success'))
            <div class="alert alert-success d-flex align-items-center mb-4">
                <i class="feather-check-circle me-2"></i>
                {{ session('success') }}
            </div>
        @endif

        {{-- ================= POSITIONS TABLE ================= --}}
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white border-0 pb-0">
                <h6 class="fw-semibold mb-1">Positions List</h6>
                <p class="text-muted small mb-0">
                    Overview of all defined HR positions and their classifications
                </p>
            </div>

            <div class="card-body pt-3">
                <div class="table-responsive">
                    <table class="table table-hover align-middle w-100 hr-table mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Position</th>
                                <th>Resource</th>
                                <th>Employment Type</th>
                                <th>Status</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($positions as $position)
                                <tr>
                                    <td>
                                        <div class="fw-semibold text-dark">
                                            {{ $position->title }}
                                        </div>
                                        <small class="text-muted">
                                            Created {{ $position->created_at->format('d M Y') }}
                                        </small>
                                    </td>

                                    <td>
                                        {{ $position->resource->name ?? '—' }}
                                    </td>

                                    <td>
                                        <span class="badge bg-info-subtle text-info px-3 py-1">
                                            {{ ucfirst($position->employment_type) }}
                                        </span>
                                    </td>

                                    <td>
                                        <span class="badge bg-success-subtle text-success px-3 py-1">
                                            {{ ucfirst($position->status) }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-5 text-muted">
                                        <i class="feather-inbox fs-4 d-block mb-2"></i>
                                        No HR positions have been created yet
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    {{-- ================= ADD POSITION MODAL ================= --}}
    <div class="modal fade" id="addPositionModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <form method="POST" action="{{ route('hr.positions.store') }}" class="w-100">
                @csrf

                <div class="modal-content border-0 shadow">

                    <div class="modal-header">
                        <h5 class="fw-bold mb-0">
                            <i class="feather-briefcase text-primary me-2"></i>
                            Create HR Position
                        </h5>
                        <button class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <div class="row g-4">

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">HR Resource *</label>
                                <select name="resource_id" class="form-select" required>
                                    <option value="">Select Resource</option>
                                    @foreach (\App\Models\Resource::where('is_human_resource', 1)->get() as $resource)
                                        <option value="{{ $resource->id }}">
                                            {{ $resource->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Employment Type *</label>
                                <select name="employment_type" class="form-select" required>
                                    <option value="permanent">Permanent</option>
                                    <option value="contract">Contract</option>
                                    <option value="temporary">Temporary</option>
                                    <option value="consultant">Consultant</option>
                                </select>
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-semibold">Position Title *</label>
                                <input type="text" name="title" class="form-control" required>
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-semibold">Position Description</label>
                                <textarea name="description" id="positionDescription" class="form-control"></textarea>
                            </div>

                        </div>
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-light" data-bs-dismiss="modal">
                            Cancel
                        </button>
                        <button class="btn btn-primary">
                            <i class="feather-save me-2"></i>
                            Save Position
                        </button>
                    </div>

                </div>
            </form>
        </div>
    </div>

    {{-- ================= STYLES ================= --}}
    <style>
        .hr-table th {
            font-weight: 600;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: .04em;
        }

        .hr-table td {
            vertical-align: middle;
        }

        @media (max-width: 768px) {

            .hr-table th:nth-child(2),
            .hr-table td:nth-child(2) {
                display: none;
            }
        }

        .ck-editor__editable {
            min-height: 220px;
            max-height: 320px;
            font-size: 14px;
            line-height: 1.6;
        }

        .ck-content {
            font-family: Inter, system-ui, sans-serif;
        }
    </style>

    <script src="https://cdn.ckeditor.com/ckeditor5/40.2.0/classic/ckeditor.js"></script>

    <script>
        let editorLoaded = false;

        document.getElementById('addPositionModal')
            .addEventListener('shown.bs.modal', function() {
                if (!editorLoaded) {
                    ClassicEditor.create(document.querySelector('#positionDescription'), {
                        toolbar: [
                            'heading', '|',
                            'bold', 'italic', 'underline', '|',
                            'bulletedList', 'numberedList', '|',
                            'link', 'blockQuote', 'insertTable', '|',
                            'undo', 'redo'
                        ]
                    });
                    editorLoaded = true;
                }
            });
    </script>
@endsection
