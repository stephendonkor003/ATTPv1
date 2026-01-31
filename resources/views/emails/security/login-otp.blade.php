@extends('emails.layouts.base')

@section('content')
    <h2>Verify Your Identity</h2>

    <p>Hello <strong>{{ $user->name }}</strong>,</p>

    <p>
        We received a login request to your {{ config('app.name') }} account.
        To complete the sign-in process, please use the verification code below:
    </p>

    <div class="otp-box">
        <div class="otp-code">{{ $otpCode }}</div>
        <div class="otp-label">Your Verification Code</div>
    </div>

    <div class="alert alert-warning">
        <strong>Important:</strong> This code will expire in <strong>10 minutes</strong>.
        Do not share this code with anyone, including {{ config('app.name') }} staff.
    </div>

    <div class="divider"></div>

    <h3 style="color: #1a365d; font-size: 16px; margin-bottom: 15px;">Why am I receiving this?</h3>

    <div class="info-list">
        <ul>
            <li>Two-factor authentication helps protect your account from unauthorized access</li>
            <li>Even if someone knows your password, they can't access your account without this code</li>
            <li>This verification is required each time you log in from a new session</li>
        </ul>
    </div>

    <div class="alert alert-info">
        <strong>Security Tip:</strong> If you did not attempt to log in, please change your password immediately
        and contact support. Someone may have access to your credentials.
    </div>

    <p style="margin-top: 25px; color: #718096; font-size: 13px;">
        <strong>Request Details:</strong><br>
        Time: {{ now()->format('d M Y, H:i:s') }} UTC<br>
        IP Address: {{ request()->ip() }}
    </p>
@endsection
