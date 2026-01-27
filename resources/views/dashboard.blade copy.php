@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <main class="nxl-container">
        <div class="nxl-content">
            <!-- Page Header -->
            <div class="page-header">
                <div class="page-header-left d-flex align-items-center">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Think Tank Portal Dashboard</h5>
                    </div>
                </div>
                <div class="page-header-right ms-auto text-end">
                    <div class="d-flex align-items-center">
                        <div class="me-3 text-muted small">
                            Welcome, <strong>{{ Auth::user()->name }}</strong>
                        </div>
                    </div>
                </div>
            </div>

            <br>

            <!-- Dashboard Cards -->
            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <div class="card text-center shadow-sm">
                        <div class="card-body">
                            <i class="feather-users fs-3 text-primary"></i>
                            <h6 class="mt-3 fw-bold">Total Applicants</h6>
                            <p class="fs-5">{{ $totalApplicants }}</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card text-center shadow-sm">
                        <div class="card-body">
                            <i class="feather-globe fs-3 text-info"></i>
                            <h6 class="mt-3 fw-bold">Countries Participating</h6>
                            <p class="fs-5">{{ $countriesCount }}</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card text-center shadow-sm">
                        <div class="card-body">
                            <i class="feather-check-circle fs-3 text-success"></i>
                            <h6 class="mt-3 fw-bold">Reviewed Applications</h6>
                            <p class="fs-5">{{ $reviewedApplicants }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Applications Trend Chart -->
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="mb-0">Applications Trend (Last 7 Days)</h6>
                </div>
                <div class="card-body">
                    <canvas id="applicationsChart" height="100"></canvas>
                </div>
            </div>

            <!-- Applicants by Country Chart -->
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">Applicants by Country</h6>
                </div>
                <div class="card-body">
                    <canvas id="countryChart" height="100"></canvas>
                </div>
            </div>
        </div>
    </main>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const ctx = document.getElementById('applicationsChart').getContext('2d');
        const chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode($applicationDates) !!},
                datasets: [{
                    label: 'Applications',
                    data: {!! json_encode($applicationCounts) !!},
                    borderColor: '#3e95cd',
                    backgroundColor: 'rgba(62, 149, 205, 0.4)',
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false
                    }
                },
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Date'
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'No. of Applications'
                        },
                        beginAtZero: true
                    }
                }
            }
        });

        const ctx2 = document.getElementById('countryChart').getContext('2d');
        const chart2 = new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: {!! json_encode(\App\Models\Applicant::select('country')->groupBy('country')->pluck('country')) !!},
                datasets: [{
                    label: 'Applicants',
                    data: {!! json_encode(\App\Models\Applicant::selectRaw('count(*) as count')->groupBy('country')->pluck('count')) !!},
                    backgroundColor: 'rgba(75, 192, 192, 0.6)',
                    borderColor: '#4bc0c0',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Applicants'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Country'
                        }
                    }
                }
            }
        });
    </script>
@endsection
