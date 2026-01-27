@extends('layouts.app')

@section('content')
    <div class="container">
        <h4>Procurement Audit Logs</h4>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Action</th>
                    <th>Procurement</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($logs as $log)
                    <tr>
                        <td>{{ $log->user_id }}</td>
                        <td>{{ $log->action }}</td>
                        <td>{{ $log->procurement_id }}</td>
                        <td>{{ $log->created_at }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $logs->links() }}
    </div>
@endsection
