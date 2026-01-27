<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Evaluation Report</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            line-height: 1.5;
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
        }
    </style>
</head>

<body>
    <div class="watermark">CONFIDENTIAL</div>

    <h1>Africa Think Tank Platform – Evaluation Report</h1>
    <p><strong>Applicant:</strong> {{ $applicant->think_tank_name ?? 'N/A' }}</p>
    <p><strong>Country:</strong> {{ $applicant->country ?? 'N/A' }}</p>
    <p><strong>Evaluator:</strong> {{ $evaluator->name ?? 'N/A' }}</p>
    <p><strong>Status:</strong> {{ ucfirst($evaluation->status) }}</p>

    <h2>Scores & Comments</h2>
    <table>
        <thead>
            <tr>
                <th>Criteria</th>
                <th>Score</th>
                <th>Strength</th>
                <th>Gap</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($evaluation->getFillable() as $field)
                @if (str_ends_with($field, '_score'))
                    @php
                        $strength = str_replace('_score', '_strength', $field);
                        $gap = str_replace('_score', '_gap', $field);
                        $label = ucwords(str_replace('_', ' ', str_replace('_score', '', $field)));
                    @endphp
                    <tr>
                        <td>{{ $label }}</td>
                        <td>{{ $evaluation->$field }}</td>
                        <td>{{ $evaluation->$strength ?? '-' }}</td>
                        <td>{{ $evaluation->$gap ?? '-' }}</td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>

    <h3>Total Score: {{ $evaluation->total_score }}</h3>

    <h3>Overall Comments</h3>
    <p>{{ $evaluation->overall_comments }}</p>

    <div class="footer">
        African Union – Africa Think Tank Platform 2025/2026 <br>
        Generated on {{ now()->format('d M Y, H:i') }}
    </div>
</body>

</html>
