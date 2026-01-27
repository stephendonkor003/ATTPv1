@extends('layouts.app')

@section('content')
    <div class="nxl-container">

        {{-- HEADER --}}
        <div class="page-header mb-4">
            <h4 class="page-title">Evaluator Assignment</h4>
            <p class="text-muted">
                Assign evaluators to procurements and manage evaluation workflow.
            </p>
        </div>

        <div class="accordion" id="procurementAccordion">

            @foreach ($procurements as $procurement)
                <div class="accordion-item mb-2">

                    {{-- ACCORDION HEADER --}}
                    <h2 class="accordion-header" id="heading{{ $procurement->id }}">
                        <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapse{{ $procurement->id }}">
                            {{ $procurement->title }}
                        </button>
                    </h2>

                    {{-- ACCORDION BODY --}}
                    <div id="collapse{{ $procurement->id }}" class="accordion-collapse collapse"
                        data-bs-parent="#procurementAccordion">

                        <div class="accordion-body">

                            {{-- ASSIGN FORM --}}
                            <form method="POST" action="{{ route('eval.assign.store') }}" class="row g-2 mb-3">
                                @csrf

                                <input type="hidden" name="procurement_id" value="{{ $procurement->id }}">

                                <div class="col-md-4">
                                    <select name="evaluation_id" class="form-select" required>
                                        <option value="">Select Evaluation</option>
                                        @foreach ($evaluations as $eval)
                                            <option value="{{ $eval->id }}">
                                                {{ $eval->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <select name="user_id" class="form-select" required>
                                        <option value="">Select Evaluator</option>
                                        @foreach ($evaluators as $user)
                                            <option value="{{ $user->id }}">
                                                {{ $user->name }} ({{ $user->email }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <button class="btn btn-primary w-100">
                                        Assign Evaluator
                                    </button>
                                </div>
                            </form>

                            {{-- ASSIGNED EVALUATORS --}}
                            <table class="table table-sm table-bordered align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Evaluator</th>
                                        <th>Evaluation</th>
                                        <th>Status</th>
                                        <th width="240">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @forelse ($procurement->evaluationAssignments as $assign)
                                        <tr>
                                            <td>{{ $assign->evaluator->name }}</td>
                                            <td>{{ $assign->evaluation->name }}</td>
                                            <td>
                                                @php
                                                    $statusMap = [
                                                        'assigned' => 'secondary',
                                                        'submitted' => 'success',
                                                        'rework' => 'warning',
                                                    ];
                                                @endphp

                                                <span class="badge bg-{{ $statusMap[$assign->status] ?? 'secondary' }}">
                                                    {{ ucfirst($assign->status) }}
                                                </span>
                                            </td>

                                            <td>
                                                <div class="d-flex gap-2">

                                                    {{-- View Applicants --}}
                                                    <a href="{{ route('eval.assign.applicants', $assign->id) }}"
                                                        class="btn btn-sm btn-outline-primary">
                                                        Applicants
                                                    </a>

                                                    {{-- Panel Comparison --}}
                                                    @if ($assign->status === 'submitted')
                                                        <a href="{{ route('eval.assign.compare', $assign->id) }}"
                                                            class="btn btn-sm btn-outline-success">
                                                            Compare
                                                        </a>
                                                    @endif

                                                    {{-- Remove (only if NOT submitted) --}}
                                                    @if ($assign->status !== 'submitted')
                                                        <form method="POST"
                                                            action="{{ route('eval.assign.destroy', $assign) }}"
                                                            onsubmit="return confirm('Remove evaluator?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button class="btn btn-sm btn-outline-danger">
                                                                Remove
                                                            </button>
                                                        </form>
                                                    @endif

                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center text-muted">
                                                No evaluators assigned
                                            </td>
                                        </tr>
                                    @endforelse

                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            @endforeach

        </div>

    </div>
@endsection
