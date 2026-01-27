@extends('layouts.app')

@section('content')
    <div class="nxl-container">

        {{-- ===================== PAGE HEADER ===================== --}}
        <div class="page-header d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
            <div>
                <h4 class="fw-bold mb-1">Funding Partner</h4>
                <p class="text-muted mb-0">
                    Organizations providing funding support for programs and projects
                </p>
            </div>
            @can('finance.funders.create')
                <a href="{{ route('finance.funders.create') }}" class="btn btn-primary">
                    <i class="feather-plus-circle me-1"></i>
                    Add New Funding Partner
                </a>
            @endcan
        </div>

        {{-- ===================== FLASH MESSAGES ===================== --}}
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

        {{-- ===================== SEARCH BAR ===================== --}}
        <div class="card shadow-sm mt-4">
            <div class="card-body py-3">
                <div class="row g-2">
                    <div class="col-md-6 col-lg-4">
                        <div class="input-group">
                            <span class="input-group-text bg-light">
                                <i class="feather-search"></i>
                            </span>
                            <input type="text" id="funderSearch" class="form-control"
                                placeholder="Search funder name, type, status…">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ===================== FUNDERS TABLE ===================== --}}
        <div class="card shadow-sm mt-3">
            <div class="card-body table-responsive">

                <table class="table table-hover align-middle" id="fundersTable">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Funder Name</th>
                            <th>Type</th>
                            <th>Created On</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($funders as $funder)
                            <tr>
                                <td>{{ $loop->iteration }}</td>

                                <td class="searchable">
                                    <div class="fw-semibold">
                                        {{ $funder->name }}
                                    </div>
                                </td>

                                <td class="searchable">
                                    {{ $funder->type ?? '—' }}
                                </td>



                                <td>
                                    {{ optional($funder->created_at)->format('d M Y') }}
                                </td>

                                <td class="text-end">
                                    @can('finance.funders.edit')
                                        <a href="{{ route('finance.funders.edit', $funder->id) }}"
                                            class="btn btn-sm btn-outline-warning">
                                            Edit
                                        </a>
                                    @endcan
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">
                                    No funders found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                {{-- Pagination --}}
                <div class="mt-3">
                    {{ $funders->links() }}
                </div>

            </div>
        </div>

    </div>

    {{-- ===================== SEARCH SCRIPT ===================== --}}
    <script>
        document.getElementById('funderSearch').addEventListener('keyup', function() {
            const term = this.value.toLowerCase();
            const rows = document.querySelectorAll('#fundersTable tbody tr');

            rows.forEach(row => {
                const text = row.innerText.toLowerCase();
                row.style.display = text.includes(term) ? '' : 'none';
            });
        });
    </script>
@endsection
