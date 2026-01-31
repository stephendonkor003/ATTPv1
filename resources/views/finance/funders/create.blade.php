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
                <form method="POST" action="{{ route('finance.funders.store') }}" enctype="multipart/form-data">
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

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Default Currency *</label>
                        <input name="currency" class="form-control" value="{{ old('currency') }}"
                            placeholder="USD, GHS, EUR" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Organization Logo</label>
                        <input type="file" name="logo" class="form-control" accept="image/*">
                        <small class="text-muted">Upload your organization's logo (PNG, JPG, or SVG). Max 2MB. Will be displayed in the partner portal.</small>
                    </div>

                    <hr class="my-4">

                    <!-- Partner Portal Access Section -->
                    <h5 class="fw-semibold mb-3">Partner Portal Access</h5>

                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="has_portal_access"
                               name="has_portal_access" value="1" {{ old('has_portal_access') ? 'checked' : '' }}>
                        <label class="form-check-label" for="has_portal_access">
                            <strong>Grant Portal Access</strong>
                            <div class="text-muted small">Allow this partner to access the funding portal to view programs they fund</div>
                        </label>
                    </div>

                    <div id="portalFields" style="display: {{ old('has_portal_access') ? 'block' : 'none' }};">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Contact Person *</label>
                                <input name="contact_person" class="form-control" value="{{ old('contact_person') }}"
                                       placeholder="e.g. John Doe">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Contact Email *</label>
                                <input type="email" name="contact_email" class="form-control" value="{{ old('contact_email') }}"
                                       placeholder="partner@example.com">
                                <small class="text-muted">This email will be used for portal login</small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Contact Phone</label>
                                <input name="contact_phone" class="form-control" value="{{ old('contact_phone') }}"
                                       placeholder="+233 XXX XXX XXX">
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label fw-semibold">Notes</label>
                                <textarea name="notes" class="form-control" rows="3"
                                          placeholder="Additional information about this partner">{{ old('notes') }}</textarea>
                            </div>
                        </div>

                        <div class="alert alert-info mb-3">
                            <i class="feather-info me-2"></i>
                            <strong>Note:</strong> The partner will receive a welcome email with login credentials to access the portal.
                        </div>
                    </div>

                    <hr class="my-4">

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

@push('scripts')
<script>
document.getElementById('has_portal_access').addEventListener('change', function() {
    document.getElementById('portalFields').style.display = this.checked ? 'block' : 'none';
});
</script>
@endpush
