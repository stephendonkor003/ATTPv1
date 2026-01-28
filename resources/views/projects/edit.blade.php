@extends('layouts.app')

@section('title', 'Edit Project')

@section('content')
    <main class="nxl-container">
        <div class="nxl-content">

            {{-- HEADER --}}
            <div class="page-header d-flex justify-content-between mb-4">
                <div>
                    <h4 class="mb-1">Edit Project — {{ $project->project_id }}</h4>
                    <p class="text-muted m-0">Update project details and yearly budget allocations.</p>
                </div>
                <a href="{{ route('budget.projects.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left-circle me-1"></i> Back
                </a>
            </div>

            {{-- ERROR BLOCK --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>There were errors:</strong>
                    <ul class="my-2">
                        @foreach ($errors->all() as $e)
                            <li>{{ $e }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            {{-- FORM --}}
            <form action="{{ route('budget.projects.update', $project->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- MAIN CARD --}}
                <div class="card shadow-sm mb-4">
                    <div class="card-body">

                        <div class="row g-4">

                            {{-- PROGRAM --}}
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Program <span class="text-danger">*</span></label>
                                <select name="program_id" class="form-select" required>
                                    @foreach ($programs as $program)
                                        <option value="{{ $program->id }}" data-start="{{ $program->start_year }}"
                                            data-end="{{ $program->end_year }}" data-currency="{{ $program->currency }}"
                                            {{ $program->id == $project->program_id ? 'selected' : '' }}>
                                            {{ $program->program_id }} — {{ $program->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- NAME --}}
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Project Name <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="name" value="{{ $project->name }}" class="form-control"
                                    required>
                            </div>

                            {{-- TOTAL BUDGET --}}
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Total Budget <span
                                        class="text-danger">*</span></label>
                                <input type="number" id="totalBudget" name="total_budget" class="form-control"
                                    value="{{ $project->total_budget }}" min="0" step="0.01" required>
                            </div>

                            {{-- START YEAR --}}
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Start Year</label>
                                <input type="number" id="startYear" name="start_year" value="{{ $project->start_year }}"
                                    class="form-control" required onchange="regenerateRows()">
                            </div>

                            {{-- END YEAR --}}
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">End Year</label>
                                <input type="number" id="endYear" name="end_year" value="{{ $project->end_year }}"
                                    class="form-control" required onchange="regenerateRows()">
                            </div>

                            {{-- EXPECTED OUTCOME --}}
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Expected Outcome Type <span class="text-danger">*</span></label>
                                <select name="expected_outcome_type" id="expectedOutcomeType" class="form-select" required>
                                    <option value="">-- Select Type --</option>
                                    <option value="percentage" {{ old('expected_outcome_type', $project->expected_outcome_type) === 'percentage' ? 'selected' : '' }}>Percentage</option>
                                    <option value="text" {{ old('expected_outcome_type', $project->expected_outcome_type) === 'text' ? 'selected' : '' }}>Text</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Expected Outcome <span class="text-danger">*</span></label>
                                <div id="expectedOutcomePercentage" style="display:none;">
                                    <div class="input-group">
                                        <input type="number" name="expected_outcome_percentage" class="form-control" min="0" max="100" step="0.01"
                                            value="{{ old('expected_outcome_percentage', $project->expected_outcome_type === 'percentage' ? $project->expected_outcome_value : '') }}">
                                        <span class="input-group-text">%</span>
                                    </div>
                                </div>
                                <div id="expectedOutcomeText" style="display:none;">
                                    <textarea name="expected_outcome_text" class="form-control" rows="2">{{ old('expected_outcome_text', $project->expected_outcome_type === 'text' ? $project->expected_outcome_value : '') }}</textarea>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                {{-- ALLOCATION TOOL --}}
                <div class="card shadow-sm">
                    <div class="card-body">

                        <h5 class="fw-semibold mb-3">Yearly Allocations ({{ $project->currency }})</h5>

                        {{-- ACTION BUTTONS --}}
                        <div class="d-flex gap-2 mb-3">
                            <button type="button" class="btn btn-primary btn-sm" onclick="distributeEvenly()">Distribute
                                Evenly</button>
                            <button type="button" class="btn btn-warning btn-sm" onclick="autoBalance()">Auto Balance Last
                                Year</button>
                            <button type="button" class="btn btn-info btn-sm" onclick="openPercentModal()">Distribute by
                                %</button>
                        </div>

                        {{-- TOTAL + REMAINING --}}
                        <div class="alert alert-secondary p-2">
                            Total Budget: <strong id="totalBudgetLabel">{{ $project->total_budget }}</strong>
                        </div>

                        <div class="alert alert-info p-2" id="remainingAlert">
                            Remaining: <strong id="remainingValue">0</strong>
                        </div>

                        {{-- TABLE --}}
                        <table class="table table-bordered align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Actual Year</th>
                                    <th>Amount ({{ $project->currency }})</th>
                                </tr>
                            </thead>
                            <tbody id="allocTableBody">

                                @foreach ($project->allocations as $alloc)
                                    <tr>
                                        <td>{{ $alloc->actual_year }}</td>
                                        <td>
                                            <input type="number" class="form-control alloc-input"
                                                name="allocations[{{ $alloc->actual_year }}]" step="0.01" min="0"
                                                value="{{ $alloc->amount }}">
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>

                    </div>
                </div>

                {{-- SUBMIT --}}
                <div class="mt-4 d-flex justify-content-end">
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-check-circle me-1"></i> Update Project
                    </button>
                </div>
            </form>
        </div>
    </main>

    {{-- ============= SMART JS ENGINE ============= --}}
    <script>
        /* ---------------------------------------------------------
           GLOBAL REFERENCES
        --------------------------------------------------------- */
        let totalBudgetInput = document.getElementById("totalBudget");
        let totalBudgetLabel = document.getElementById("totalBudgetLabel");

        let startYearInput = document.getElementById("startYear");
        let endYearInput = document.getElementById("endYear");

        let allocTableBody = document.getElementById("allocTableBody");
        let remainingValue = document.getElementById("remainingValue");
        let remainingAlert = document.getElementById("remainingAlert");
        let expectedOutcomeType = document.getElementById("expectedOutcomeType");
        let expectedOutcomePercentage = document.getElementById("expectedOutcomePercentage");
        let expectedOutcomeText = document.getElementById("expectedOutcomeText");

        let manual = {}; // Tracks manually edited fields

        /* ---------------------------------------------------------
           INITIALIZE ALL INPUT LISTENERS
        --------------------------------------------------------- */
        document.querySelectorAll(".alloc-input").forEach(input => {
            input.addEventListener("input", () => {
                manual[input.dataset.year] = true;
                recalcTotals();
            });
        });

        totalBudgetInput.addEventListener("input", recalcTotals);
        expectedOutcomeType.addEventListener("change", toggleExpectedOutcome);

        /* ---------------------------------------------------------
           REGENERATE ROWS WHEN YEARS CHANGE
        --------------------------------------------------------- */
        function regenerateRows() {
            let start = parseInt(startYearInput.value);
            let end = parseInt(endYearInput.value);

            if (!start || !end || end < start) {
                allocTableBody.innerHTML = "";
                return;
            }

            // old allocations for restore
            let oldValues = {};
            document.querySelectorAll(".alloc-input").forEach(inp => {
                oldValues[inp.dataset.actual] = parseFloat(inp.value) || 0;
            });

            allocTableBody.innerHTML = "";
            manual = {};

            let rowNumber = 1;

            for (let year = start; year <= end; year++) {
                let previousVal = oldValues[year] ?? 0;

                allocTableBody.innerHTML += `
            <tr>
                <td>${year}</td>
                <td>
                    <input type="number"
                           class="form-control alloc-input"
                           name="allocations[${year}]"
                           data-actual="${year}"
                           data-yearnum="${rowNumber}"
                           min="0" step="0.01"
                           value="${previousVal}">
                </td>
            </tr>
        `;

                rowNumber++;
            }

            document.querySelectorAll(".alloc-input").forEach(input => {
                input.addEventListener("input", () => {
                    manual[input.dataset.actual] = true;
                    recalcTotals();
                });
            });

            recalcTotals();
        }

        /* ---------------------------------------------------------
           RECALCULATE TOTAL & REMAINING
        --------------------------------------------------------- */
        function recalcTotals() {
            let budget = parseFloat(totalBudgetInput.value) || 0;
            totalBudgetLabel.innerText = budget.toFixed(2);

            let inputs = [...document.querySelectorAll(".alloc-input")];
            let total = inputs.reduce((sum, inp) => sum + (parseFloat(inp.value) || 0), 0);

            let remaining = budget - total;

            remainingValue.innerText = remaining.toFixed(2);
            remainingAlert.className = remaining < 0 ? "alert alert-danger" : "alert alert-info";
        }

        /* ---------------------------------------------------------
           EVEN DISTRIBUTION BUTTON
        --------------------------------------------------------- */
        function distributeEvenly() {
            let budget = parseFloat(totalBudgetInput.value) || 0;
            let inputs = [...document.querySelectorAll(".alloc-input")];

            if (inputs.length === 0) return;

            let even = budget / inputs.length;

            inputs.forEach(inp => {
                inp.value = even.toFixed(2);
                inp.classList.add("ai-blink");
                setTimeout(() => inp.classList.remove("ai-blink"), 2000);
                manual[inp.dataset.actual] = false;
            });

            recalcTotals();
        }

        /* ---------------------------------------------------------
           AUTO-BALANCE LAST YEAR
        --------------------------------------------------------- */
        function autoBalance() {
            let budget = parseFloat(totalBudgetInput.value) || 0;
            let inputs = [...document.querySelectorAll(".alloc-input")];

            if (inputs.length === 0) return;

            let totalManual = 0;

            inputs.slice(0, -1).forEach(inp => {
                totalManual += parseFloat(inp.value) || 0;
            });

            let lastInput = inputs[inputs.length - 1];

            lastInput.value = (budget - totalManual).toFixed(2);
            lastInput.classList.add("ai-blink");

            setTimeout(() => lastInput.classList.remove("ai-blink"), 2000);

            recalcTotals();
        }

        /* ---------------------------------------------------------
           DISTRIBUTE BY PERCENTAGE (MODAL POPUP)
        --------------------------------------------------------- */
        function openPercentModal() {
            let start = parseInt(startYearInput.value);
            let end = parseInt(endYearInput.value);

            if (!start || !end || end < start) {
                alert("Please select a valid year range first.");
                return;
            }

            let rows = "";
            let count = 1;

            for (let y = start; y <= end; y++) {
                rows += `
            <tr>
                <td>${y}</td>
                <td><input type="number" class="form-control percent-field" data-year="${y}" min="0" max="100"></td>
            </tr>
        `;
                count++;
            }

            let modal = `
        <div class="modal fade" id="percentModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Distribute Using Percentages</h5>
                        <button class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <table class="table table-bordered">
                            <thead><tr><th>Year</th><th>%</th></tr></thead>
                            <tbody>${rows}</tbody>
                        </table>
                        <div class="alert alert-info">Total must equal 100%.</div>
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button class="btn btn-primary" onclick="applyPercent()">Apply</button>
                    </div>
                </div>
            </div>
        </div>
    `;

            document.body.insertAdjacentHTML("beforeend", modal);
            new bootstrap.Modal(document.getElementById("percentModal")).show();
        }

        /* ---------------------------------------------------------
           APPLY PERCENTAGE DISTRIBUTION
        --------------------------------------------------------- */
        function applyPercent() {
            let budget = parseFloat(totalBudgetInput.value) || 0;
            let percentFields = [...document.querySelectorAll(".percent-field")];

            let sum = percentFields.reduce((sum, f) => sum + (parseFloat(f.value) || 0), 0);

            if (sum !== 100) {
                alert("Total percentage must be exactly 100%");
                return;
            }

            percentFields.forEach(f => {
                let year = f.dataset.year;
                let percent = parseFloat(f.value) || 0;

                let amount = (budget * percent) / 100;

                let target = document.querySelector(`input[name="allocations[${year}]"]`);
                if (target) {
                    target.value = amount.toFixed(2);
                    target.classList.add("ai-blink");
                    setTimeout(() => target.classList.remove("ai-blink"), 2000);
                }
            });

            recalcTotals();

            bootstrap.Modal.getInstance(document.getElementById("percentModal")).hide();
            document.getElementById("percentModal").remove();
        }

        function toggleExpectedOutcome() {
            const type = expectedOutcomeType.value;
            expectedOutcomePercentage.style.display = type === "percentage" ? "block" : "none";
            expectedOutcomeText.style.display = type === "text" ? "block" : "none";
        }

        toggleExpectedOutcome();
    </script>

    <style>
        .ai-blink {
            animation: glow 1.4s ease-in-out 2;
            border: 2px solid #198754 !important;
        }

        @keyframes glow {
            0% {
                box-shadow: 0 0 0px #198754;
            }

            50% {
                box-shadow: 0 0 10px #198754;
            }

            100% {
                box-shadow: 0 0 0px #198754;
            }
        }
    </style>

@endsection
