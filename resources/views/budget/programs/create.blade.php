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
                                <input type="text" name="name" class="form-control" placeholder="Enter program name"
                                    required>
                            </div>

                            <!-- CURRENCY -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Currency <span class="text-danger">*</span></label>
                                <select name="currency" id="currencySelect" class="form-select" required>
                                    <option value="">-- Select --</option>
                                    <option value="USD">USD</option>
                                    <option value="EUR">EUR</option>
                                    <option value="GHS">GHS</option>
                                    <option value="NGN">NGN</option>
                                    <option value="ZAR">ZAR</option>
                                </select>
                            </div>

                            <!-- TOTAL BUDGET -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Total Budget <span
                                        class="text-danger">*</span></label>
                                <input type="number" name="total_budget" id="totalBudget" class="form-control"
                                    step="0.01" min="0" placeholder="0.00" required>
                            </div>

                            <!-- START YEAR -->
                            <div class="col-md-3">
                                <label class="form-label fw-semibold">Start Year <span class="text-danger">*</span></label>
                                <input type="number" name="start_year" id="startYear" class="form-control" min="1900"
                                    max="2100" placeholder="2025" required>
                            </div>

                            <!-- END YEAR -->
                            <div class="col-md-3">
                                <label class="form-label fw-semibold">End Year <span class="text-danger">*</span></label>
                                <input type="number" name="end_year" id="endYear" class="form-control" min="1900"
                                    max="2100" placeholder="2030" required>
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
        const remainingCurrency = document.getElementById('remainingCurrency');
        const currencyLabel = document.getElementById('currencyLabel');
        const modeSelect = document.getElementById('allocationMode');

        /* Update currency labels */
        currencySelect.addEventListener('change', () => {
            currencyLabel.textContent = currencySelect.value;
            remainingCurrency.textContent = currencySelect.value;
        });

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

        startYear.addEventListener('input', calculateYears);
        endYear.addEventListener('input', calculateYears);

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

            document.querySelectorAll('.allocation-input').forEach(input => {
                let val = parseFloat(input.value) || 0;

                if (modeSelect.value === "percentage") {
                    val = budget * (val / 100);
                }
                total += val;
            });

            remainingValue.textContent = (budget - total).toFixed(2);
        }

        /* Change label for amount/percentage */
        modeSelect.addEventListener('change', () => {
            allocationLabel.textContent =
                modeSelect.value === "percentage" ? "Percentage (%)" : "Amount";
            calculateRemaining();
        });
    </script>

@endsection
