<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('partner.email.welcome') }}</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 40px 20px;">
    <div style="max-width: 650px; margin: 0 auto; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.1); background-color: #ffffff;">

        <!-- Header -->
        <div style="background: linear-gradient(135deg, #007144 0%, #00a86b 100%); padding: 30px; text-align: center; color: white;">
            <h2 style="margin: 0; font-size: 24px;">{{ __('partner.email.welcome_title') }}</h2>
            <p style="margin: 10px 0 0 0; font-size: 14px; opacity: 0.95;">{{ __('partner.email.portal_access') }}</p>
        </div>

        <!-- Body Content -->
        <div style="padding: 40px 30px; color: #333;">
            <p style="font-size: 16px; line-height: 1.6; margin-bottom: 20px;">
                {{ __('partner.email.dear') }} <strong>{{ $funder->contact_person ?? $funder->name }}</strong>,
            </p>

            <p style="font-size: 15px; line-height: 1.6; margin-bottom: 20px;">
                {{ __('partner.email.greeting_line_1') }}
            </p>

            <p style="font-size: 15px; line-height: 1.6; margin-bottom: 30px;">
                {{ __('partner.email.greeting_line_2', ['organization' => $funder->name]) }}
            </p>

            <!-- Login Credentials Box -->
            <div style="margin: 30px 0; padding: 25px; background-color: #f0f9f5; border-left: 4px solid #007144; border-radius: 4px;">
                <h4 style="margin-top: 0; color: #007144; font-size: 18px;">
                    🔐 {{ __('partner.email.credentials_title') }}
                </h4>
                <p style="margin: 15px 0 10px 0;">
                    <strong>{{ __('partner.email.portal_url') }}:</strong><br>
                    <a href="{{ $loginUrl }}" style="color: #007144; font-size: 16px; word-break: break-all;">{{ $loginUrl }}</a>
                </p>
                <p style="margin: 15px 0;">
                    <strong>{{ __('partner.email.username') }}:</strong><br>
                    <span style="font-family: monospace; background-color: #e8e8e8; padding: 6px 10px; border-radius: 3px; display: inline-block;">{{ $user->email }}</span>
                </p>
                <p style="margin: 15px 0;">
                    <strong>{{ __('partner.email.password') }}:</strong><br>
                    <span style="font-family: monospace; background-color: #e8e8e8; padding: 6px 10px; border-radius: 3px; display: inline-block;">{{ $plainPassword }}</span>
                </p>
                <p style="margin: 15px 0 0 0; font-size: 13px; color: #666; font-style: italic;">
                    {{ __('partner.email.password_note') }}
                </p>
            </div>

            <!-- Portal Features -->
            <div style="margin: 30px 0;">
                <h4 style="color: #007144; font-size: 18px;">{{ __('partner.email.portal_features') }}</h4>
                <ul style="line-height: 2; font-size: 15px; margin: 15px 0; padding-left: 25px;">
                    <li>{{ __('partner.email.feature_1') }}</li>
                    <li>{{ __('partner.email.feature_2') }}</li>
                    <li>{{ __('partner.email.feature_3') }}</li>
                    <li>{{ __('partner.email.feature_4') }}</li>
                </ul>
            </div>

            <!-- Support Information -->
            <p style="margin-top: 30px; font-size: 15px; line-height: 1.6;">
                {{ __('partner.email.support_line') }}
                <a href="mailto:attpinfo@africanunion.org" style="color: #007144;">attpinfo@africanunion.org</a>.
            </p>

            <p style="margin-top: 30px; font-size: 15px; line-height: 1.6;">
                {{ __('partner.email.closing') }}
            </p>

            <p style="margin-top: 30px; line-height: 1.6;">
                <strong>{{ __('partner.email.signature_line_1') }}</strong><br>
                {{ __('partner.email.signature_line_2') }}<br>
                <span style="color: #666; font-size: 14px;">{{ __('partner.email.signature_line_3') }}</span>
            </p>
        </div>

        <!-- Footer -->
        <div style="background-color: #007144; color: white; text-align: center; padding: 20px; font-size: 13px;">
            {{ __('partner.email.footer') }}
        </div>
    </div>
</body>
</html>
