<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Application Received</title>
</head>

<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 40px;">
    <div
        style="max-width: 650px; margin: auto; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">

        <!-- Header -->
        <div style="background-color: #007144; padding: 20px; text-align: center; color: white;">
            <h2>Thank You for Your Submission</h2>
        </div>

        <!-- Body Content -->
        <div style="padding: 30px; color: #333;">
            <p>Dear {{ $applicant->think_tank_name }},</p>

            <p>Thank you for submitting your proposal for the <strong>Africa Think Tank Platform</strong>. We appreciate
                your interest in contributing to policy research on continental priority issues announced in the call
                for proposals.</p>

            <p>This email serves as confirmation that we have received your submission.</p>

            <p><strong>Please note:</strong> You are free to make edits or updates to your proposal before the closing
                date of <strong>Friday, 22 August 2025</strong>. If you wish to make changes, use the following
                link:<br>
                <a href="https://africathinktankplatform.africa/login" style="color: #007144;">Access Your Account
                    Here</a>
            </p>

            <p>If you have any questions or need assistance, feel free to contact us at <a
                    href="mailto:attpinfo@africanunion.org" style="color: #007144;">attpinfo@africanunion.org</a>.</p>

            <!-- Login Info -->
            <div style="margin-top: 30px; padding: 20px; background-color: #f0f9f5; border-left: 4px solid #007144;">
                <h4 style="margin-top: 0;">🟢 Your Account Credentials</h4>
                <p><strong>Login Code:</strong> {{ $loginCode }}</p>
                <p><strong>Email:</strong> {{ $applicant->email }}</p>
                <p><strong>Temporary Password:</strong> {{ $defaultPassword }}</p>
                <p style="margin-top: 10px;"><em>Please log in using the above credentials. You will be required to
                        change your password on first login.</em></p>
            </div>

            <p style="margin-top: 30px;">Thank you once again for your participation and for the vital work you do to
                advance evidence-based policymaking across Africa.</p>

            <p>Best regards,<br>
                <strong>ATTP Secretariat</strong>
            </p>
        </div>

        <!-- Footer -->
        <div style="background-color: #007144; color: white; text-align: center; padding: 15px;">
            Africa Think Tank Platform — African Union Commission
        </div>
    </div>
</body>


</html>
