@extends('layouts.app')

@section('content')
    <div class="nxl-container">

        <div class="page-header">
            <h4 class="fw-bold">Edit Program Funding</h4>
            <p class="text-muted">
                Only draft funding records can be modified
            </p>
        </div>

        <div class="card shadow-sm border-0 mt-3">
            <div class="card-body">
                <form method="POST" action="{{ route('finance.program-funding.update', $programFunding) }}">
                    @csrf
                    @method('PUT')

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Approved Amount</label>
                            <input type="number" step="0.01" name="approved_amount"
                                value="{{ $programFunding->approved_amount }}" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Currency</label>
                            <input name="currency" value="{{ $programFunding->currency }}" class="form-control" required>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label>Start Year</label>
                            <input name="start_year" value="{{ $programFunding->start_year }}" class="form-control"
                                required>
                        </div>
                        <div class="col-md-6">
                            <label>End Year</label>
                            <input name="end_year" value="{{ $programFunding->end_year }}" class="form-control" required>
                        </div>
                    </div>

                    <div class="alert alert-warning">
                        Editing is locked once submitted for approval.
                    </div>

                    <button class="btn btn-primary">
                        <i class="feather-save me-1"></i> Update Funding
                    </button>

                    <a href="{{ route('finance.program-funding.show', $programFunding) }}" class="btn btn-light">
                        Cancel
                    </a>
                </form>
            </div>
        </div>
    </div>
@endsection
