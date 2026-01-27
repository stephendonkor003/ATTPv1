<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Password Changed</title>
</head>

<body style="font-family: Arial, sans-serif; background-color: #f9f9f9; padding: 30px;">
    <div
        style="max-width: 600px; margin: auto; background-color: white; padding: 25px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.05);">
        <h2 style="color: #007144;">Password Change Notification</h2>
        <p>Dear {{ $user->name }},</p>

        <p>This is to notify you that your account password was successfully changed on
            <strong>{{ $changedAt }}</strong>.
        </p>

        <p><strong>New Password:</strong> {{ $password }}</p>

        <p>If you did not initiate this change, please contact our support team immediately.</p>

        <br>
        <p>Thank you,<br>
            <strong>Africa Think Tank Platform Team</strong>
        </p>
    </div>
</body>

</html>
