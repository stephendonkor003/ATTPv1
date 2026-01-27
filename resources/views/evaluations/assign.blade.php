@extends('layouts.app')

@section('content')
    <div class="nxl-container">

        <div class="page-header mb-4">
            <h4 class="page-title">Evaluator Assignment</h4>
            <p class="text-muted">
                Procurement: <strong>{{ $procurement->title }}</strong>
            </p>
        </div>

        {{-- ASSIGN FORM --}}
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <form method="POST" action="{{ route('eval.assign.store') }}">
                    @csrf

                    <input type="hidden" name="procurement_id" value="{{ $procurement->id }}">

                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Evaluation</label>
                            <select name="evaluation_id" class="form-select" required>
                                <option value="">Select evaluation</option>
                                @foreach ($evaluations as $eval)
                                    <option value="{{ $eval->id }}">
                                        {{ $eval->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Evaluator</label>
                            <select name="user_id" class="form-select" required>
                                <option value="">Select evaluator</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">
                                        {{ $user->name }} ({{ $user->email }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4 align-self-end">
                            <button class="btn btn-primary w-100">
                                Assign Evaluator
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- ASSIGNED LIST --}}
        <div class="card shadow-sm">
            <table class="table table-bordered mb-0 align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Evaluator</th>
                        <th>Evaluation</th>
                        <th>Status</th>
                        <th>Assigned At</th>
                        <th width="260">Actions</th>
                    </tr>
                </thead>
                <tbody>

                    @forelse ($assignments as $a)
                        <tr>
                            <td>{{ $a->evaluator->name }}</td>
                            <td>{{ $a->evaluation->name }}</td>
                            <td>
                                @php
                                    $map = [
                                        'assigned' => 'secondary',
                                        'submitted' => 'success',
                                        'rework' => 'warning',
                                    ];
                                @endphp
                                <span class="badge bg-{{ $map[$a->status] ?? 'secondary' }}">
                                    {{ ucfirst($a->status) }}
                                </span>
                            </td>
                            <td>{{ $a->assigned_at?->format('d M Y') }}</td>
                            <td>
                                <div class="d-flex gap-2">

                                    {{-- Applicants --}}
                                    <a href="{{ route('eval.assign.applicants', $a->id) }}"
                                        class="btn btn-sm btn-outline-primary">
                                        Applicants
                                    </a>

                                    {{-- Compare --}}
                                    @if ($a->status === 'submitted')
                                        <a href="{{ route('eval.assign.compare', $a->id) }}"
                                            class="btn btn-sm btn-outline-success">
                                            Compare
                                        </a>
                                    @endif

                                    {{-- Remove --}}
                                    @if ($a->status !== 'submitted')
                                        <form method="POST" action="{{ route('eval.assign.destroy', $a) }}"
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
                            <td colspan="5" class="text-center text-muted">
                                No evaluators assigned
                            </td>
                        </tr>
                    @endforelse

                </tbody>
            </table>
        </div>

    </div>
@endsection
