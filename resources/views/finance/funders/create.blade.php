@extends('layouts.app')

@section('content')
    <div class="nxl-container">

        <div class="page-header d-flex justify-content-between align-items-center">
            <div>
                <h4 class="fw-bold mb-1">Create Funder</h4>
                <p class="text-muted mb-0">
                    Register an organization providing financial resources
                </p>
            </div>

            <a href="{{ route('finance.funders.index') }}" class="btn btn-light">
                <i class="feather-arrow-left me-1"></i> Back
            </a>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card shadow-sm border-0 mt-3">
            <div class="card-body">
                <form method="POST" action="{{ route('finance.funders.store') }}">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Funder Name *</label>
                        <input name="name" class="form-control" value="{{ old('name') }}"
                            placeholder="e.g. World Bank, AU, Government of Ghana" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Funder Type *</label>
                        <select name="type" class="form-select" required>
                            <option value="">-- Select Type --</option>
                            <option value="government">Government</option>
                            <option value="donor">Donor</option>
                            <option value="internal">Internal</option>
                            <option value="private">Private</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Default Currency *</label>
                        <input name="currency" class="form-control" value="{{ old('currency') }}"
                            placeholder="USD, GHS, EUR" required>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('finance.funders.index') }}" class="btn btn-light">
                            Cancel
                        </a>
                        <button class="btn btn-primary">
                            <i class="feather-save me-1"></i> Save Funder
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
