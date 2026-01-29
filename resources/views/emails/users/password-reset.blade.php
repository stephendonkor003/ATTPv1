<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Password Reset</title>
</head>

<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 40px;">
    <div
        style="max-width: 650px; margin: auto; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">

        <div style="background-color: #007144; padding: 20px; text-align: center; color: white;">
            <h2>Your Password Has Been Reset</h2>
        </div>

        <div style="padding: 30px; color: #333;">
            <p>Dear {{ $user->name }},</p>

            <p>Your account password has been reset by an administrator.</p>

            <div style="margin-top: 30px; padding: 20px; background-color: #f0f9f5; border-left: 4px solid #007144;">
                <h4 style="margin-top: 0;">Your New Login Credentials</h4>
                <p><strong>Email:</strong> {{ $user->email }}</p>
                <p><strong>Password:</strong> {{ $plainPassword }}</p>
                <p><em>Please change this password after logging in.</em></p>
            </div>

            <p style="margin-top: 30px;">Log in here:
                <a href="https://uat.africathinktankplatform.africa/login" style="color: #007144;">
                    Access Your Account
                </a>
            </p>

            <p>If you have any questions, contact:
                <a href="mailto:attpinfo@africanunion.org" style="color: #007144;">attpinfo@africanunion.org</a>.
            </p>

            <p style="margin-top: 30px;">Best regards,<br>
                <strong>ATTP Secretariat</strong>
            </p>
        </div>

        <div style="background-color: #007144; color: white; text-align: center; padding: 15px;">
            Africa Think Tank Platform - African Union Commission
        </div>
    </div>
</body>

</html>
