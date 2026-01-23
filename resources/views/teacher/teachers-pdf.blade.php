<!DOCTYPE html>
<html>
<head>
    <title>Teachers List</title>
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
    <h1>Teachers List</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Gender</th>
                <th>Qualification</th>
                <th>Mobile Number</th>
                <th>Address</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($teacherList as $list)
                <tr>
                    <td>{{ $list->user_id }}</td>
                    <td>{{ $list->full_name }}</td>
                    <td>{{ $list->user->email }}</td>
                    <td>{{ $list->gender }}</td>
                    <td>{{ $list->qualification }}</td>
                    <td>{{ $list->phone_number }}</td>
                    <td>{{ $list->address }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>