@extends('layouts.app')

@section('content')
    <div class="nxl-container">

        <div class="page-header mb-4 d-flex justify-content-between align-items-center">
            <div>
                <h4 class="fw-bold mb-1">Procurement Evaluation Report</h4>
                <p class="text-muted mb-0">{{ $procurement->title }} ({{ $procurement->reference_no ?? 'N/A' }})</p>
            </div>
            <a href="{{ route('reports.evaluations.index') }}" class="btn btn-outline-secondary btn-sm">
                Back to Reports
            </a>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="text-muted">Total Evaluations</div>
                        <div class="h4 mb-0">{{ $summary['total'] }}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="text-muted">Evaluators</div>
                        <div class="h4 mb-0">{{ $summary['evaluators'] }}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="text-muted">Average Overall</div>
                        <div class="h4 mb-0">{{ number_format($summary['avg_overall'], 2) }}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 text-end">
                <a href="{{ route('reports.evaluations.procurement.pdf', $procurement) }}" class="btn btn-success">
                    Download PDF
                </a>
            </div>
        </div>

        <div class="card shadow-sm mb-4">
            <div class="card-header bg-light fw-semibold">Evaluator Breakdown</div>
            <div class="card-body">
                <table class="table table-sm table-bordered">
                    <thead>
                        <tr>
                            <th>Evaluator</th>
                            <th>Total Evaluations</th>
                            <th>Average Overall</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($evaluatorBreakdown as $name => $data)
                            <tr>
                                <td>{{ $name }}</td>
                                <td>{{ $data['total'] }}</td>
                                <td>{{ number_format($data['avg_overall'], 2) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3">No evaluations submitted yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @foreach ($evaluationStats as $stat)
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <span>{{ $stat['evaluation']->name }}</span>
                    <span class="badge bg-light text-dark">{{ strtoupper($stat['type']) }}</span>
                </div>
                <div class="card-body">
                    <div class="row g-3 mb-3">
                        <div class="col-md-3">
                            <div class="text-muted">Total Evaluations</div>
                            <div class="fw-semibold">{{ $stat['total'] }}</div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-muted">Average Overall</div>
                            <div class="fw-semibold">{{ number_format($stat['avg_overall'], 2) }}</div>
                        </div>
                    </div>

                    <table class="table table-sm table-bordered">
                        <thead>
                            <tr>
                                <th>Criteria</th>
                                @if ($stat['type'] === 'goods')
                                    <th>Yes</th>
                                    <th>No</th>
                                    <th>Pass Rate</th>
                                @else
                                    <th>Max</th>
                                    <th>Average Score</th>
                                    <th>Samples</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($stat['criteria_stats'] as $criteria)
                                <tr>
                                    <td>{{ $criteria['name'] }}</td>
                                    @if ($stat['type'] === 'goods')
                                        <td>{{ $criteria['yes'] }}</td>
                                        <td>{{ $criteria['no'] }}</td>
                                        <td>{{ $criteria['rate'] }}%</td>
                                    @else
                                        <td>{{ $criteria['max'] }}</td>
                                        <td>{{ number_format($criteria['avg'], 2) }}</td>
                                        <td>{{ $criteria['total'] }}</td>
                                    @endif
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4">No criteria data available.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        @endforeach

        <div class="card shadow-sm">
            <div class="card-header bg-light fw-semibold">Submitted Evaluations</div>
            <div class="card-body">
                <table class="table table-sm table-bordered">
                    <thead>
                        <tr>
                            <th>Submission Code</th>
                            <th>Applicant</th>
                            <th>Evaluation</th>
                            <th>Evaluator</th>
                            <th>Overall Score</th>
                            <th>Submitted At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($submissions as $submission)
                            <tr>
                                <td>{{ $submission->applicant?->procurement_submission_code ?? 'N/A' }}</td>
                                <td>{{ $submission->applicant?->submitter?->name ?? 'N/A' }}</td>
                                <td>{{ $submission->evaluation?->name ?? 'N/A' }}</td>
                                <td>{{ $submission->evaluator?->name ?? 'N/A' }}</td>
                                <td>{{ number_format($submission->overall_score ?? 0, 2) }}</td>
                                <td>{{ $submission->submitted_at?->format('d M Y, H:i') ?? 'N/A' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">No evaluations submitted yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
