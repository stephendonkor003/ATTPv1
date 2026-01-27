<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Consortium Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
        }

        h3 {
            color: #198754;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #f8f9fa;
        }
    </style>
</head>

<body>
    <h3>{{ $consortium->consortium_name }}</h3>
    <p><strong>Think Tank:</strong> {{ $consortium->think_tank_name }}</p>
    <p><strong>Country:</strong> {{ $consortium->country ?? 'N/A' }}</p>
    <p><strong>Prescreening:</strong> {{ $prescreening->eligible ?? 'Pending' }}</p>

    <table>
        <thead>
            <tr>
                <th>Evaluator</th>
                <th>Proposal</th>
                <th>Personnel</th>
                <th>Budget</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($analysis as $row)
                <tr>
                    <td>{{ $row['evaluator'] }}</td>
                    <td>{{ $row['proposal'] }}</td>
                    <td>{{ $row['personnel'] }}</td>
                    <td>{{ $row['budget'] }}</td>
                    <td>{{ $row['total'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h4>Summary</h4>
    <ul>
        <li>Average Proposal: {{ $summary['avg_proposal'] }}</li>
        <li>Average Personnel: {{ $summary['avg_personnel'] }}</li>
        <li>Average Budget: {{ $summary['avg_budget'] }}</li>
        <li>Overall Average: {{ $summary['avg_total'] }}</li>
    </ul>
</body>

</html>
