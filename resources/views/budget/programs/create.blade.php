@extends('layouts.app')

@section('title', 'Create Program')

@section('content')
    <main class="nxl-container">
        <div class="nxl-content">

            <!-- HEADER -->
            <div class="page-header d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="mb-1">Create New Program</h4>
                    <p class="text-muted mb-0">Add a program with auto-generated yearly allocations.</p>
                </div>
                <a href="{{ route('budget.programs.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left-circle me-1"></i> Back
                </a>
            </div>

            {{-- GLOBAL ERROR DISPLAY --}}
            @if ($errors->any())
                <div class="alert alert-danger mt-3">
                    <strong>Error:</strong>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $e)
                            <li>{{ $e }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger mt-3">{{ session('error') }}</div>
            @endif


            <!-- FORM -->
            <div class="card shadow-sm border-0">
                <div class="card-body">

                    <form action="{{ route('budget.programs.store') }}" method="POST" id="programForm">
                        @csrf

                        <div class="row g-4">

                            <!-- SECTOR -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Sector <span class="text-danger">*</span></label>
                                <select name="sector_id" class="form-select" required>
                                    <option value="">-- Select Sector --</option>
                                    @foreach ($sectors as $sector)
                                        <option value="{{ $sector->id }}">{{ $sector->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- PROGRAM ID -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Program ID <span class="text-danger">*</span></label>
                                <input type="text" name="program_id" class="form-control" placeholder="PROG001" required>
                            </div>

                            <!-- PROGRAM NAME -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Program Name <span
                                        class="text-danger">*</span></label>
                                <select name="program_name" id="programNameSelect" class="form-select" required>
                                    <option value="">-- Select Approved Program --</option>
                                    @foreach ($approvedPrograms as $programName)
                                        @php
                                            $funding = $approvedProgramFunding[$programName] ?? null;
                                        @endphp
                                        <option value="{{ $programName }}"
                                            data-currency="{{ $funding['currency'] ?? '' }}"
                                            data-start-year="{{ $funding['start_year'] ?? '' }}"
                                            data-end-year="{{ $funding['end_year'] ?? '' }}"
                                            data-total-budget="{{ $funding['total_budget'] ?? '' }}"
                                            @selected(old('program_name') === $programName)>
                                            {{ $programName }}
                                        </option>
                                    @endforeach
                                </select>
                                <small class="text-muted d-block mt-1">
                                    Program names come from approved funding records.
                                </small>
                            </div>

                            <!-- CURRENCY -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Currency <span class="text-danger">*</span></label>
                                <select id="currencySelect" class="form-select" required disabled>
                                    <option value="">-- Select --</option>
                                    <option value="USD">USD</option>
                                    <option value="EUR">EUR</option>
                                    <option value="GHS">GHS</option>
                                    <option value="NGN">NGN</option>
                                    <option value="ZAR">ZAR</option>
                                </select>
                                <input type="hidden" name="currency" id="currencyHidden" value="{{ old('currency') }}">
                            </div>

                            <!-- TOTAL BUDGET -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Total Budget <span
                                        class="text-danger">*</span></label>
                                <input type="number" name="total_budget" id="totalBudget" class="form-control"
                                    step="0.01" min="0" placeholder="0.00" required readonly>
                            </div>

                            <!-- START YEAR -->
                            <div class="col-md-3">
                                <label class="form-label fw-semibold">Start Year <span class="text-danger">*</span></label>
                                <input type="number" name="start_year" id="startYear" class="form-control" min="1900"
                                    max="2100" placeholder="2025" required readonly>
                            </div>

                            <!-- END YEAR -->
                            <div class="col-md-3">
                                <label class="form-label fw-semibold">End Year <span class="text-danger">*</span></label>
                                <input type="number" name="end_year" id="endYear" class="form-control" min="1900"
                                    max="2100" placeholder="2030" required readonly>
                            </div>

                            <!-- CALCULATED TOTAL YEARS -->
                            <input type="hidden" name="total_years" id="totalYears">

                            <!-- MODE -->
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Allocation Mode <span
                                        class="text-danger">*</span></label>
                                <select name="mode" id="allocationMode" class="form-select" required>
                                    <option value="amount" selected>Amount</option>
                                    <option value="percentage">Percentage (%)</option>
                                </select>
                            </div>

                            <!-- DESCRIPTION -->
                            <div class="col-md-12">
                                <label class="form-label fw-semibold">Description</label>
                                <textarea name="description" class="form-control" rows="3" placeholder="Optional details"></textarea>
                            </div>

                            <!-- EXPECTED OUTCOME -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Expected Outcome Type <span class="text-danger">*</span></label>
                                <select name="expected_outcome_type" id="expectedOutcomeType" class="form-select" required>
                                    <option value="">-- Select Type --</option>
                                    <option value="percentage" @selected(old('expected_outcome_type') === 'percentage')>
                                        Percentage
                                    </option>
                                    <option value="text" @selected(old('expected_outcome_type') === 'text')>
                                        Text
                                    </option>
                                </select>
                            </div>

                            <div class="col-md-6" id="expectedOutcomePercentageWrap" style="display:none;">
                                <label class="form-label fw-semibold">Expected Outcome (%) <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number" name="expected_outcome_percentage" id="expectedOutcomePercentage"
                                        class="form-control" min="0" max="100" step="0.01"
                                        value="{{ old('expected_outcome_percentage') }}" placeholder="0 - 100">
                                    <span class="input-group-text">%</span>
                                </div>
                                <small class="text-muted">Example: 0% malaria rate by end of program.</small>
                            </div>

                            <div class="col-md-12" id="expectedOutcomeTextWrap" style="display:none;">
                                <label class="form-label fw-semibold">Expected Outcome (Text) <span class="text-danger">*</span></label>
                                <textarea name="expected_outcome_text" id="expectedOutcomeText" class="form-control" rows="2"
                                    placeholder="Describe the expected outcome">{{ old('expected_outcome_text') }}</textarea>
                                <small class="text-muted">Example: Send 2,000 students to school.</small>
                            </div>

                        </div>

                        <!-- DYNAMIC YEARLY ALLOCATIONS -->
                        <div id="allocationsContainer" class="mt-5" style="display:none;">
                            <h6 class="fw-semibold mb-3">
                                Yearly Allocation (<span id="currencyLabel">--</span>)
                            </h6>

                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Year</th>
                                            <th>Allocation <span id="allocationLabel">(Amount)</span></th>
                                        </tr>
                                    </thead>
                                    <tbody id="allocationTableBody"></tbody>
                                </table>
                            </div>

                            <div class="alert alert-info mt-3">
                                Remaining: <strong id="remainingValue">0.00</strong>
                                <span id="remainingCurrency">--</span>
                                <span class="text-muted ms-2" id="remainingPercent"></span>
                            </div>
                        </div>

                        <!-- ACTIONS -->
                        <div class="mt-4 d-flex justify-content-end">
                            <a href="{{ route('budget.programs.index') }}" class="btn btn-light border me-2">Cancel</a>
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-check2-circle me-1"></i> Save Program
                            </button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </main>

    <script>
        /* DOM ELEMENTS */
        const startYear = document.getElementById('startYear');
        const endYear = document.getElementById('endYear');
        const totalYears = document.getElementById('totalYears');
        const container = document.getElementById('allocationsContainer');
        const body = document.getElementById('allocationTableBody');
        const totalBudget = document.getElementById('totalBudget');
        const remainingValue = document.getElementById('remainingValue');
        const currencySelect = document.getElementById('currencySelect');
        const currencyHidden = document.getElementById('currencyHidden');
        const remainingCurrency = document.getElementById('remainingCurrency');
        const currencyLabel = document.getElementById('currencyLabel');
        const modeSelect = document.getElementById('allocationMode');
        const programNameSelect = document.getElementById('programNameSelect');
        const allocationLabel = document.getElementById('allocationLabel');
        const remainingPercent = document.getElementById('remainingPercent');

        function updateCurrency(value) {
            if (!value) return;
            const exists = Array.from(currencySelect.options).some(opt => opt.value === value);
            if (!exists) {
                const opt = document.createElement('option');
                opt.value = value;
                opt.textContent = value;
                currencySelect.appendChild(opt);
            }
            currencySelect.value = value;
            currencyHidden.value = value;
            currencyLabel.textContent = value;
            remainingCurrency.textContent = value;
        }

        /* Calculate total years from start + end */
        function calculateYears() {
            let s = parseInt(startYear.value);
            let e = parseInt(endYear.value);

            if (!s || !e || e < s) {
                container.style.display = "none";
                return;
            }

            let years = (e - s) + 1;
            totalYears.value = years;

            generateRows(s, e);
        }

        function applyFundingDefaults() {
            const selected = programNameSelect.options[programNameSelect.selectedIndex];
            if (!selected) return;

            const currency = selected.dataset.currency || '';
            const start = selected.dataset.startYear || '';
            const end = selected.dataset.endYear || '';
            const total = selected.dataset.totalBudget || '';

            updateCurrency(currency);
            startYear.value = start;
            endYear.value = end;
            totalBudget.value = total;

            calculateYears();
        }

        programNameSelect.addEventListener('change', applyFundingDefaults);

        /* Generate allocation rows */
        function generateRows(start, end) {
            body.innerHTML = "";
            container.style.display = "block";

            for (let year = start; year <= end; year++) {
                body.innerHTML += `
            <tr>
                <td><strong>${year}</strong></td>
                <td>
                    <input type="number" class="form-control allocation-input"
                        name="allocations[${year}]"
                        step="0.01" min="0" value="0">
                </td>
            </tr>`;
            }

            document.querySelectorAll('.allocation-input')
                .forEach(inp => inp.addEventListener('input', calculateRemaining));

            calculateRemaining();
        }

        /* Calculate remaining balance */
        function calculateRemaining() {
            const budget = parseFloat(totalBudget.value) || 0;
            let total = 0;
            let totalPercent = 0;

            document.querySelectorAll('.allocation-input').forEach(input => {
                let val = parseFloat(input.value) || 0;

                if (modeSelect.value === "percentage") {
                    totalPercent += val;
                    val = budget * (val / 100);
                }
                total += val;
            });

            const remaining = budget - total;
            remainingValue.textContent = remaining.toFixed(2);
            remainingPercent.textContent = '';

            if (modeSelect.value === "percentage") {
                const remainingPct = 100 - totalPercent;
                remainingPercent.textContent = `(${remainingPct.toFixed(2)}%)`;
            }

            if (remaining < 0) {
                remainingValue.classList.add('text-danger');
            } else {
                remainingValue.classList.remove('text-danger');
            }
        }

        /* Change label for amount/percentage */
        modeSelect.addEventListener('change', () => {
            allocationLabel.textContent =
                modeSelect.value === "percentage" ? "Percentage (%)" : "Amount";
            calculateRemaining();
        });

        function toggleExpectedOutcomeFields() {
            const type = document.getElementById('expectedOutcomeType').value;
            const percentWrap = document.getElementById('expectedOutcomePercentageWrap');
            const textWrap = document.getElementById('expectedOutcomeTextWrap');

            percentWrap.style.display = type === 'percentage' ? 'block' : 'none';
            textWrap.style.display = type === 'text' ? 'block' : 'none';
        }

        document.getElementById('expectedOutcomeType').addEventListener('change', toggleExpectedOutcomeFields);
        toggleExpectedOutcomeFields();

        applyFundingDefaults();
    </script>

@endsection
