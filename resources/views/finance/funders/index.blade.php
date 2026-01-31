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

        {{-- ===================== FUNDERS TABLE ===================== --}}
        <div class="card shadow-sm mt-4">
            <div class="card-body">

                <x-data-table
                    id="fundersTable"
                >
                    <thead class="table-light">
                        <tr>
                            <th width="50">#</th>
                            <th>Funder Name</th>
                            <th>Type</th>
                            <th>Currency</th>
                            <th>Created On</th>
                            <th width="100" class="text-end">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($funders as $funder)
                            <tr>
                                <td>{{ $loop->iteration }}</td>

                                <td>
                                    <div class="fw-semibold text-dark">
                                        {{ $funder->name }}
                                    </div>
                                </td>

                                <td>
                                    <span class="badge bg-{{
                                        $funder->type === 'government' ? 'primary' :
                                        ($funder->type === 'donor' ? 'success' :
                                        ($funder->type === 'private' ? 'warning' : 'info'))
                                    }}">
                                        {{ ucfirst($funder->type ?? 'N/A') }}
                                    </span>
                                </td>

                                <td>
                                    <span class="badge bg-secondary">
                                        {{ strtoupper($funder->currency ?? 'N/A') }}
                                    </span>
                                </td>

                                <td>
                                    {{ optional($funder->created_at)->format('d M Y') }}
                                </td>

                                <td class="text-end">
                                    @can('finance.funders.edit')
                                        <a href="{{ route('finance.funders.edit', $funder->id) }}"
                                            class="btn btn-sm btn-outline-warning"
                                            title="Edit Funder">
                                            <i class="feather-edit"></i>
                                        </a>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </x-data-table>

            </div>
        </div>

    </div>
@endsection
