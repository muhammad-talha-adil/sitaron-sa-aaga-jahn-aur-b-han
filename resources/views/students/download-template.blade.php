<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Students List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
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
            font-weight: bold;
        }
        .text-center {
            text-align: center;
        }
        .student-image {
            width: 50px;
            height: 50px;
            object-fit: cover;
        }
    </style>
</head>
<body>
    <h1>Students List</h1>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Participation ID</th>
                <th>Student Details</th>
                <th>School</th>
                <th>Grade & Gender</th>
                <th class="text-center">Receipt</th>
                <th class="text-center">Student Image</th>
            </tr>
        </thead>
        <tbody>
            @foreach($students as $index => $student)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $student->participation_id }}</td>
                <td>
                    <strong>{{ $student->name }}</strong><br>
                    Father: {{ $student->father }}<br>
                    DOB: {{ \Carbon\Carbon::parse($student->dob)->format('d/m/Y') }}<br>
                    @if($student->contact)
                        Contact: {{ $student->contact }}
                    @endif
                </td>
                <td>{{ $student->school_name }}</td>
                <td>
                    {{ $student->grade }}th Grade<br>
                    {{ ucfirst($student->gender) }}
                </td>
                <td class="text-center">
                    @if($student->payment_receipt)
                        <img src="{{ asset($student->payment_receipt) }}" alt="Receipt" class="student-image">
                    @else
                        No Receipt
                    @endif
                </td>
                <td class="text-center">
                    @if($student->student_image)
                        <img src="{{ asset($student->student_image) }}" alt="Student Image" class="student-image">
                    @else
                        No Image
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>