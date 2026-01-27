@extends('layouts.app')

@section('content')
    <div class="nxl-container">

        {{-- ================= PAGE HEADER ================= --}}
        <div class="page-header d-flex justify-content-between align-items-center mb-3">
            <div>
                <h4 class="page-title mb-1">Create Procurement</h4>
                <p class="text-muted mb-0">
                    Register a new procurement with fiscal year, description, and reference number
                </p>
            </div>

            <a href="{{ route('procurements.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="feather-arrow-left me-1"></i> Back
            </a>
        </div>

        {{-- ================= FORM CARD ================= --}}
        <div class="card shadow-sm">
            <div class="card-body">

                {{-- ================= ERRORS ================= --}}
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <h6 class="fw-semibold mb-2">Please fix the following errors:</h6>
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- ================= FORM ================= --}}
                <form method="POST" action="{{ route('procurements.store') }}" id="procurementForm">
                    @csrf

                    <div class="row g-3">

                        {{-- CATEGORY --}}
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                Procurement Category <span class="text-danger">*</span>
                            </label>
                            <select name="resource_id" class="form-control" required>
                                <option value="">-- Select Category --</option>
                                @foreach ($resources as $r)
                                    <option value="{{ $r->id }}"
                                        {{ old('resource_id') == $r->id ? 'selected' : '' }}>
                                        {{ $r->name }}
                                    </option>
                                @endforeach
                            </select>
                            <small class="text-muted">
                                Determines the type of procurement.
                            </small>
                        </div>

                        {{-- FISCAL YEAR --}}
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                Fiscal Year <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="fiscal_year" value="{{ old('fiscal_year') }}" class="form-control"
                                placeholder="e.g. 2025 / 2026" required>
                            <small class="text-muted">
                                Financial year for this procurement.
                            </small>
                        </div>

                        {{-- REFERENCE NUMBER --}}
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                Reference Number
                            </label>

                            <div class="input-group">
                                <input type="text" name="reference_no" id="reference_no"
                                    value="{{ old('reference_no') }}" class="form-control"
                                    placeholder="Enter or generate reference">

                                <button type="button" class="btn btn-outline-primary" id="generateRefBtn">
                                    <i class="feather-refresh-cw me-1"></i>
                                    Generate
                                </button>
                            </div>

                            <small class="text-muted">
                                You may type your own reference or generate one automatically.
                            </small>
                        </div>

                        {{-- ESTIMATED BUDGET --}}
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                Estimated Budget
                            </label>
                            <input type="number" step="0.01" name="estimated_budget"
                                value="{{ old('estimated_budget') }}" class="form-control" placeholder="0.00">
                            <small class="text-muted">
                                Optional initial estimate.
                            </small>
                        </div>

                        {{-- TITLE --}}
                        <div class="col-md-12">
                            <label class="form-label fw-semibold">
                                Procurement Title <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="title" value="{{ old('title') }}" class="form-control"
                                placeholder="e.g. Supply of ICT Equipment" required>
                            <small class="text-muted">
                                This will be visible to evaluators and bidders.
                            </small>
                        </div>

                        {{-- DESCRIPTION (CKEDITOR) --}}
                        <div class="col-md-12">
                            <label class="form-label fw-semibold">
                                Procurement Description <span class="text-danger">*</span>
                            </label>

                            {{-- IMPORTANT: NO required attribute --}}
                            <textarea name="description" id="procurement_description" rows="6" class="form-control">{{ old('description') }}</textarea>

                            <small class="text-muted">
                                Provide detailed scope, requirements, timelines, and expectations.
                            </small>
                        </div>

                    </div>

                    {{-- ================= ACTIONS ================= --}}
                    <div class="d-flex justify-content-end mt-4">
                        <button class="btn btn-success" id="saveBtn">
                            <i class="feather-save me-1"></i>
                            Save Procurement
                        </button>
                    </div>

                </form>

            </div>
        </div>

    </div>

    {{-- ================= CKEDITOR ================= --}}
    <script src="https://cdn.ckeditor.com/ckeditor5/40.2.0/classic/ckeditor.js"></script>

    <script>
        let procurementEditor;

        ClassicEditor
            .create(document.querySelector('#procurement_description'), {
                toolbar: [
                    'heading', '|',
                    'bold', 'italic', 'underline', 'link',
                    'bulletedList', 'numberedList',
                    'blockQuote', '|',
                    'insertTable', 'undo', 'redo'
                ]
            })
            .then(editor => {
                procurementEditor = editor;
            })
            .catch(error => {
                console.error(error);
            });

        // 🔑 Ensure editor content is submitted
        document.getElementById('procurementForm')
            .addEventListener('submit', function() {

                if (procurementEditor) {
                    document.getElementById('procurement_description').value =
                        procurementEditor.getData();
                }
            });

        // AUTO-GENERATE REFERENCE
        document.getElementById('generateRefBtn')
            .addEventListener('click', function() {
                const year = new Date().getFullYear();
                const random = Math.random().toString(36).substring(2, 7).toUpperCase();
                document.getElementById('reference_no').value = `PR-${year}-${random}`;
            });
    </script>
@endsection
