<!DOCTYPE html>
<html>
<head>
    <title>Communications List</title>
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
    <h1>Communications List</h1>
    <table>
        <thead>
            <tr>
                <th>Title</th>
                <th>Sender</th>
                <th>Receivers</th>
                <th>Meeting Link</th>
            </tr>
        </thead>
        <tbody>
            @foreach($communicationList as $communication)
            <tr>
                <td>{{ $communication->title }}</td>
                <td>{{ $communication->sender }}</td>
                <td>{{ $communication->receivers->pluck('name')->implode(', ') }}</td>
                <td>
                    @if($communication->meeting_link)
                        {{ $communication->meeting_link }}
                    @else
                        No Meeting
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>