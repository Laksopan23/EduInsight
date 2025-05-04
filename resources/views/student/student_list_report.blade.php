<!DOCTYPE html>
<html>
<head>
    <title>Student List Report</title>
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
    <h1>Student List Report</h1>
    <p>Generated on: {{ now()->format('d-m-Y H:i:s') }}</p>
    <table>
        <thead>
            <tr>
                <th>Admission ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Class</th>
                <th>DOB</th>
                <th>Mobile Number</th>
            </tr>
        </thead>
        <tbody>
            @foreach($studentList as $list)
                <tr>
                    <td>{{ $list->admission_id }}</td>
                    <td>
                        <img src="{{ $list->upload ? public_path('storage/student-photos/' . $list->upload) : public_path('images/photo_defaults.jpg') }}" alt="{{ $list->first_name }} {{ $list->last_name }}" class="avatar-img">
                        {{ $list->first_name }} {{ $list->last_name }}
                    </td>
                    <td>{{ $list->email }}</td>
                    <td>{{ $list->class }} {{ $list->section }}</td>
                    <td>{{ $list->date_of_birth }}</td>
                    <td>{{ $list->phone_number }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>