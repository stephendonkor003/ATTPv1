<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Welcome Onboard</title>
</head>

<body style="font-family: Arial, sans-serif; background:#f5f6fa; padding:20px;">
    <div style="max-width:600px; margin:auto; background:#ffffff; padding:25px; border-radius:8px;">

        <h2 style="color:#2c3e50;">🎉 Congratulations {{ $name }}!</h2>

        <p>
            We are pleased to inform you that you have been <strong>successfully hired</strong>.
            Welcome to the team!
        </p>

        <p><strong>Your login details:</strong></p>

        <table style="width:100%; border-collapse:collapse;">
            <tr>
                <td style="padding:8px; border:1px solid #ddd;">Email</td>
                <td style="padding:8px; border:1px solid #ddd;">{{ $email }}</td>
            </tr>
            <tr>
                <td style="padding:8px; border:1px solid #ddd;">Password</td>
                <td style="padding:8px; border:1px solid #ddd;">{{ $password }}</td>
            </tr>
            <tr>
                <td style="padding:8px; border:1px solid #ddd;">User Type</td>
                <td style="padding:8px; border:1px solid #ddd;">{{ $userType }}</td>
            </tr>
        </table>

        <p style="margin-top:15px;">
            ⚠️ For security reasons, you will be required to change your password upon first login.
        </p>

        <p>
            If you have any questions, please contact HR.
        </p>

        <p style="margin-top:25px;">
            <strong>Human Resource Department</strong>
        </p>
    </div>
</body>

</html>
