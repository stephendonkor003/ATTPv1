<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Evaluation Assignment</title>
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
                                Evaluation Assignment
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:28px;">
                            <p style="margin:0 0 12px 0;font-size:16px;">
                                Hello {{ $evaluator->name }},
                            </p>
                            <p style="margin:0 0 16px 0;line-height:1.6;">
                                You have been assigned to evaluate the following procurement.
                            </p>

                            <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="border:1px solid #e5e7eb;border-radius:8px;">
                                <tr>
                                    <td style="padding:14px 16px;background:#f9fafb;font-weight:bold;">Assignment Details</td>
                                </tr>
                                <tr>
                                    <td style="padding:12px 16px;">
                                        <div style="font-size:14px;line-height:1.6;">
                                            <strong>Evaluation:</strong> {{ $evaluation->name }}<br>
                                            <strong>Procurement:</strong> {{ $procurement->title }}<br>
                                            <strong>Reference No:</strong> {{ $procurement->reference_no ?? 'N/A' }}<br>
                                            @if ($submission)
                                                <strong>Submission Code:</strong> {{ $submission->procurement_submission_code }}<br>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            </table>

                            <div style="margin:18px 0 24px 0;">
                                <a href="{{ route('my.eval.index') }}"
                                   style="display:inline-block;background:#2563eb;color:#ffffff;text-decoration:none;padding:10px 16px;border-radius:6px;font-weight:bold;">
                                    Go to My Evaluations
                                </a>
                            </div>

                            <p style="margin:0;line-height:1.6;">
                                Please complete your evaluation promptly. Contact your admin if you need assistance.
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
