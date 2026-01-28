@extends('layouts.app')

@section('title', 'Project Details')

@section('content')
    <main class="nxl-container">
        <div class="nxl-content">

            <!-- HEADER -->
            <div class="page-header d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="mb-1">{{ $project->project_id }} — {{ $project->name }}</h4>
                    <p class="text-muted m-0">Detailed project analytics, timeline & budget allocations.</p>
                </div>

                <a href="{{ route('budget.projects.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left-circle me-1"></i> Back
                </a>
            </div>

            <!-- TOP SUMMARY CARDS -->
            <div class="row g-4 mb-4">
                <div class="col-md-3">
                    <div class="card shadow-sm stat-card">
                        <div class="card-body text-center">
                            <h6 class="text-muted">Total Budget</h6>
                            <h3 class="fw-bold">{{ number_format($project->total_budget, 2) }} {{ $project->currency }}</h3>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card shadow-sm stat-card">
                        <div class="card-body text-center">
                            <h6 class="text-muted">Duration</h6>
                            <h3 class="fw-bold">{{ $project->start_year }} - {{ $project->end_year }}</h3>
                            <small class="text-muted">{{ $project->total_years }} Years</small>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card shadow-sm stat-card">
                        <div class="card-body text-center">
                            <h6 class="text-muted">Total Allocations</h6>
                            @php
                                $sumAlloc = $project->allocations->sum('amount');
                            @endphp
                            <h3 class="fw-bold">{{ number_format($sumAlloc, 2) }} {{ $project->currency }}</h3>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card shadow-sm stat-card">
                        <div class="card-body text-center">
                            <h6 class="text-muted">Remaining Allocations</h6>
                            <h3 class="fw-bold text-primary">{{ number_format($project->total_budget - $sumAlloc, 2) }}
                                {{ $project->currency }}</h3>
                        </div>
                    </div>
                </div>
            </div>

            <!-- PROJECT SUMMARY -->
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">Project Summary</h5>

                    <p><strong>Program:</strong> {{ $project->program->name }}</p>
                    <p><strong>Description:</strong> {{ $project->description ?? 'No description provided' }}</p>

                    <p><strong>Project Identification :</strong>
                        {{ $project->project_id ?? 'N/A' }}
                    </p>

                    <p><strong>Expected Outcome:</strong>
                        @if ($project->expected_outcome_type === 'percentage')
                            {{ $project->expected_outcome_value ?? 'N/A' }}%
                        @elseif ($project->expected_outcome_type === 'text')
                            {{ $project->expected_outcome_value ?? 'N/A' }}
                        @else
                            N/A
                        @endif
                    </p>

                </div>
            </div>

            <!-- ALLOCATION CHARTS -->
            <div class="row g-4 mb-4">
                <div class="col-md-6">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h6 class="fw-bold mb-3">Allocation Trend (Line Chart)</h6>
                            <canvas id="lineChart" height="130"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h6 class="fw-bold mb-3">Allocation Proportion (Pie Chart)</h6>
                            <canvas id="pieChart" height="130"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TIMELINE -->
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">Project Timeline</h5>

                    <div class="timeline">
                        @foreach ($project->allocations as $alloc)
                            <div class="timeline-item">
                                <span class="timeline-year">{{ $alloc->actual_year }}</span>
                                <div class="timeline-content">
                                    <strong>{{ number_format($alloc->amount, 2) }} {{ $project->currency }}</strong>
                                </div>
                            </div>
                        @endforeach
                    </div>

                </div>
            </div>

            <!-- YEARLY ALLOCATION TABLE -->
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">Detailed Yearly Allocations</h5>

                    <button class="btn btn-primary btn-sm mb-3" onclick="toggleAlloc()">Show / Hide Table</button>

                    <div id="allocTableWrap" style="display:none;">
                        <table class="table table-bordered align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Year</th>
                                    <th>Amount ({{ $project->currency }})</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($project->allocations as $alloc)
                                    <tr>
                                        <td>{{ $alloc->actual_year }}</td>
                                        <td>{{ number_format($alloc->amount, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

        </div>
    </main>

    <style>
        .stat-card {
            border-radius: 12px;
            transition: 0.3s;
        }

        .stat-card:hover {
            transform: translateY(-3px);
        }

        /* Timeline */
        .timeline {
            border-left: 3px solid #0d6efd;
            padding-left: 25px;
            position: relative;
        }

        .timeline-item {
            margin-bottom: 15px;
            position: relative;
        }

        .timeline-year {
            position: absolute;
            left: -55px;
            top: 0;
            font-weight: bold;
        }

        .timeline-content {
            background: #f8f9fa;
            padding: 10px 15px;
            border-radius: 8px;
            border-left: 4px solid #0d6efd;
        }
    </style>
    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        /* -----------------------------------------------
                                           PREPARE CHART DATA
                                        ------------------------------------------------*/
        let years = @json($project->allocations->pluck('actual_year'));
        let amounts = @json($project->allocations->pluck('amount'));

        /* -----------------------------------------------
           LINE CHART
        ------------------------------------------------*/
        new Chart(document.getElementById('lineChart'), {
            type: 'line',
            data: {
                labels: years,
                datasets: [{
                    label: 'Yearly Allocation',
                    data: amounts,
                    borderColor: '#0d6efd',
                    backgroundColor: 'rgba(13,110,253,0.2)',
                    borderWidth: 3,
                    tension: 0.4
                }]
            }
        });

        /* -----------------------------------------------
           PIE CHART
        ------------------------------------------------*/
        new Chart(document.getElementById('pieChart'), {
            type: 'pie',
            data: {
                labels: years,
                datasets: [{
                    data: amounts,
                    backgroundColor: [
                        '#0d6efd', '#198754', '#dc3545', '#ffc107', '#20c997',
                        '#6f42c1', '#fd7e14', '#0dcaf0'
                    ]
                }]
            }
        });

        /* -----------------------------------------------
           ALLOCATION TABLE TOGGLE
        ------------------------------------------------*/
        function toggleAlloc() {
            let wrap = document.getElementById("allocTableWrap");
            wrap.style.display = wrap.style.display === "none" ? "block" : "none";
        }
    </script>

@endsection
