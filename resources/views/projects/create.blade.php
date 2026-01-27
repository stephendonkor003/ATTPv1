@extends('layouts.app')

@section('title', 'Create Project')

@section('content')
    <main class="nxl-container">
        <div class="nxl-content">

            <!-- PAGE HEADER -->
            <div class="page-header d-flex justify-content-between mb-4">
                <div>
                    <h4 class="mb-1">Create New Project</h4>
                    <p class="text-muted m-0">Assign project details and allocate budget year by year.</p>
                </div>
                <a href="{{ route('budget.projects.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left-circle me-1"></i> Back
                </a>
            </div>

            <!-- VALIDATION ERRORS -->
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

            <!-- FORM -->
            <form action="{{ route('budget.projects.store') }}" method="POST">
                @csrf

                <!-- PROJECT DETAILS -->
                <div class="card shadow-sm mb-4">
                    <div class="card-body">

                        <div class="row g-4">

                            <!-- PROGRAM -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Program <span class="text-danger">*</span></label>
                                <select name="program_id" id="programSelect" class="form-select" required>
                                    <option value="">-- Select Program --</option>
                                    @foreach ($programs as $p)
                                        <option value="{{ $p->id }}" data-start="{{ $p->start_year }}"
                                            data-end="{{ $p->end_year }}" data-currency="{{ $p->currency }}">
                                            {{ $p->program_id }} — {{ $p->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- PROJECT NAME -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Project Name <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control" required>
                            </div>

                            <!-- TOTAL PROJECT BUDGET -->
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Total Project Budget <span
                                        class="text-danger">*</span></label>
                                <input type="number" name="total_budget" id="totalBudget" class="form-control"
                                    min="0" step="0.01" required>
                            </div>

                            <!-- START YEAR -->
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Start Year <span class="text-danger">*</span></label>
                                <input type="number" name="start_year" id="startYear" class="form-control" required>
                            </div>

                            <!-- END YEAR -->
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">End Year <span class="text-danger">*</span></label>
                                <input type="number" name="end_year" id="endYear" class="form-control" required>
                            </div>

                            <!-- ALLOCATION MODE -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Allocation Mode <span
                                        class="text-danger">*</span></label>
                                <select name="allocation_mode" id="allocationMode" class="form-select" required>
                                    <option value="">-- Select Mode --</option>
                                    <option value="amount">Amount Allocation</option>
                                    <option value="percentage">Percentage Allocation (%)</option>
                                </select>
                            </div>

                            <!-- DESCRIPTION -->
                            <div class="col-md-12">
                                <label class="form-label fw-semibold">Description (Optional)</label>
                                <textarea name="description" class="form-control" rows="3"></textarea>
                            </div>

                        </div>

                    </div>
                </div>

                <!-- ALLOCATION TABLE -->
                <div id="allocSection" style="display:none;">
                    <div class="card shadow-sm">
                        <div class="card-body">

                            <h5 class="fw-semibold mb-3">
                                Yearly Budget Allocation
                                (<span id="currencyLabel">--</span>)
                            </h5>

                            <div class="alert alert-info p-2">
                                Total Project Budget: <strong id="totalBudgetLabel">0.00</strong>
                            </div>

                            <table class="table table-bordered align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Year</th>
                                        <th id="allocHeader">Allocation</th>
                                    </tr>
                                </thead>
                                <tbody id="allocTableBody"></tbody>
                            </table>

                            <div id="remainingAlert" class="alert alert-info mt-3">
                                Remaining: <strong id="remainingValue">0.00</strong>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- BUTTON -->
                <div class="mt-4 d-flex justify-content-end">
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-check-circle me-1"></i> Save Project
                    </button>
                </div>

            </form>

        </div>
    </main>

    <!-- STYLES -->
    <style>
        .ai-blink {
            animation: aiGlow 1.5s ease-out 2;
            border: 2px solid #28a745 !important;
        }

        @keyframes aiGlow {
            0% {
                box-shadow: 0 0 0px #28a745;
            }

            50% {
                box-shadow: 0 0 12px #28a745;
            }

            100% {
                box-shadow: 0 0 0px #28a745;
            }
        }
    </style>

    <!-- SCRIPT -->
    <script>
        let programStart = 0;
        let programEnd = 0;
        let currency = "";
        let manual = {};

        const programSelect = document.getElementById("programSelect");
        const startYear = document.getElementById("startYear");
        const endYear = document.getElementById("endYear");
        const budget = document.getElementById("totalBudget");
        const allocMode = document.getElementById("allocationMode");
        const tableBody = document.getElementById("allocTableBody");
        const allocSection = document.getElementById("allocSection");
        const remainingValue = document.getElementById("remainingValue");
        const totalBudgetLabel = document.getElementById("totalBudgetLabel");
        const allocHeader = document.getElementById("allocHeader");
        const currencyLabel = document.getElementById("currencyLabel");

        programSelect.addEventListener("change", function() {
            programStart = parseInt(this.selectedOptions[0].dataset.start);
            programEnd = parseInt(this.selectedOptions[0].dataset.end);
            currency = this.selectedOptions[0].dataset.currency;

            startYear.value = programStart;
            endYear.value = programEnd;
            currencyLabel.innerText = currency;

            generateTable();
        });

        budget.addEventListener("input", updateAllocations);
        startYear.addEventListener("input", generateTable);
        endYear.addEventListener("input", generateTable);
        allocMode.addEventListener("change", generateTable);

        function generateTable() {
            let s = parseInt(startYear.value);
            let e = parseInt(endYear.value);

            if (!s || !e || e < s || !allocMode.value) {
                allocSection.style.display = "none";
                return;
            }

            allocHeader.innerText = allocMode.value === "percentage" ? "Allocation (%)" : "Allocation";
            tableBody.innerHTML = "";
            manual = {}; // reset manual edits

            for (let year = s; year <= e; year++) {
                tableBody.innerHTML += `
                <tr>
                    <td>${year}</td>
                    <td>
                        <input type="number" min="0" step="0.01"
                               class="form-control allocInput"
                               name="allocations[${year}]"
                               data-year="${year}"
                               value="0">
                    </td>
                </tr>
            `;
            }

            allocSection.style.display = "block";
            attachInputListeners();
            updateAllocations();
        }

        function attachInputListeners() {
            document.querySelectorAll('.allocInput').forEach(input => {
                input.addEventListener('input', function() {
                    manual[this.dataset.year] = true;
                    updateAllocations();
                });
            });
        }

        function updateAllocations() {
            let total = parseFloat(budget.value) || 0;
            totalBudgetLabel.innerText = total.toFixed(2);

            let inputs = document.querySelectorAll('.allocInput');
            let manualTotal = 0;

            inputs.forEach(i => {
                let v = parseFloat(i.value) || 0;
                if (manual[i.dataset.year]) {
                    // convert percentage to amount
                    if (allocMode.value === "percentage") {
                        v = (v / 100) * total;
                    }
                    manualTotal += v;
                }
            });

            let autoYears = [...inputs].filter(i => !manual[i.dataset.year]);
            let remaining = total - manualTotal;

            if (autoYears.length > 0) {
                let autoAmount = remaining / autoYears.length;

                autoYears.forEach(i => {
                    let year = i.dataset.year;
                    i.value = allocMode.value === "percentage" ?
                        ((autoAmount / total) * 100).toFixed(2) :
                        autoAmount.toFixed(2);

                    i.classList.add("ai-blink");
                    setTimeout(() => i.classList.remove("ai-blink"), 2000);
                });
            }

            // final total check
            let finalTotal = 0;
            inputs.forEach(i => {
                let v = parseFloat(i.value) || 0;
                if (allocMode.value === "percentage") {
                    v = (v / 100) * total;
                }
                finalTotal += v;
            });

            remainingValue.innerText = (total - finalTotal).toFixed(2);

            if (finalTotal > total) {
                remainingAlert.className = "alert alert-danger";
            } else {
                remainingAlert.className = "alert alert-info";
            }
        }
    </script>

@endsection
