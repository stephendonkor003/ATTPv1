@extends('layouts.app')

@section('content')
    <div class="nxl-container">

        <div class="page-header d-flex justify-content-between align-items-center">
            <h4 class="fw-bold text-dark">Sectors</h4>
            @can('sector.create')
                <a href="{{ route('budget.sectors.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-1"></i> New Sector
                </a>
            @endcan
        </div>

        <div class="card mt-3 shadow-sm">
            <div class="card-body">
                <table class="table table-bordered table-striped align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Governance</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sectors as $sector)
                            <tr>
                                <td>{{ $sector->id }}</td>
                                <td>{{ $sector->name }}</td>
                                <td>{{ $sector->description }}</td>
                                <td>
                                    <div class="fw-semibold">
                                        {{ $sector->governanceNode->name ?? '-' }}
                                    </div>
                                    <small class="text-muted">
                                        {{ $sector->governanceNode->level->name ?? '' }}
                                    </small>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection
