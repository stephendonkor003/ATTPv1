@extends('layouts.app')

@section('content')
    <div class="nxl-container">

        {{-- ================= PAGE HEADER ================= --}}
        <div class="page-header d-flex justify-content-between align-items-center">
            <div>
                <h4 class="fw-bold mb-1">
                    <i class="feather-folder text-primary me-1"></i>
                    Resource Categories
                </h4>
                <p class="text-muted mb-0">
                    Organize and manage resource classifications
                </p>
            </div>

            <div class="d-flex align-items-center gap-2">
                <input type="text" id="categorySearch" class="form-control form-control-sm" placeholder="Search category..."
                    style="width:220px">
                @can('finance.resources.create')
                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                        <i class="feather-plus me-1"></i>
                        Add Category
                    </button>
                @endcan
            </div>
        </div>

        {{-- ================= TABLE CARD ================= --}}
        <div class="card mt-4 shadow-sm border-0">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" id="categoriesTable">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Category Name</th>
                                <th class="text-center" style="width:140px;">Status</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($categories as $category)
                                <tr>
                                    <td class="ps-4 fw-medium">
                                        <i class="feather-tag text-muted me-1"></i>
                                        {{ $category->name }}
                                    </td>

                                    <td class="text-center">
                                        <span class="badge bg-success-subtle text-success px-3">
                                            Active
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="text-center py-5 text-muted">
                                        <i class="feather-inbox fs-3 d-block mb-2"></i>
                                        No resource categories created yet
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    {{-- ================= ADD CATEGORY MODAL ================= --}}
    <div class="modal fade" id="addCategoryModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form method="POST" action="{{ route('finance.resources.categories.store') }}" class="w-100">
                @csrf

                <div class="modal-content border-0 shadow">
                    <div class="modal-header">
                        <h5 class="fw-bold mb-0">
                            <i class="feather-folder-plus text-primary me-1"></i>
                            Add Resource Category
                        </h5>

                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <label class="form-label fw-medium">
                            Category Name <span class="text-danger">*</span>
                        </label>

                        <input type="text" name="name" class="form-control" placeholder="e.g. Equipment, Services"
                            required>
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

    {{-- ================= SEARCH SCRIPT ================= --}}
    <script>
        document.getElementById('categorySearch').addEventListener('keyup', function() {
            const value = this.value.toLowerCase();

            document.querySelectorAll('#categoriesTable tbody tr').forEach(row => {
                row.style.display = row.textContent.toLowerCase().includes(value) ?
                    '' :
                    'none';
            });
        });
    </script>
@endsection
