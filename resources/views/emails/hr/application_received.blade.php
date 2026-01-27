<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Received</title>
</head>
<body style="margin:0;padding:0;background-color:#f5f7fb;font-family:Arial,Helvetica,sans-serif;color:#111827;">
    <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="background-color:#f5f7fb;padding:24px 0;">
        <tr>
            <td align="center">
                <table width="640" cellpadding="0" cellspacing="0" role="presentation" style="background-color:#ffffff;border-radius:10px;overflow:hidden;box-shadow:0 6px 18px rgba(0,0,0,0.08);">
                    <tr>
                        <td style="background:#0b4f6c;padding:22px 28px;">
                            <div style="color:#dbeafe;font-size:12px;letter-spacing:1px;text-transform:uppercase;">
                                ATTP Administration Portal
                            </div>
                            <div style="color:#ffffff;font-size:22px;font-weight:bold;margin-top:6px;">
                                Application Received
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:28px;">
                            <p style="margin:0 0 12px 0;font-size:16px;">
                                Hello {{ $fullName }},
                            </p>
                            <p style="margin:0 0 16px 0;line-height:1.6;">
                                Thank you for submitting your application. We have successfully received your details
                                and our team will review your submission carefully.
                            </p>

                            <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="border:1px solid #e5e7eb;border-radius:8px;">
                                <tr>
                                    <td style="padding:14px 16px;background:#f8fafc;font-weight:bold;">Applicant Details</td>
                                </tr>
                                <tr>
                                    <td style="padding:12px 16px;">
                                        <div style="font-size:14px;line-height:1.6;">
                                            <strong>Name:</strong> {{ $fullName }}<br>
                                            <strong>Email:</strong> {{ $email }}
                                        </div>
                                    </td>
                                </tr>
                            </table>

                            <p style="margin:18px 0 0 0;line-height:1.6;">
                                We wish you a successful employment journey and will contact you if your profile is shortlisted.
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td style="background:#f8fafc;padding:18px 28px;color:#6b7280;font-size:12px;line-height:1.5;">
                            <div>
                                This is an automated message from ATTP Administration Portal. Please do not reply directly
                                to this email.
                            </div>
                            <div style="margin-top:6px;">
                                Contact: attpinfo@africanunion.org
                            </div>
                        </td>
                    </tr>
                </table>
                <div style="font-size:11px;color:#9ca3af;margin-top:12px;">
                    © {{ date('Y') }} ATTP Administration Portal. All rights reserved.
                </div>
            </td>
        </tr>
    </table>
</body>
</html>
