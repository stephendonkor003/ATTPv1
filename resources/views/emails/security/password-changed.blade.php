@extends('emails.layouts.base')

@section('content')
    <h2>Password Changed Successfully</h2>

    <p>Hello <strong>{{ $user->name }}</strong>,</p>

    <p>
        Your {{ config('app.name') }} account password was successfully changed.
        Your account is now fully active and you can enjoy all platform features.
    </p>

    <div class="alert alert-success">
        <strong>Password Updated!</strong><br>
        Your new password is now active. Please use it for all future logins.
    </div>

    <div class="divider"></div>

    <h3 style="color: #1a365d; font-size: 16px; margin-bottom: 15px;">Password Policy Reminder</h3>

    <div class="info-list">
        <ul>
            <li>Your password will expire in <strong>60 days</strong> ({{ now()->addDays(60)->format('d M Y') }})</li>
            <li>You will be prompted to create a new password upon expiration</li>
            <li>For security, we recommend using unique passwords for each account</li>
            <li>Never share your password with anyone, including support staff</li>
        </ul>
    </div>

    <div class="alert alert-warning">
        <strong>Didn't make this change?</strong><br>
        If you did not change your password, your account may be compromised.
        Please contact support immediately at <a href="mailto:support@aubid.org">support@aubid.org</a>.
    </div>

    <p style="margin-top: 25px; color: #718096; font-size: 13px;">
        <strong>Change Details:</strong><br>
        Time: {{ now()->format('d M Y, H:i:s') }} UTC<br>
        IP Address: {{ request()->ip() }}
    </p>
@endsection
