@extends('layouts.app')

@section('content')
    <div class="nxl-container">

        <div class="page-header d-flex justify-content-between align-items-center">
            <div>
                <h4 class="fw-bold mb-1">Edit Funder</h4>
                <p class="text-muted mb-0">
                    Update funder information
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
                <form method="POST" action="{{ route('finance.funders.update', $funder) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Funder Name *</label>
                        <input name="name" class="form-control" value="{{ old('name', $funder->name) }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Funder Type *</label>
                        <select name="type" class="form-select" required>
                            @foreach (['government', 'donor', 'internal', 'private'] as $type)
                                <option value="{{ $type }}" {{ $funder->type === $type ? 'selected' : '' }}>
                                    {{ ucfirst($type) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Currency *</label>
                        <input name="currency" class="form-control" value="{{ old('currency', $funder->currency) }}"
                            required>
                    </div>

                    <div class="alert alert-warning">
                        Changing funder details affects all linked funding records.
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('finance.funders.index') }}" class="btn btn-light">
                            Cancel
                        </a>
                        <button class="btn btn-primary">
                            <i class="feather-save me-1"></i> Update Funder
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
