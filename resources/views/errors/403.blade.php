@extends('layouts.app')

@section('content')
    <div class="nxl-container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-sm border-0 mt-4">
                    <div class="card-body p-4 p-md-5 text-center">
                        <div class="mb-3">
                            <span class="badge bg-danger-subtle text-danger fw-semibold px-3 py-2">
                                403 Forbidden
                            </span>
                        </div>
                        <h4 class="fw-bold mb-2">Access denied</h4>
                        <p class="text-muted mb-4">
                            Your access role does not support access to this resource.
                            Please contact your administrator if you believe this is a mistake.
                        </p>

                        <div class="d-flex flex-column flex-sm-row justify-content-center gap-2">
                            <a href="{{ url()->previous() }}" class="btn btn-primary" onclick="window.history.back(); return false;">
                                Go Back
                            </a>
                            <a href="{{ url('/') }}" class="btn btn-outline-secondary">
                                Home
                            </a>
                        </div>
                    </div>
                </div>

                <div class="text-center text-muted mt-3">
                    Need help? Reach out to support.
                </div>
            </div>
        </div>
    </div>
@endsection
