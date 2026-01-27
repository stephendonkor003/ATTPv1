<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Change Your Password</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        html,
        body {
            height: 100%;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-image: url('{{ asset('assets/img/au_building.jpg') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            position: relative;
        }

        body::before {
            content: "";
            position: absolute;
            inset: 0;
            background-color: rgba(0, 0, 0, 0.6);
            /* Overlay for readability */
            z-index: 0;
        }

        .container {
            position: relative;
            z-index: 1;
            max-width: 460px;
            margin: 80px auto;
            padding: 30px 40px;
            background-color: rgba(255, 255, 255, 0.97);
            border-radius: 10px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.3);
        }

        h4 {
            text-align: center;
            margin-bottom: 25px;
            color: #007144;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
        }

        .form-control {
            width: 100%;
            padding: 12px 14px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 15px;
        }

        .form-control:focus {
            border-color: #007144;
            outline: none;
        }

        .btn {
            background-color: #007144;
            color: #fff;
            border: none;
            padding: 12px 20px;
            font-size: 16px;
            border-radius: 6px;
            width: 100%;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #005c37;
        }

        .alert {
            padding: 10px 15px;
            background-color: #ffdddd;
            color: #a70000;
            border-left: 4px solid #e70000;
            margin-bottom: 20px;
            border-radius: 6px;
        }

        @media (max-width: 500px) {
            .container {
                padding: 25px 20px;
                margin: 50px 15px;
            }
        }
    </style>
</head>

<body>

    <div class="container">
        <h4>Change Your Password</h4>

        @if ($errors->any())
            <div class="alert">
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('password.change.update') }}" method="POST">
            @csrf

            <label for="password">New Password</label>
            <input type="password" name="password" id="password" class="form-control" required>

            <label for="password_confirmation">Confirm New Password</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control"
                required>

            <button type="submit" class="btn">Change Password</button>
        </form>
    </div>

</body>

</html>
