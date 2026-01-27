@extends('layouts.app')

@section('content')
    <div class="nxl-container">

        <div class="page-header mb-4">
            <h4 class="fw-bold">Assign Prescreening Users</h4>
            <p class="text-muted mb-0">
                Procurement: <strong>{{ $procurement->title }}</strong>
            </p>
        </div>

        <form method="POST" action="{{ route('prescreening.assignments.store', $procurement) }}">
            @csrf

            <div class="card shadow-sm">
                <div class="card-body">

                    <div class="row">
                        @foreach ($users as $user)
                            <div class="col-md-4 mb-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="users[]"
                                        value="{{ $user->id }}" @checked($procurement->prescreeningUsers->contains($user->id))>

                                    <label class="form-check-label">
                                        {{ $user->name }}
                                        <small class="text-muted">
                                            ({{ $user->email }})
                                        </small>
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>

                </div>

                <div class="card-footer text-end">
                    <button class="btn btn-success">
                        Save Assignments
                    </button>
                </div>
            </div>
        </form>

    </div>
@endsection
