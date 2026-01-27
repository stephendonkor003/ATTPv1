<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Evaluation Notification (Admin)</title>
</head>

<body style="font-family: Arial, sans-serif; background-color: #f7f7f7; padding: 40px;">
    <div
        style="max-width: 700px; margin: auto; background: #fff; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); overflow: hidden;">

        <!-- Header -->
        <div style="background-color: #017C76; padding: 20px; color: #fff;">
            <h2 style="margin: 0;">Africa Think Tank Platform</h2>
            <p style="margin: 0;">Evaluation {{ ucfirst($action) }}</p>
        </div>

        <!-- Body -->
        <div style="padding: 25px; color: #333;">
            <p>Dear Administrator,</p>

            <p>
                An evaluation has been <strong>{{ $action }}</strong> on the
                <strong>Africa Think Tank Platform</strong>.
            </p>

            <h3>Details</h3>
            <ul>
                <li><strong>Evaluator:</strong> {{ $evaluator->name }} ({{ $evaluator->email }})</li>
                <li><strong>Applicant:</strong> {{ $applicant->consortium_name ?? $applicant->think_tank_name }}</li>
                <li><strong>Country:</strong> {{ $applicant->country }}</li>
                <li><strong>Total Score:</strong> {{ $evaluation->total_score }}/100</li>
                <li><strong>Status:</strong> {{ ucfirst($evaluation->status) }}</li>
            </ul>

            <p>
                Please find the attached PDF for full evaluation details.
            </p>

            <p style="margin-top: 20px;">Best regards,<br><strong>ATTP Secretariat</strong></p>
        </div>

        <!-- Footer -->
        <div style="background-color: #017C76; color: white; text-align: center; padding: 12px;">
            Africa Think Tank Platform — African Union Commission
        </div>
    </div>
</body>

</html>
