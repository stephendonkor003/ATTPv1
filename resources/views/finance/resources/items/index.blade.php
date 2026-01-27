@extends('layouts.app')

@section('content')
    <div class="nxl-container">

        {{-- ================= PAGE HEADER ================= --}}
        <div class="page-header d-flex justify-content-between align-items-center">
            <div>
                <h4 class="fw-bold mb-1">
                    <i class="feather-box text-primary me-1"></i>
                    Resources
                </h4>
                <p class="text-muted mb-0">
                    Resource items committed against approved budgets
                </p>
            </div>

            <div class="d-flex align-items-center gap-2">
                <input type="text" id="resourceSearch" class="form-control form-control-sm"
                    placeholder="Search resource or category..." style="width:260px">
                @can('finance.resources.create')
                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addResourceModal">
                        <i class="feather-plus me-1"></i>
                        Add Resource
                    </button>
                @endcan
            </div>
        </div>

        {{-- ================= TABLE CARD ================= --}}
        <div class="card mt-4 shadow-sm border-0">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" id="resourcesTable">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Resource Name</th>
                                <th>Category</th>
                                <th class="text-center">Type</th>
                                <th class="text-center" style="width:140px;">Status</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($resources as $resource)
                                <tr>
                                    <td class="ps-4 fw-medium">
                                        <i class="feather-package text-muted me-1"></i>
                                        {{ $resource->name }}
                                    </td>

                                    <td>
                                        <span class="badge bg-info-subtle text-info">
                                            {{ $resource->category->name }}
                                        </span>
                                    </td>

                                    {{-- RESOURCE TYPE INDICATOR --}}
                                    <td class="text-center">
                                        @if ($resource->is_human_resource ?? false)
                                            <span class="badge bg-warning-subtle text-warning">
                                                <i class="feather-users me-1"></i>
                                                Human Resource
                                            </span>
                                        @else
                                            <span class="badge bg-secondary-subtle text-secondary">
                                                <i class="feather-box me-1"></i>
                                                Non-Human
                                            </span>
                                        @endif
                                    </td>

                                    <td class="text-center">
                                        <span class="badge bg-success-subtle text-success px-3">
                                            Active
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-5 text-muted">
                                        <i class="feather-inbox fs-3 d-block mb-2"></i>
                                        No resources added yet
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    {{-- ================= ADD RESOURCE MODAL ================= --}}
    <div class="modal fade" id="addResourceModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form method="POST" action="{{ route('finance.resources.items.store') }}" class="w-100">
                @csrf

                <div class="modal-content border-0 shadow">
                    <div class="modal-header">
                        <h5 class="fw-bold mb-0">
                            <i class="feather-box text-primary me-1"></i>
                            Add Resource
                        </h5>

                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">

                        {{-- CATEGORY --}}
                        <div class="mb-3">
                            <label class="form-label fw-medium">
                                Resource Category <span class="text-danger">*</span>
                            </label>

                            <select name="resource_category_id" class="form-select" id="resourceCategory" required>
                                <option value="">Select Category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- RESOURCE NAME --}}
                        <div class="mb-3">
                            <label class="form-label fw-medium">
                                Resource Name <span class="text-danger">*</span>
                            </label>

                            <input type="text" name="name" class="form-control"
                                placeholder="e.g. Vehicles, Consultants, Engineers" required>
                        </div>

                        {{-- HUMAN RESOURCE INDICATOR --}}
                        <div class="mb-2">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="is_human_resource"
                                    id="isHumanResource" value="1">
                                <label class="form-check-label fw-medium" for="isHumanResource">
                                    This resource involves human employment / staffing
                                </label>
                            </div>

                            <small class="text-muted">
                                Enable this for jobs, consultants, temporary staff, or any employment-related resource.
                                This will allow public competitive bidding and vacancy features.
                            </small>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                            Cancel
                        </button>

                        <button type="submit" class="btn btn-primary">
                            <i class="feather-save me-1"></i>
                            Save
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- ================= SCRIPTS ================= --}}
    <script>
        // Search filter
        document.getElementById('resourceSearch').addEventListener('keyup', function() {
            const value = this.value.toLowerCase();
            document.querySelectorAll('#resourcesTable tbody tr').forEach(row => {
                row.style.display = row.textContent.toLowerCase().includes(value) ?
                    '' :
                    'none';
            });
        });

        // Optional smart HR auto-detection by category name
        document.getElementById('resourceCategory').addEventListener('change', function() {
            const text = this.options[this.selectedIndex].text.toLowerCase();
            const keywords = ['human', 'staff', 'consult', 'personnel', 'employment'];
            document.getElementById('isHumanResource').checked =
                keywords.some(word => text.includes(word));
        });
    </script>
@endsection
