<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>AU Bid Portal - Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('assets/img/favicon.ico') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('assets/css/login.css') }}">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: url('assets/img/au_building.jpg') no-repeat center center fixed;
            background-size: cover;
            position: relative;
            height: 100vh;
        }

        /* Dark overlay layer */
        body::before {
            content: '';
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.4);
            /* Adjust opacity as needed */
            z-index: 0;
        }

        .login-container {
            position: relative;
            z-index: 1;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-box {
            background: rgba(255, 255, 255, 0.95);
            padding: 40px;
            border-radius: 12px;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.25);
        }

        .logo-container {
            text-align: center;
            margin-bottom: 25px;
        }

        .logo-container img {
            height: 80px;
        }

        /* ... rest of the form styles stay the same ... */


        .form-group {
            margin-bottom: 18px;
        }

        label {
            display: block;
            margin-bottom: 6px;
            color: #333;
            font-weight: 500;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #ccc;
            border-radius: 6px;
            box-sizing: border-box;
            font-size: 14px;
        }

        input[type="email"]:focus,
        input[type="password"]:focus {
            border-color: #5e2a09;
            outline: none;
            box-shadow: 0 0 4px #007BFF44;
        }

        .checkbox-group {
            display: flex;
            align-items: center;
            font-size: 14px;
            color: #333;
        }

        .checkbox-group input {
            margin-right: 8px;
        }

        .actions {
            margin-top: 20px;
        }

        button[type="submit"] {
            width: 100%;
            padding: 12px;
            background-color: #5e2a09;
            border: none;
            color: white;
            font-weight: bold;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
            transition: background 0.3s ease;
        }

        button[type="submit"]:hover {
            background-color: #5e2a09;
        }

        .form-footer {
            text-align: right;
            margin-top: 12px;
        }

        .form-footer a {
            color: #007BFF;
            text-decoration: none;
            font-size: 14px;
        }

        .form-footer a:hover {
            text-decoration: underline;
        }

        .error {
            display: block;
            color: red;
            font-size: 13px;
            margin-top: 5px;
        }

        .alert.success {
            background: #e0f8e0;
            color: #2d7a2d;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
            font-size: 14px;
        }

        .back-link {
            text-align: right;
            margin-bottom: 10px;
        }

        .back-link a {
            text-decoration: none;
            font-size: 14px;
            color: #5e2a09;
            font-weight: 500;
            transition: color 0.2s ease;
        }

        .back-link a:hover {
            color: #0056b3;
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="login-box">
            <div class="back-link">
                <a href="{{ route('landing.index') }}">← Back to Homepage</a>
            </div>

            <div class="logo-container">
                <img src="{{ asset('assets/img/au.png') }}" alt="AU Logo">
            </div>

            <!-- Session Status -->
            @if (session('status'))
                <div class="alert success">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
                    @error('email')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input id="password" type="password" name="password" required>
                    @error('password')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group checkbox-group">
                    <label>
                        <input type="checkbox" name="remember"> Remember me
                    </label>
                </div>

                <div class="form-group actions">
                    <button type="submit">Log In</button>
                </div>

                {{-- @if (Route::has('password.request'))
                    <div class="form-footer">
                        <a href="{{ route('password.request') }}">Forgot your password?</a>
                    </div>
                @endif --}}
            </form>
        </div>
    </div>
</body>

</html>
