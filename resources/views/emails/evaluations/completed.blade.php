<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Evaluation Completed</title>
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
                                Evaluation Completed
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:28px;">
                            <p style="margin:0 0 12px 0;font-size:16px;">
                                Hello,
                            </p>
                            <p style="margin:0 0 16px 0;line-height:1.6;">
                                An evaluation has been completed. The detailed report is attached as a PDF.
                            </p>

                            <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="border:1px solid #e5e7eb;border-radius:8px;">
                                <tr>
                                    <td style="padding:14px 16px;background:#f9fafb;font-weight:bold;">Submission Details</td>
                                </tr>
                                <tr>
                                    <td style="padding:12px 16px;">
                                        <div style="font-size:14px;line-height:1.6;">
                                            <strong>Procurement:</strong> {{ $submission->procurement->title ?? 'N/A' }}<br>
                                            <strong>Reference No:</strong> {{ $submission->procurement->reference_no ?? 'N/A' }}<br>
                                            <strong>Submission Code:</strong> {{ $submission->applicant?->procurement_submission_code ?? 'N/A' }}<br>
                                            <strong>Evaluation:</strong> {{ $submission->evaluation->name ?? 'N/A' }}<br>
                                            <strong>Evaluator:</strong> {{ $submission->evaluator?->name ?? 'N/A' }}<br>
                                            <strong>Submitted At:</strong> {{ $submission->submitted_at?->format('Y-m-d H:i') ?? 'N/A' }}
                                        </div>
                                    </td>
                                </tr>
                            </table>

                            <p style="margin:18px 0 0 0;line-height:1.6;">
                                Please review the attached report for full details and scoring breakdown.
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
                    Copyright {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
                </div>
            </td>
        </tr>
    </table>
</body>
</html>
