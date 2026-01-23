<!DOCTYPE html>
<html>
<head>
    <title>Subjects List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        h4 {
            color: #555;
            margin-top: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
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
    <h1>Subjects List</h1>
    @foreach ($subjects as $grade => $gradeSubjects)
        <h4>{{ $grade }}</h4>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Mandatory</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $uniqueSubjects = $gradeSubjects->unique('name');
                @endphp
                @foreach ($uniqueSubjects as $subject)
                    <tr>
                        <td>{{ $subject->name }}</td>
                        <td>{{ $subject->category }}</td>
                        <td>{{ $subject->is_mandatory ? 'Yes' : 'No' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endforeach
</body>
</html>