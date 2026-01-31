<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Your Identity - {{ config('app.name') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #1a365d;
            --secondary-color: #2d4a7c;
            --accent-color: #3182ce;
        }

        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #f0f4f8 0%, #d9e2ec 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .auth-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .auth-card {
            width: 100%;
            max-width: 480px;
            background: white;
            border-radius: 16px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .auth-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }

        .auth-header .icon-circle {
            width: 70px;
            height: 70px;
            background: rgba(255, 255, 255, 0.15);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
        }

        .auth-header h1 {
            font-size: 22px;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .auth-header p {
            font-size: 14px;
            opacity: 0.9;
            margin: 0;
        }

        .auth-body {
            padding: 35px;
        }

        .user-info {
            background: #f8fafc;
            border-radius: 10px;
            padding: 16px;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .user-avatar {
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 18px;
        }

        .user-details h5 {
            font-size: 15px;
            font-weight: 600;
            color: var(--primary-color);
            margin: 0;
        }

        .user-details p {
            font-size: 13px;
            color: #64748b;
            margin: 0;
        }

        .otp-sent-info {
            background: #ecfdf5;
            border: 1px solid #a7f3d0;
            border-radius: 10px;
            padding: 16px;
            margin-bottom: 25px;
            text-align: center;
        }

        .otp-sent-info .icon {
            color: #10b981;
            margin-bottom: 8px;
        }

        .otp-sent-info p {
            font-size: 14px;
            color: #065f46;
            margin: 0;
        }

        .otp-input-container {
            display: flex;
            gap: 10px;
            justify-content: center;
            margin-bottom: 25px;
        }

        .otp-input {
            width: 50px;
            height: 60px;
            text-align: center;
            font-size: 24px;
            font-weight: 600;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            transition: all 0.2s;
        }

        .otp-input:focus {
            border-color: var(--accent-color);
            box-shadow: 0 0 0 3px rgba(49, 130, 206, 0.15);
            outline: none;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            border: none;
            padding: 14px 28px;
            font-weight: 600;
            border-radius: 8px;
            width: 100%;
        }

        .btn-primary:hover {
            opacity: 0.95;
            transform: translateY(-1px);
        }

        .resend-section {
            text-align: center;
            margin-top: 25px;
            padding-top: 20px;
            border-top: 1px solid #e2e8f0;
        }

        .resend-section p {
            font-size: 14px;
            color: #64748b;
            margin-bottom: 10px;
        }

        .countdown {
            font-weight: 600;
            color: var(--primary-color);
        }

        .security-info {
            background: #eff6ff;
            border-radius: 10px;
            padding: 16px;
            margin-top: 25px;
        }

        .security-info h6 {
            font-size: 13px;
            font-weight: 600;
            color: #1e40af;
            margin-bottom: 10px;
        }

        .security-info ul {
            margin: 0;
            padding-left: 18px;
        }

        .security-info li {
            font-size: 12px;
            color: #3b82f6;
            margin-bottom: 4px;
        }

        .alert {
            border-radius: 8px;
            font-size: 14px;
        }

        /* Hidden real input */
        #otp_code {
            position: absolute;
            opacity: 0;
            pointer-events: none;
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-header">
                <div class="icon-circle">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                        <polyline points="22,6 12,13 2,6"></polyline>
                    </svg>
                </div>
                <h1>Verify Your Identity</h1>
                <p>Two-Factor Authentication</p>
            </div>

            <div class="auth-body">
                {{-- User Info --}}
                <div class="user-info">
                    <div class="user-avatar">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <div class="user-details">
                        <h5>{{ $user->name }}</h5>
                        <p>{{ $user->email }}</p>
                    </div>
                </div>

                {{-- OTP Sent Notification --}}
                @if ($otpSent)
                    <div class="otp-sent-info">
                        <div class="icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                <polyline points="22 4 12 14.01 9 11.01"></polyline>
                            </svg>
                        </div>
                        <p>A 6-digit verification code has been sent to your email</p>
                    </div>
                @endif

                {{-- Alerts --}}
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if (session('warning'))
                    <div class="alert alert-warning">{{ session('warning') }}</div>
                @endif

                @if (session('info'))
                    <div class="alert alert-info">{{ session('info') }}</div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                <p class="text-center text-muted mb-3">Enter the 6-digit code from your email</p>

                <form method="POST" action="{{ route('security.otp.verify') }}" id="otpForm">
                    @csrf

                    {{-- Visual OTP Inputs --}}
                    <div class="otp-input-container">
                        <input type="text" class="otp-input" maxlength="1" data-index="0" inputmode="numeric" pattern="[0-9]">
                        <input type="text" class="otp-input" maxlength="1" data-index="1" inputmode="numeric" pattern="[0-9]">
                        <input type="text" class="otp-input" maxlength="1" data-index="2" inputmode="numeric" pattern="[0-9]">
                        <input type="text" class="otp-input" maxlength="1" data-index="3" inputmode="numeric" pattern="[0-9]">
                        <input type="text" class="otp-input" maxlength="1" data-index="4" inputmode="numeric" pattern="[0-9]">
                        <input type="text" class="otp-input" maxlength="1" data-index="5" inputmode="numeric" pattern="[0-9]">
                    </div>

                    {{-- Hidden real input --}}
                    <input type="hidden" name="otp_code" id="otp_code">

                    <button type="submit" class="btn btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 8px;">
                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                            <polyline points="22 4 12 14.01 9 11.01"></polyline>
                        </svg>
                        Verify & Continue
                    </button>
                </form>

                {{-- Resend Section --}}
                <div class="resend-section">
                    <p>Didn't receive the code?</p>
                    <form method="POST" action="{{ route('security.otp.resend') }}" id="resendForm">
                        @csrf
                        <button type="submit" class="btn btn-link p-0" id="resendBtn">
                            Resend Code
                        </button>
                        <span id="countdown" style="display: none;"></span>
                    </form>
                </div>

                {{-- Security Info --}}
                <div class="security-info">
                    <h6>
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 4px;">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                        </svg>
                        Why Two-Factor Authentication?
                    </h6>
                    <ul>
                        <li>Adds an extra layer of security beyond your password</li>
                        <li>Protects your account even if your password is compromised</li>
                        <li>Verification codes expire after 10 minutes</li>
                        <li>Never share your verification code with anyone</li>
                    </ul>
                </div>

                {{-- Logout Option --}}
                <div class="logout-section" style="text-align: center; margin-top: 25px; padding-top: 20px; border-top: 1px solid #e2e8f0;">
                    <p style="font-size: 13px; color: #64748b; margin-bottom: 10px;">Not you? Or want to try a different account?</p>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-outline-secondary btn-sm" style="border-radius: 6px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 6px;">
                                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                <polyline points="16 17 21 12 16 7"></polyline>
                                <line x1="21" y1="12" x2="9" y2="12"></line>
                            </svg>
                            Sign Out
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const otpInputs = document.querySelectorAll('.otp-input');
            const hiddenInput = document.getElementById('otp_code');
            const form = document.getElementById('otpForm');

            // Auto-focus first input
            otpInputs[0].focus();

            // Handle input
            otpInputs.forEach((input, index) => {
                input.addEventListener('input', function(e) {
                    // Only allow numbers
                    this.value = this.value.replace(/[^0-9]/g, '');

                    if (this.value.length === 1) {
                        // Move to next input
                        if (index < otpInputs.length - 1) {
                            otpInputs[index + 1].focus();
                        }
                    }

                    // Update hidden input
                    updateHiddenInput();
                });

                input.addEventListener('keydown', function(e) {
                    // Handle backspace
                    if (e.key === 'Backspace' && !this.value && index > 0) {
                        otpInputs[index - 1].focus();
                    }

                    // Handle paste
                    if (e.key === 'v' && (e.ctrlKey || e.metaKey)) {
                        e.preventDefault();
                        navigator.clipboard.readText().then(text => {
                            const digits = text.replace(/[^0-9]/g, '').slice(0, 6);
                            digits.split('').forEach((digit, i) => {
                                if (otpInputs[i]) {
                                    otpInputs[i].value = digit;
                                }
                            });
                            updateHiddenInput();
                            if (digits.length === 6) {
                                otpInputs[5].focus();
                            }
                        });
                    }
                });

                // Handle paste on any input
                input.addEventListener('paste', function(e) {
                    e.preventDefault();
                    const text = (e.clipboardData || window.clipboardData).getData('text');
                    const digits = text.replace(/[^0-9]/g, '').slice(0, 6);
                    digits.split('').forEach((digit, i) => {
                        if (otpInputs[i]) {
                            otpInputs[i].value = digit;
                        }
                    });
                    updateHiddenInput();
                    if (digits.length === 6) {
                        otpInputs[5].focus();
                    }
                });
            });

            function updateHiddenInput() {
                let otp = '';
                otpInputs.forEach(input => {
                    otp += input.value;
                });
                hiddenInput.value = otp;
            }

            // Countdown for resend button
            let countdown = 60;
            const resendBtn = document.getElementById('resendBtn');
            const countdownSpan = document.getElementById('countdown');

            function startCountdown() {
                resendBtn.style.display = 'none';
                countdownSpan.style.display = 'inline';
                countdownSpan.classList.add('countdown');

                const timer = setInterval(() => {
                    countdown--;
                    countdownSpan.textContent = `Resend available in ${countdown}s`;

                    if (countdown <= 0) {
                        clearInterval(timer);
                        resendBtn.style.display = 'inline';
                        countdownSpan.style.display = 'none';
                        countdown = 60;
                    }
                }, 1000);
            }

            // Start countdown on page load if OTP was just sent
            @if ($otpSent)
                startCountdown();
            @endif
        });
    </script>
</body>
</html>
