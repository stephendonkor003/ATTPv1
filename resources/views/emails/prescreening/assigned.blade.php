<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prescreening Assignment</title>
</head>
<body style="margin:0;padding:0;background-color:#f6f7fb;font-family:Arial,Helvetica,sans-serif;color:#111827;">
    <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="background-color:#f6f7fb;padding:24px 0;">
        <tr>
            <td align="center">
                <table width="640" cellpadding="0" cellspacing="0" role="presentation" style="background-color:#ffffff;border-radius:10px;overflow:hidden;box-shadow:0 4px 16px rgba(0,0,0,0.06);">
                    <tr>
                        <td style="background:#0f172a;padding:22px 28px;">
                            <div style="color:#e2e8f0;font-size:12px;letter-spacing:1px;text-transform:uppercase;">
                                {{ config('app.name') }}
                            </div>
                            <div style="color:#ffffff;font-size:22px;font-weight:bold;margin-top:6px;">
                                Prescreening Assignment Notice
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:28px;">
                            <p style="margin:0 0 12px 0;font-size:16px;">
                                Hello {{ $assignee->name }},
                            </p>
                            <p style="margin:0 0 16px 0;line-height:1.6;">
                                You have been assigned as the prescreening evaluator for the procurement below.
                                This role is time-sensitive and directly affects the eligibility status of applicants.
                            </p>

                            <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="border:1px solid #e5e7eb;border-radius:8px;">
                                <tr>
                                    <td style="padding:14px 16px;background:#f9fafb;font-weight:bold;">Procurement Details</td>
                                </tr>
                                <tr>
                                    <td style="padding:12px 16px;">
                                        <div style="font-size:14px;line-height:1.6;">
                                            <strong>Title:</strong> {{ $procurement->title }}<br>
                                            <strong>Reference No:</strong> {{ $procurement->reference_no ?? 'N/A' }}<br>
                                            <strong>Fiscal Year:</strong> {{ $procurement->fiscal_year ?? 'N/A' }}<br>
                                            <strong>Status:</strong> {{ ucfirst($procurement->status ?? 'draft') }}
                                        </div>
                                    </td>
                                </tr>
                            </table>

                            <h4 style="margin:22px 0 8px 0;">What you need to do</h4>
                            <ul style="margin:0 0 16px 18px;line-height:1.6;">
                                <li>Open the prescreening submissions list and review assigned submissions.</li>
                                <li>Evaluate each criterion carefully and provide clear remarks.</li>
                                <li>Submit the prescreening result once all criteria are reviewed.</li>
                                <li>Locked evaluations can only be edited when rework is requested.</li>
                            </ul>

                            <div style="margin:18px 0 24px 0;">
                                <a href="{{ route('prescreening.submissions.index') }}"
                                   style="display:inline-block;background:#2563eb;color:#ffffff;text-decoration:none;padding:10px 16px;border-radius:6px;font-weight:bold;">
                                    Go to Prescreening Submissions
                                </a>
                            </div>

                            <p style="margin:0;line-height:1.6;">
                                If you believe this assignment is incorrect, please contact your system administrator immediately.
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td style="background:#f9fafb;padding:18px 28px;color:#6b7280;font-size:12px;line-height:1.5;">
                            <div>
                                This is an automated message from {{ config('app.name') }}.
                                Please do not reply directly to this email.
                            </div>
                            <div style="margin-top:6px;">
                                Support: {{ config('mail.from.address') ?? 'support@example.com' }}
                            </div>
                        </td>
                    </tr>
                </table>
                <div style="font-size:11px;color:#9ca3af;margin-top:12px;">
                    © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
                </div>
            </td>
        </tr>
    </table>
</body>
</html>
