<!DOCTYPE html>
<html>
<head>
    <title>Result Profile Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        .details {
            margin-top: 20px;
            font-size: 16px;
        }
        .details p {
            margin: 5px 0;
        }
        .details strong {
            display: inline-block;
            width: 120px;
        }
    </style>
</head>
<body>
    <h1>Result Profile Report</h1>
    <p>Generated on: {{ now()->format('d-m-Y H:i:s') }}</p>
    <div class="details">
        <p><strong>Teacher:</strong> {{ $result->teacher->name }}</p>
        <p><strong>Student:</strong> {{ $result->student->name }}</p>
        <p><strong>Subject:</strong> {{ $result->subject->name }}</p>
        <p><strong>Marks:</strong> {{ $result->marks }}</p>
    </div>
</body>
</html>