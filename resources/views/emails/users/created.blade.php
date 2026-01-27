<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Account Created</title>
</head>

<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 40px;">
    <div
        style="max-width: 650px; margin: auto; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">

        <!-- Header -->
        <div style="background-color: #007144; padding: 20px; text-align: center; color: white;">
            <h2>Your Account Has Been Created</h2>
        </div>

        <!-- Body Content -->
        <div style="padding: 30px; color: #333;">
            <p>Dear {{ $user->name }},</p>

            <p>We are pleased to inform you that an account has been successfully created for you on the
                <strong>Africa Think Tank Platform</strong>.
            </p>

            <p><strong>Role Assigned:</strong> {{ ucfirst(str_replace('_', ' ', $user->user_type)) }}</p>

            @if ($user->user_type === 'financial_evaluator')
                <p>As a <strong>Financial Evaluator</strong>, you will have access to the Financial Evaluation Form
                    to review and assess financial aspects of submitted proposals.</p>
            @endif

            <!-- Login Info -->
            <div style="margin-top: 30px; padding: 20px; background-color: #f0f9f5; border-left: 4px solid #007144;">
                <h4 style="margin-top: 0;">🟢 Your Account Credentials</h4>
                <p><strong>Email:</strong> {{ $user->email }}</p>
                <p><strong>Password:</strong> {{ $plainPassword }}</p>
                <p><em>Please keep this password secure. You may change it after logging in from your profile
                        settings.</em></p>
            </div>

            <p style="margin-top: 30px;">You can log in to your account here:
                <a href="https://africathinktankplatform.africa/login" style="color: #007144;">
                    Access Your Account
                </a>
            </p>

            <p>If you have any questions or need assistance, feel free to contact us at
                <a href="mailto:attpinfo@africanunion.org" style="color: #007144;">attpinfo@africanunion.org</a>.
            </p>

            <p style="margin-top: 30px;">We look forward to your valuable contribution to advancing evidence-based
                policymaking across Africa.</p>

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
