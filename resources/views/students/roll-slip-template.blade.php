<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Roll Slips</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .roll-slip {
            page-break-after: always;
            border: 1px solid #000;
            padding: 20px;
            margin-bottom: 20px;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .details {
            margin-bottom: 10px;
        }
        .details strong {
            display: inline-block;
            width: 150px;
        }
    </style>
</head>
<body>
    @foreach($students as $student)
    <div class="roll-slip">
        <h2>Roll Slip</h2>
        <div class="details">
            <strong>Participation ID:</strong> {{ $student->participation_id }}
        </div>
        <div class="details">
            <strong>Name:</strong> {{ $student->name }}
        </div>
        <div class="details">
            <strong>Father:</strong> {{ $student->father }}
        </div>
        <div class="details">
            <strong>School:</strong> {{ $student->school_name }}
        </div>
        <div class="details">
            <strong>Grade:</strong> {{ $student->grade }}th Grade
        </div>
        <div class="details">
            <strong>Gender:</strong> {{ ucfirst($student->gender) }}
        </div>
        <div class="details">
            <strong>DOB:</strong> {{ \Carbon\Carbon::parse($student->dob)->format('d/m/Y') }}
        </div>
        @if($student->contact)
        <div class="details">
            <strong>Contact:</strong> {{ $student->contact }}
        </div>
        @endif
    </div>
    @endforeach
</body>
</html>