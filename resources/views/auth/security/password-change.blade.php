<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password - {{ config('app.name') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.css" rel="stylesheet">
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
            max-width: 520px;
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

        .auth-header h1 {
            font-size: 24px;
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

        .info-card {
            background: #f8fafc;
            border-left: 4px solid var(--accent-color);
            border-radius: 8px;
            padding: 16px 20px;
            margin-bottom: 25px;
        }

        .info-card.warning {
            border-left-color: #f59e0b;
            background: #fffbeb;
        }

        .info-card.expired {
            border-left-color: #ef4444;
            background: #fef2f2;
        }

        .info-card h5 {
            font-size: 14px;
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 8px;
        }

        .info-card p {
            font-size: 13px;
            color: #64748b;
            margin: 0;
        }

        .form-label {
            font-weight: 600;
            color: var(--primary-color);
            font-size: 14px;
            margin-bottom: 6px;
        }

        .form-control {
            padding: 12px 16px;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            font-size: 15px;
        }

        .form-control:focus {
            border-color: var(--accent-color);
            box-shadow: 0 0 0 3px rgba(49, 130, 206, 0.1);
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

        .password-rules {
            background: #f1f5f9;
            border-radius: 8px;
            padding: 16px;
            margin-top: 20px;
        }

        .password-rules h6 {
            font-size: 13px;
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 10px;
        }

        .password-rules ul {
            margin: 0;
            padding-left: 18px;
        }

        .password-rules li {
            font-size: 12px;
            color: #64748b;
            margin-bottom: 4px;
        }

        .security-tips {
            background: #eff6ff;
            border-radius: 8px;
            padding: 16px;
            margin-top: 20px;
        }

        .security-tips h6 {
            font-size: 13px;
            font-weight: 600;
            color: #1e40af;
            margin-bottom: 10px;
        }

        .security-tips ul {
            margin: 0;
            padding-left: 18px;
        }

        .security-tips li {
            font-size: 12px;
            color: #3b82f6;
            margin-bottom: 4px;
        }

        .input-group-text {
            background: #f8fafc;
            border-color: #e2e8f0;
            cursor: pointer;
        }

        .invalid-feedback {
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-header">
                <h1>
                    <i data-feather="lock" style="width: 28px; height: 28px; margin-right: 8px;"></i>
                    Update Your Password
                </h1>
                <p>{{ config('app.name') }} - Secure Access</p>
            </div>

            <div class="auth-body">
                {{-- Reason Message --}}
                @if ($reason === 'first_login')
                    <div class="info-card">
                        <h5><i data-feather="user-check" style="width: 16px; height: 16px; margin-right: 6px;"></i> Welcome to {{ config('app.name') }}!</h5>
                        <p>{{ $message }}</p>
                    </div>
                @elseif ($reason === 'expired')
                    <div class="info-card expired">
                        <h5><i data-feather="alert-triangle" style="width: 16px; height: 16px; margin-right: 6px;"></i> Password Expired</h5>
                        <p>{{ $message }}</p>
                    </div>
                @else
                    <div class="info-card warning">
                        <h5><i data-feather="shield" style="width: 16px; height: 16px; margin-right: 6px;"></i> Security Update Required</h5>
                        <p>{{ $message }}</p>
                    </div>
                @endif

                {{-- Alerts --}}
                @if (session('warning'))
                    <div class="alert alert-warning">{{ session('warning') }}</div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('security.password.submit') }}">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Current Password</label>
                        <div class="input-group">
                            <input type="password" name="current_password" class="form-control @error('current_password') is-invalid @enderror"
                                placeholder="Enter your current password" required>
                            <span class="input-group-text toggle-password">
                                <i data-feather="eye" style="width: 18px; height: 18px;"></i>
                            </span>
                        </div>
                        @error('current_password')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">New Password</label>
                        <div class="input-group">
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                                placeholder="Create a strong password" required>
                            <span class="input-group-text toggle-password">
                                <i data-feather="eye" style="width: 18px; height: 18px;"></i>
                            </span>
                        </div>
                        @error('password')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Confirm New Password</label>
                        <div class="input-group">
                            <input type="password" name="password_confirmation" class="form-control"
                                placeholder="Re-enter your new password" required>
                            <span class="input-group-text toggle-password">
                                <i data-feather="eye" style="width: 18px; height: 18px;"></i>
                            </span>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i data-feather="check-circle" style="width: 18px; height: 18px; margin-right: 8px;"></i>
                        Update Password & Continue
                    </button>
                </form>

                <div class="password-rules">
                    <h6><i data-feather="info" style="width: 14px; height: 14px; margin-right: 4px;"></i> Password Requirements</h6>
                    <ul>
                        <li>At least 8 characters long</li>
                        <li>Contains uppercase and lowercase letters</li>
                        <li>Contains at least one number</li>
                        <li>Contains at least one special character (!@#$%^&*)</li>
                        <li>Cannot be a commonly used or compromised password</li>
                    </ul>
                </div>

                <div class="security-tips">
                    <h6><i data-feather="shield" style="width: 14px; height: 14px; margin-right: 4px;"></i> Why Password Expiration?</h6>
                    <ul>
                        <li>Regular password changes reduce the risk of unauthorized access</li>
                        <li>Passwords are required to be changed every 60 days</li>
                        <li>This protects your account even if credentials are compromised</li>
                        <li>Strong, unique passwords are your first line of defense</li>
                    </ul>
                </div>

                {{-- Logout Option --}}
                <div style="text-align: center; margin-top: 25px; padding-top: 20px; border-top: 1px solid #e2e8f0;">
                    <p style="font-size: 13px; color: #64748b; margin-bottom: 10px;">Not you? Or want to try a different account?</p>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-outline-secondary btn-sm" style="border-radius: 6px; padding: 8px 20px;">
                            <i data-feather="log-out" style="width: 14px; height: 14px; margin-right: 6px;"></i>
                            Sign Out
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
    <script>
        feather.replace();

        // Toggle password visibility
        document.querySelectorAll('.toggle-password').forEach(toggle => {
            toggle.addEventListener('click', function() {
                const input = this.parentElement.querySelector('input');
                const icon = this.querySelector('svg');

                if (input.type === 'password') {
                    input.type = 'text';
                    icon.outerHTML = '<i data-feather="eye-off" style="width: 18px; height: 18px;"></i>';
                } else {
                    input.type = 'password';
                    icon.outerHTML = '<i data-feather="eye" style="width: 18px; height: 18px;"></i>';
                }
                feather.replace();
            });
        });
    </script>
</body>
</html>
