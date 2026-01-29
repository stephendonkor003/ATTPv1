<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .email-header {
            background: linear-gradient(135deg, #522b39 0%, #a70d53 100%);
            color: #ffffff;
            padding: 30px 20px;
            text-align: center;
        }
        .email-header h1 {
            margin: 0;
            font-size: 24px;
            color: #fbbc05;
        }
        .email-header p {
            margin: 10px 0 0 0;
            font-size: 14px;
            opacity: 0.9;
        }
        .email-body {
            padding: 30px 20px;
        }
        .email-body h2 {
            color: #a70d53;
            font-size: 20px;
            margin-top: 0;
        }
        .email-body p {
            margin: 15px 0;
            line-height: 1.8;
        }
        .info-box {
            background: #f8f9fa;
            border-left: 4px solid #a70d53;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
        }
        .info-box strong {
            color: #522b39;
        }
        .next-steps {
            background: #e8f4f8;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
        }
        .next-steps h3 {
            color: #a70d53;
            margin-top: 0;
            font-size: 18px;
        }
        .next-steps ul {
            margin: 10px 0;
            padding-left: 20px;
        }
        .next-steps li {
            margin: 8px 0;
        }
        .email-footer {
            background: #f8f9fa;
            padding: 20px;
            text-align: center;
            border-top: 1px solid #e0e0e0;
        }
        .email-footer p {
            margin: 5px 0;
            font-size: 13px;
            color: #666;
        }
        .email-footer .social-links {
            margin: 15px 0;
        }
        .email-footer .social-links a {
            color: #a70d53;
            text-decoration: none;
            margin: 0 10px;
        }
        .button {
            display: inline-block;
            padding: 12px 30px;
            background: #a70d53;
            color: #ffffff;
            text-decoration: none;
            border-radius: 25px;
            margin: 15px 0;
        }
        .highlight {
            color: #a70d53;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="email-header">
            <h1>ATTP Africa</h1>
            <p>African Think Tank Platform Administration</p>
        </div>

        <!-- Body -->
        <div class="email-body">
            <h2>Thank You for Your Information Request</h2>

            <p>Dear <strong>{{ $requestData['full_name'] }}</strong>,</p>

            <p>We have successfully received your information request and want to acknowledge receipt of your inquiry. Your request is important to us, and we are committed to providing you with the information you need.</p>

            <div class="info-box">
                <strong>Request Details:</strong><br>
                <strong>Type:</strong> {{ ucfirst(str_replace('_', ' ', $requestData['requester_type'])) }}<br>
                <strong>Country:</strong> {{ $requestData['country'] }}<br>
                @if(isset($requestData['organization']) && $requestData['organization'])
                <strong>Organization:</strong> {{ $requestData['organization'] }}<br>
                @endif
                <strong>Request Category:</strong> {{ ucfirst(str_replace('_', ' ', $requestData['request_type'])) }}<br>
                <strong>Date Submitted:</strong> {{ now()->format('F d, Y') }}
            </div>

            <div class="next-steps">
                <h3>What Happens Next?</h3>
                <ul>
                    <li>Our team will review your request within <span class="highlight">2-3 business days</span></li>
                    <li>We will gather the relevant information and data to address your inquiry</li>
                    <li>You will receive a detailed response via email to <span class="highlight">{{ $requestData['email'] }}</span></li>
                    <li>If we need additional information, we will contact you directly</li>
                </ul>
            </div>

            <p><strong>Your Message:</strong></p>
            <div class="info-box">
                {{ $requestData['message'] }}
            </div>

            <p>If you have any urgent questions or need to provide additional information, please don't hesitate to contact us at <a href="mailto:info@attp.africa" style="color: #a70d53;">info@attp.africa</a></p>

            <p>Thank you for your interest in ATTP and our work across Africa.</p>

            <p style="margin-top: 30px;">
                <strong>Best regards,</strong><br>
                <span class="highlight">ATTP Information Team</span><br>
                African Think Tank Platform Administration
            </p>
        </div>

        <!-- Footer -->
        <div class="email-footer">
            <p><strong>ATTP - African Think Tank Platform Administration</strong></p>
            <p>Supporting African Union policy coordination, governance reform,<br>
            and evidence-based decision-making across the continent.</p>

            <div class="social-links">
                <a href="https://africathinktankplatform.africa">Visit Our Website</a> |
                <a href="mailto:info@attp.africa">Contact Us</a>
            </div>

            <p style="font-size: 11px; color: #999; margin-top: 15px;">
                This is an automated acknowledgement email. Please do not reply directly to this message.<br>
                © {{ date('Y') }} ATTP. All rights reserved.
            </p>
        </div>
    </div>
</body>
</html>
