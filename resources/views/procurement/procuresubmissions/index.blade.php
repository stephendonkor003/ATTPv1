@extends('layouts.app')

@section('content')
    <div class="nxl-container">

        <div class="page-header d-flex justify-content-between align-items-center">
            <h4 class="fw-bold">Procurement Submissions</h4>
        </div>

        <div class="card shadow-sm mt-3">
            <div class="card-body">

                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Submission Code</th>
                            <th>Procurement</th>
                            <th>Form</th>
                            <th>Status</th>
                            <th>Submitted At</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($submissions as $submission)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <span class="fw-semibold text-primary">
                                        {{ $submission->procurement_submission_code }}
                                    </span>
                                </td>

                                <td>{{ $submission->procurement->title }}</td>
                                <td>{{ $submission->form->name }}</td>
                                <td>
                                    <span class="badge bg-primary">
                                        {{ ucfirst($submission->status) }}
                                    </span>
                                </td>
                                <td>{{ $submission->submitted_at?->format('d M Y, H:i') }}</td>
                                <td class="text-end">
                                    <a href="{{ route('procurement.submissions.show', $submission) }}"
                                        class="btn btn-sm btn-outline-primary">
                                        View
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">
                                    No submissions found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                {{ $submissions->links() }}

            </div>
        </div>

    </div>
@endsection
