@extends('layouts.app')

@section('content')
    <div class="nxl-container">

        {{-- ===================== PAGE HEADER ===================== --}}
        <div class="page-header">
            <h4 class="fw-bold">Create Budget Commitment</h4>
            <p class="text-muted mb-0">
                Commit approved allocations to specific resources
            </p>
        </div>

        {{-- ===================== GLOBAL ERROR SUMMARY ===================== --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <h6 class="fw-bold mb-2">
                    <i class="feather-alert-triangle me-1"></i>
                    Please fix the following errors:
                </h6>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('finance.commitments.store') }}" id="commitmentForm">
            @csrf

            {{-- ===================== PROGRAM FUNDING ===================== --}}
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h6 class="fw-bold mb-3">Program Funding</h6>

                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label">Approved Program Funding</label>
                            <select name="program_funding_id"
                                class="form-select @error('program_funding_id') is-invalid @enderror" required>
                                <option value="">Select Program Funding</option>
                                @foreach ($fundings as $funding)
                                    <option value="{{ $funding->id }}"
                                        {{ old('program_funding_id') == $funding->id ? 'selected' : '' }}>
                                        {{ $funding->program->name ?? 'Program' }}
                                    </option>
                                @endforeach
                            </select>
                            @error('program_funding_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            {{-- ===================== COMMITMENT REFERENCE ===================== --}}
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h6 class="fw-bold text-secondary mb-3">
                        Commitment Reference
                    </h6>

                    <div class="row">
                        <div class="col-md-4">
                            <label class="form-label">Commitment Ref</label>
                            <input type="text" id="commitment_ref" class="form-control" readonly>
                            <small class="text-muted">
                                System generated (for tracking)
                            </small>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ===================== ALLOCATION CONTEXT ===================== --}}
            <div class="card shadow-sm mb-4">
                <div class="card-body">

                    <h6 class="fw-bold text-primary mb-3">
                        Allocation Context
                    </h6>

                    <div class="row g-3">

                        {{-- Allocation Level --}}
                        <div class="col-md-4">
                            <label class="form-label">Allocation Level</label>
                            <select class="form-select @error('allocation_level') is-invalid @enderror"
                                id="allocation_level" name="allocation_level" required>
                                <option value="">Select Level</option>
                                <option value="project" {{ old('allocation_level') == 'project' ? 'selected' : '' }}>Project
                                </option>
                                <option value="activity" {{ old('allocation_level') == 'activity' ? 'selected' : '' }}>
                                    Activity</option>
                                <option value="sub_activity"
                                    {{ old('allocation_level') == 'sub_activity' ? 'selected' : '' }}>Sub-Activity</option>
                            </select>
                            @error('allocation_level')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Project --}}
                        <div class="col-md-4 d-none" id="projectWrap">
                            <label class="form-label">Project</label>
                            <select class="form-select" id="project_id"></select>
                        </div>

                        {{-- Activity --}}
                        <div class="col-md-4 d-none" id="activityWrap">
                            <label class="form-label">Activity</label>
                            <select class="form-select" id="activity_id"></select>
                        </div>

                        {{-- Sub-Activity --}}
                        <div class="col-md-4 d-none" id="subActivityWrap">
                            <label class="form-label">Sub-Activity</label>
                            <select class="form-select" id="sub_activity_id"></select>
                        </div>

                        {{-- Year --}}
                        <div class="col-md-4 d-none" id="yearWrap">
                            <label class="form-label">Allocation Year</label>
                            <select class="form-select @error('commitment_year') is-invalid @enderror" id="commitment_year"
                                name="commitment_year"></select>
                            @error('commitment_year')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <input type="hidden" name="allocation_id" id="allocation_id" value="{{ old('allocation_id') }}">
                    </div>

                    {{-- ===================== ALLOCATION PREVIEW ===================== --}}
                    <div class="row g-3 mt-4 d-none" id="allocationPreview">

                        <div class="col-md-4">
                            <div class="alert alert-light border">
                                <strong>Allocated</strong><br>
                                <span id="allocatedAmount">—</span>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="alert alert-warning border">
                                <strong>Remaining</strong><br>
                                <span id="remainingAmount">—</span>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="alert alert-info mb-0">
                                You are committing resources to:
                                <strong id="confirmText"></strong>
                            </div>
                        </div>

                    </div>

                </div>
            </div>

            {{-- ===================== RESOURCE & AMOUNT ===================== --}}
            <div class="card shadow-sm mb-4 d-none" id="resourceSection">
                <div class="card-body">

                    <h6 class="fw-bold text-success mb-3">
                        Resource Commitment
                    </h6>

                    <div class="row g-3">

                        <div class="col-md-4">
                            <label class="form-label">Resource Category</label>
                            <select class="form-select @error('resource_category_id') is-invalid @enderror"
                                id="resource_category_id" name="resource_category_id" required>
                                <option value="">Select Category</option>
                                @foreach ($resourceCategories as $cat)
                                    <option value="{{ $cat->id }}"
                                        {{ old('resource_category_id') == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('resource_category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Resource Item</label>
                            <select class="form-select @error('resource_id') is-invalid @enderror" id="resource_id"
                                name="resource_id" required>
                                <option value="">Select Resource</option>
                            </select>
                            @error('resource_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Commitment Amount</label>
                            <input type="number" step="0.01"
                                class="form-control @error('commitment_amount') is-invalid @enderror"
                                name="commitment_amount" value="{{ old('commitment_amount') }}" required>
                            @error('commitment_amount')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>

                </div>
            </div>

            {{-- ===================== ACTION ===================== --}}
            <div class="text-end">
                <button class="btn btn-primary px-4">
                    <i class="feather-save me-1"></i>
                    Save Commitment
                </button>
            </div>

        </form>
    </div>

    {{-- ===================== SCRIPT ===================== --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {

            document.getElementById('commitment_ref').value =
                'COM-' + Date.now().toString().slice(-6);

            const levelSelect = document.getElementById('allocation_level');

            levelSelect.addEventListener('change', () => {
                resetUI();
                if (levelSelect.value) {
                    show('projectWrap');
                    loadProjects();
                }
            });

            document.getElementById('project_id').addEventListener('change', e => {
                document.getElementById('allocation_id').value = e.target.value;
                levelSelect.value === 'project' ?
                    loadYears('project', e.target.value) :
                    (show('activityWrap'), loadActivities(e.target.value));
            });

            document.getElementById('activity_id').addEventListener('change', e => {
                document.getElementById('allocation_id').value = e.target.value;
                levelSelect.value === 'activity' ?
                    loadYears('activity', e.target.value) :
                    (show('subActivityWrap'), loadSubActivities(e.target.value));
            });

            document.getElementById('sub_activity_id').addEventListener('change', e => {
                document.getElementById('allocation_id').value = e.target.value;
                loadYears('sub_activity', e.target.value);
            });

            document.getElementById('commitment_year').addEventListener('change', fetchRemaining);

            document.getElementById('resource_category_id').addEventListener('change', e => {
                fetch(`/finance/resources/ajax/resources/${e.target.value}`)
                    .then(r => r.json())
                    .then(d => {
                        const sel = document.getElementById('resource_id');
                        sel.innerHTML = '<option value="">Select Resource</option>';
                        d.forEach(i => sel.innerHTML += `<option value="${i.id}">${i.name}</option>`);
                    });
            });

            function fetchRemaining() {
                fetch(
                        `/finance/commitments/ajax/remaining-budget?allocation_level=${levelSelect.value}&allocation_id=${document.getElementById('allocation_id').value}&year=${document.getElementById('commitment_year').value}`)
                    .then(r => r.json())
                    .then(d => {
                        show('allocationPreview');
                        show('resourceSection');
                        document.getElementById('allocatedAmount').innerText = d.allocated.toFixed(2);
                        document.getElementById('remainingAmount').innerText = d.remaining.toFixed(2);
                        document.getElementById('confirmText').innerText =
                            `${levelSelect.value.replace('_',' ')} – ${document.getElementById('commitment_year').value}`;
                    });
            }

            function loadProjects() {
                fetch('/finance/commitments/ajax/projects').then(r => r.json()).then(d => fill('project_id', d));
            }

            function loadActivities(id) {
                fetch(`/finance/commitments/ajax/activities/${id}`).then(r => r.json()).then(d => fill(
                    'activity_id', d));
            }

            function loadSubActivities(id) {
                fetch(`/finance/commitments/ajax/sub-activities/${id}`).then(r => r.json()).then(d => fill(
                    'sub_activity_id', d));
            }

            function loadYears(level, id) {
                show('yearWrap');
                fetch(`/finance/commitments/ajax/allocation-years/${level}/${id}`).then(r => r.json()).then(d =>
                    fill('commitment_year', d, true));
            }

            function fill(id, data, raw = false) {
                const el = document.getElementById(id);
                el.innerHTML = '<option value="">Select</option>';
                data.forEach(i => el.innerHTML += `<option value="${raw ? i : i.id}">${raw ? i : i.name}</option>`);
            }

            function show(id) {
                document.getElementById(id).classList.remove('d-none');
            }

            function resetUI() {
                ['projectWrap', 'activityWrap', 'subActivityWrap', 'yearWrap', 'allocationPreview',
                    'resourceSection'
                ]
                .forEach(id => document.getElementById(id).classList.add('d-none'));
            }
        });
    </script>
@endsection
