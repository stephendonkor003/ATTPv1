<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Evaluation Activity Confirmation</title>
</head>

<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 40px;">
    <div
        style="max-width: 700px; margin: auto; background: #fff; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); overflow: hidden;">

        <!-- Header -->
        <div style="background-color: #FDB913; padding: 20px; color: #333;">
            <h2 style="margin: 0;">Evaluation {{ ucfirst($action) }}</h2>
        </div>

        <!-- Body -->
        <div style="padding: 25px; color: #333;">
            <p>Dear {{ $evaluator->name }},</p>

            <p>
                This is to confirm that you have successfully <strong>{{ $action }}</strong> an evaluation on the
                <strong>Africa Think Tank Platform</strong>.
            </p>

            <h3>Summary</h3>
            <ul>
                <li><strong>Applicant:</strong> {{ $applicant->consortium_name ?? $applicant->think_tank_name }}</li>
                <li><strong>Country:</strong> {{ $applicant->country }}</li>
                <li><strong>Total Score:</strong> {{ $evaluation->total_score }}/100</li>
                <li><strong>Status:</strong> {{ ucfirst($evaluation->status) }}</li>
            </ul>

            <p>
                The PDF of your evaluation has been attached for your records.
            </p>

            <p style="margin-top: 20px;">Best regards,<br><strong>ATTP Secretariat</strong></p>
        </div>

        <!-- Footer -->
        <div style="background-color: #FDB913; text-align: center; padding: 12px; color: #333;">
            Africa Think Tank Platform — African Union Commission
        </div>
    </div>
</body>

</html>
