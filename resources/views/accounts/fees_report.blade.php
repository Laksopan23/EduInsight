<!DOCTYPE html>
<html>
<head>
    <title>Fees Collection Report</title>
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
        .avatar-img {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            vertical-align: middle;
            margin-right: 5px;
        }
    </style>
</head>
<body>
    <h1>Fees Collection Report</h1>
    <p>Generated on: {{ now()->format('d-m-Y H:i:s') }}</p>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Gender</th>
                <th>Fees Type</th>
                <th>Amount</th>
                <th>Paid Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($feesInformation as $value)
                <tr>
                    <td>ST-{{ $value->student_id }}</td>
                    <td>
                        <img src="{{ public_path('images/' . $value->avatar) }}" alt="{{ $value->student_name }}" class="avatar-img">
                        {{ $value->student_name }}
                    </td>
                    <td>{{ $value->gender }}</td>
                    <td>{{ $value->fees_type }}</td>
                    <td>${{ $value->fees_amount }}</td>
                    <td>{{ $value->paid_date }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>