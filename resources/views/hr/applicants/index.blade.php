@extends('layouts.app')

@section('content')
    <div class="nxl-container">

        {{-- ================= PAGE HEADER ================= --}}
        <div class="page-header mb-4">
            <div class="d-flex flex-column align-items-start gap-2">
                <div>
                    <h4 class="fw-bold mb-1">
                        <i class="feather-users text-primary me-2"></i>
                        Applications
                    </h4>
                    <p class="text-muted mb-0">
                        Vacancy: <strong>{{ $vacancy->position->title ?? 'N/A' }}</strong>
                    </p>
                </div>

                <a href="{{ route('hr.vacancies.index') }}" class="btn btn-light btn-sm">
                    <i class="feather-arrow-left me-1"></i>
                    Back to Vacancies
                </a>
            </div>
        </div>

        {{-- ================= ALERT MESSAGES ================= --}}
        @if (session('success'))
            <div class="alert alert-success d-flex align-items-start gap-2 shadow-sm">
                <i class="feather-check-circle mt-1"></i>
                <div>
                    <strong>Success</strong>
                    <div>{{ session('success') }}</div>
                </div>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger d-flex align-items-start gap-2 shadow-sm">
                <i class="feather-alert-triangle mt-1"></i>
                <div>
                    <strong>Action Failed</strong>
                    <div>{{ session('error') }}</div>
                </div>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger shadow-sm">
                <strong>Please fix the following:</strong>
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif


        {{-- ================= KPI SUMMARY ================= --}}
        @php
            $total = $applicants->count();
            $scored = $applicants->where('status', 'scored')->count();
            $shortlisted = $applicants->where('status', 'shortlisted')->count();
            $hired = $applicants->where('status', 'hired')->count();
            $rejected = $applicants->where('status', 'rejected')->count();
        @endphp

        <div class="row g-3 mb-4">
            @foreach ([['label' => 'Total Applicants', 'value' => $total, 'color' => 'primary'], ['label' => 'Scored', 'value' => $scored, 'color' => 'info'], ['label' => 'Shortlisted', 'value' => $shortlisted, 'color' => 'warning'], ['label' => 'Hired', 'value' => $hired, 'color' => 'success'], ['label' => 'Rejected', 'value' => $rejected, 'color' => 'danger']] as $stat)
                <div class="col-6 col-md">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-body">
                            <small class="text-muted">{{ $stat['label'] }}</small>
                            <h4 class="fw-bold text-{{ $stat['color'] }} mb-0">
                                {{ $stat['value'] }}
                            </h4>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- ================= PIPELINE CHART ================= --}}
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body">
                <h6 class="fw-semibold mb-1">Recruitment Pipeline Overview</h6>
                <p class="text-muted small mb-3">
                    Applicant progression through recruitment stages
                </p>
                <canvas id="pipelineChart" height="110"></canvas>
            </div>
        </div>

        {{-- ================= APPLICATIONS TABLE ================= --}}
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white border-0 pb-0">
                <h6 class="fw-semibold mb-1">Applicant Records</h6>
                <p class="text-muted small mb-0">
                    Individual applicants, AI scores, documents, and actions
                </p>
            </div>

            <div class="card-body pt-3">
                <div class="table-responsive">
                    <table class="table table-hover align-middle w-100 hr-app-table mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Applicant</th>
                                <th>AI Score</th>
                                <th>Status</th>
                                <th>Documents</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($applicants as $applicant)
                                <tr>
                                    {{-- APPLICANT --}}
                                    <td>
                                        <div class="fw-semibold">{{ $applicant->full_name }}</div>
                                        <small class="text-muted">{{ $applicant->email }}</small>
                                    </td>

                                    {{-- AI SCORE --}}
                                    <td>
                                        @php
                                            $score = DB::table('hr_shortlists')
                                                ->where('applicant_id', $applicant->id)
                                                ->value('score');
                                        @endphp

                                        @if ($score !== null)
                                            <span class="badge bg-success-subtle text-success">
                                                {{ $score }}%
                                            </span>
                                        @else
                                            <span class="badge bg-secondary-subtle text-secondary">
                                                Not scored
                                            </span>
                                        @endif
                                    </td>

                                    {{-- STATUS --}}
                                    <td>
                                        @php
                                            $statusMap = [
                                                'applied' => 'secondary',
                                                'scored' => 'info',
                                                'shortlisted' => 'primary',
                                                'hired' => 'success',
                                                'rejected' => 'danger',
                                            ];
                                        @endphp
                                        <span class="badge bg-{{ $statusMap[$applicant->status] ?? 'secondary' }}">
                                            {{ ucfirst($applicant->status) }}
                                        </span>
                                    </td>

                                    {{-- DOCUMENTS --}}
                                    <td>
                                        @if ($applicant->cv_path)
                                            <a href="{{ asset('storage/' . $applicant->cv_path) }}" target="_blank"
                                                class="btn btn-sm btn-outline-primary">
                                                CV
                                            </a>
                                        @else
                                            <span class="badge bg-secondary-subtle text-secondary">No CV</span>
                                        @endif
                                        @if ($applicant->cover_letter_path)
                                            <a href="{{ asset('storage/' . $applicant->cover_letter_path) }}"
                                                target="_blank" class="btn btn-sm btn-outline-secondary">
                                                Cover
                                            </a>
                                        @endif
                                    </td>

                                    {{-- ACTIONS --}}
                                    <td class="text-end">
                                        <div class="d-inline-flex gap-1">

                                            {{-- AI SCORE --}}
                                            @if ($applicant->status === 'applied')
                                                @can('hr.ai.score')
                                                    <form method="POST"
                                                        action="{{ route('hr.applicants.score', $applicant->id) }}">
                                                        @csrf
                                                        <button class="btn btn-sm btn-outline-info">AI Score</button>
                                                    </form>
                                                @endcan
                                            @endif

                                            {{-- SHORTLIST --}}
                                            @if ($applicant->status === 'scored')
                                                @can('hr.applicants.hire')
                                                    <form method="POST"
                                                        action="{{ route('hr.applicants.shortlist', $applicant->id) }}">
                                                        @csrf
                                                        <button class="btn btn-sm btn-outline-primary">Shortlist</button>
                                                    </form>
                                                @endcan
                                            @endif

                                            {{-- HIRE --}}
                                            @if ($applicant->status === 'shortlisted')
                                                @can('hr.applicants.hire')
                                                    <form method="POST"
                                                        action="{{ route('hr.applicants.hire', $applicant->id) }}">
                                                        @csrf
                                                        <button class="btn btn-sm btn-outline-success">Hire</button>
                                                    </form>
                                                @endcan
                                            @endif

                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted">
                                        <i class="feather-inbox fs-3 d-block mb-2"></i>
                                        No applications received yet
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- ================= PERFORMANCE TABLE ================= --}}
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h6 class="fw-semibold mb-3">Pipeline Performance Summary</h6>

                <div class="table-responsive">
                    <table class="table table-bordered align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Stage</th>
                                <th class="text-end">Candidates</th>
                                <th class="text-end">Conversion %</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $pipeline = [
                                    'Applied' => $total,
                                    'Scored' => $scored,
                                    'Shortlisted' => $shortlisted,
                                    'Hired' => $hired,
                                ];
                                $prev = null;
                            @endphp

                            @foreach ($pipeline as $stage => $count)
                                @php
                                    $rate = $prev ? ($count / $prev) * 100 : 100;
                                    $prev = $count;
                                @endphp
                                <tr>
                                    <td>{{ $stage }}</td>
                                    <td class="text-end fw-semibold">{{ $count }}</td>
                                    <td class="text-end">
                                        <span
                                            class="badge bg-{{ $rate < 50 ? 'danger' : ($rate < 75 ? 'warning text-dark' : 'success') }}">
                                            {{ number_format($rate, 1) }}%
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

    </div>

    {{-- ================= STYLES ================= --}}
    <style>
        @media (max-width: 768px) {

            .hr-app-table th:nth-child(2),
            .hr-app-table td:nth-child(2),
            .hr-app-table th:nth-child(4),
            .hr-app-table td:nth-child(4) {
                display: none;
            }
        }
    </style>

    {{-- ================= CHART.JS ================= --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            new Chart(document.getElementById('pipelineChart'), {
                type: 'bar',
                data: {
                    labels: ['Applied', 'Scored', 'Shortlisted', 'Hired'],
                    datasets: [{
                        data: [
                            {{ $total }},
                            {{ $scored }},
                            {{ $shortlisted }},
                            {{ $hired }}
                        ],
                        backgroundColor: '#0d6efd'
                    }]
                },
                options: {
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

        });
    </script>
@endsection
