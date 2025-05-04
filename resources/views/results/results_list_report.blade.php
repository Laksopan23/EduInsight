<!DOCTYPE html>
<html>
<head>
    <title>Results List Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            color: #333;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>
    <h1>Results List Report</h1>
    <p>Generated on: {{ now()->format('d-m-Y H:i:s') }}</p>
    <table>
        <thead>
            <tr>
                <th>Teacher</th>
                <th>Student</th>
                <th>Subject</th>
                <th>Marks</th>
            </tr>
        </thead>
        <tbody>
            @foreach($results as $result)
                <tr>
                    <td>{{ $result->teacher->name }}</td>
                    <td>{{ $result->student->name }}</td>
                    <td>{{ $result->subject->name }}</td>
                    <td>{{ $result->marks }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>