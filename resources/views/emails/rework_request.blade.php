<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Rework Request – Evaluation</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            line-height: 1.5;
            color: #333;
        }

        h1,
        h2,
        h3 {
            color: #017C76;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            font-size: 11px;
        }

        th {
            background: #f4f4f4;
            text-align: left;
        }

        .footer {
            margin-top: 40px;
            font-size: 10px;
            color: #666;
            text-align: center;
        }

        .watermark {
            position: fixed;
            top: 40%;
            left: 20%;
            opacity: 0.1;
            font-size: 60px;
            color: #522B39;
            transform: rotate(-30deg);
            z-index: -1;
        }

        .highlight {
            background: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 10px;
            margin: 15px 0;
        }
    </style>
</head>

<body>
    <div class="watermark">CONFIDENTIAL</div>

    <h1>Africa Think Tank Platform – Rework Request</h1>
    <p>Dear <strong>{{ $evaluation->evaluator->name ?? 'Evaluator' }}</strong>,</p>

    <p>Your evaluation for the following applicant has been returned for <strong>rework</strong>:</p>

    <table>
        <tr>
            <th>Applicant</th>
            <td>{{ $evaluation->applicant->think_tank_name ?? 'N/A' }}</td>
        </tr>
        <tr>
            <th>Country</th>
            <td>{{ $evaluation->applicant->country ?? 'N/A' }}</td>
        </tr>
        <tr>
            <th>Evaluator</th>
            <td>{{ $evaluation->evaluator->name ?? 'N/A' }}</td>
        </tr>
        <tr>
            <th>Current Status</th>
            <td><strong style="color:#dc3545;">Draft (Rework Required)</strong></td>
        </tr>
    </table>

    <h2>Message from Admin</h2>
    <div class="highlight">
        {!! nl2br(e($messageText)) !!}
    </div>

    <p>Please log back into the <strong>Africa Think Tank Platform</strong> system to update your evaluation.
        Once you have revised and resubmitted, the status will return to <strong>Submitted</strong>.</p>

    <div class="footer">
        African Union – Africa Think Tank Platform (ATTP) 2025/2026 <br>
        Generated on {{ now()->format('d M Y, H:i') }}
    </div>
</body>

</html>
