<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Participation Slip</title>
    <style>
        @page {
            size: A4;
            margin: 15mm;
        }
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
            line-height: 1.4;
        }
        .certificate {
            border: 2px solid #4a90e2;
            border-radius: 8px;
            padding: 15px;
            background: white;
        }
        .top-heading {
            text-align: center;
            margin-bottom: 10px;
        }
        .top-heading .urdu {
            font-size: 18px;
            font-weight: bold;
            color: #4a90e2;
            margin-bottom: 4px;
        }
        .top-heading .english {
            font-size: 14px;
            color: #666;
        }
        .logo {
            width: 60px;
            height: 60px;
            margin: 0 auto 10px;
        }
        .header {
            text-align: center;
            background: #667eea;
            color: white;
            padding: 10px;
            border-radius: 6px;
            margin-bottom: 15px;
        }
        .header h1 {
            margin: 0;
            font-size: 20px;
        }
        .content {
            display: table;
            width: 100%;
            margin-bottom: 15px;
        }
        .left-column {
            display: table-cell;
            width: 60%;
            vertical-align: top;
            padding-right: 15px;
        }
        .right-column {
            display: table-cell;
            width: 40%;
            text-align: center;
            vertical-align: top;
        }
        .id-box {
            background: #ff6b6b;
            color: white;
            padding: 8px;
            text-align: center;
            font-weight: bold;
            font-size: 14px;
            margin-bottom: 10px;
            border-radius: 4px;
        }
        .info-table {
            width: 100%;
            border-collapse: collapse;
        }
        .info-table td {
            padding: 3px;
            border-bottom: 1px solid #eee;
        }
        .label {
            font-weight: bold;
            color: #4a90e2;
            width: 25%;
            font-size: 11px;
        }
        .value {
            background: #f8f9fa;
            padding: 3px;
            border-radius: 2px;
            font-size: 11px;
        }
        .photo {
            width: 110px;
            height: 110px;
            border: 2px solid #4a90e2;
            border-radius: 8px;
            margin: 0 auto 5px;
        }
        .photo img {
            width: 100%;
            height: 100%;
            border-radius: 8px;
            object-fit: cover;
        }
        .photo-placeholder {
            width: 100%;
            height: 100%;
            background: #f8f9fa;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 8px;
            color: #666;
        }
        .puzzle {
            background: #ffeaa7;
            border: 1px dashed #fd79a8;
            border-radius: 6px;
            padding: 10px;
            margin: 15px 0;
            text-align: center;
        }
        .puzzle-part {
            margin-bottom: 8px;
        }
        .puzzle h2 {
            color: #e84393;
            margin: 0 0 5px 0;
            font-size: 14px;
        }
        .intro {
            background: white;
            padding: 6px;
            border-radius: 3px;
            margin-bottom: 5px;
            font-size: 10px;
            line-height: 1.3;
        }
        .steps {
            background: #fff5f5;
            padding: 6px;
            border-radius: 3px;
            margin-bottom: 5px;
            font-size: 9px;
            line-height: 1.4;
            text-align: left;
        }
        .code-box {
            display: inline-block;
            width: 80px;
            height: 40px;
            background: white;
            border: 2px solid #e84393;
            border-radius: 6px;
            font-size: 18px;
            font-weight: bold;
            color: #6c5ce7;
            line-height: 40px;
            text-align: center;
            margin: 5px 0;
        }
        .hints {
            background: #f0f8ff;
            padding: 6px;
            border-radius: 3px;
            font-size: 8px;
            line-height: 1.3;
            text-align: left;
        }
        .footer {
            background: #2d3436;
            color: white;
            text-align: center;
            padding: 8px;
            border-radius: 4px;
            font-size: 10px;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="certificate">
        <div class="top-heading">
            <img src="{{ asset('assets/media/logo.png') }}" alt="Logo" class="logo">
            <div class="urdu">Sitaron Sa Aaga Jahan Aur B han</div>
            <div class="english">A project by Taleem Dost Forum</div>
        </div>
        <div class="header">
            <h1>Participation Slip</h1>
            {{-- <div class="subtitle">Sitaron Sa Aaga Jahan Aur Bahan</div> --}}
        </div>

        <div class="content">
            <div class="left-column">
                <div class="id-box">
                    ID: {{ $student->participation_id }}
                </div>
                <table class="info-table">
                    <tr>
                        <td class="label">Name:</td>
                        <td class="value">{{ $student->name }}</td>
                    </tr>
                    <tr>
                        <td class="label">Father:</td>
                        <td class="value">{{ $student->father }}</td>
                    </tr>
                    <tr>
                        <td class="label">School:</td>
                        <td class="value">{{ $student->school_name }}</td>
                    </tr>
                    <tr>
                        <td class="label">Grade:</td>
                        <td class="value">{{ $student->grade }}th Grade</td>
                    </tr>
                    <tr>
                        <td class="label">Gender:</td>
                        <td class="value">{{ ucfirst($student->gender) }}</td>
                    </tr>
                    <tr>
                        <td class="label">DOB:</td>
                        <td class="value">{{ \Carbon\Carbon::parse($student->dob)->format('d/m/Y') }}</td>
                    </tr>
                    @if($student->contact)
                    <tr>
                        <td class="label">Contact:</td>
                        <td class="value">{{ $student->contact }}</td>
                    </tr>
                    @endif
                </table>
            </div>
            <div class="right-column">
                <div class="photo">
                    @if($student->student_image)
                        <img src="{{ asset($student->student_image) }}" alt="Student Photo">
                    @else
                        <div class="photo-placeholder">No Photo</div>
                    @endif
                </div>
            </div>
        </div>

        <div class="puzzle">
            <div class="puzzle-part">
                <h2>Mystery Code Quest!</h2>
                <div class="intro">
                    Your Mystery Code is made of four secret keys. Can you find it?<br>
                    Find your unique code using your name, father's name, grade, and birth day.<br>
                    This Mystery Code is your attendance code for the event.
                </div>
            </div>

            <div class="puzzle-part">
                <div class="steps">
                    Step 1: Take the first letter of your name and convert it to a number (A=1, B=2 ... Z=26).<br>
                    Step 2: Take the first letter of your father's name and convert it the same way.<br>
                    Step 3: Take your grade number.<br>
                    Step 4: Take the day you were born.<br>
                    <br>
                    Now follow these steps to get your code:<br>
                    1. Add Step 1 and Step 2<br>
                    2. Multiply Step 3 by 2<br>
                    3. Add Step 4 to the total of Step 1+2 and Step 3x2<br>
                    <br>
                    The final number is your **unique Mystery Code**!
                </div>
            </div>

            <div class="puzzle-part">
                <div class="code-box">
                    &nbsp;
                </div>
            </div>

            <div class="puzzle-part">
                <div class="hints">
                    Hints:<br>
                    - A=1, B=2, C=3, D=4, E=5, F=6, G=7, H=8, I=9, J=10, K=11, L=12, M=13, N=14, O=15, P=16, Q=17, R=18, S=19, T=20, U=21, V=22, W=23, X=24, Y=25, Z=26<br>
                    - Grade numbers are 8, 9, or 10<br>
                    - Only use the day from your date of birth (1-31)<br>
                    - Solve step by step to unlock your code!
                </div>
            </div>
        </div>

        <div class="footer">
            <strong>Event Details:</strong><br>
            Date: January 6, 2026<br>
            Location: Cadet College Faisalabad<br>
            Timing: 9 AM to 4 PM<br>
            <br>
            This certificate confirms your participation in the event. Solve the code puzzle and keep it safe!
        </div>
    </div>
</body>
</html>