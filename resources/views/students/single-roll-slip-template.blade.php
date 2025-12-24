<!DOCTYPE html>
<html lang="en">

<head>
    <title>Roll Number Slips</title>
    <style type="text/css">
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        .container {
            padding: 10px;
        }

        .roll-slip {
            border: 2px solid #000;
            padding: 15px;
            margin-bottom: 20px;
            width: 100%;
            height: calc(50vh - 10px);
            display: block;
            box-sizing: border-box;
            position: relative;
        }

        .header {
            text-align: center;
            border-bottom: 1px solid #000;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }

        .header h2 {
            margin: 0;
            font-size: 18px;
        }

        .header h3 {
            margin: 5px 0;
            font-size: 14px;
        }

        .logo {
            width: 100px;
            height: 80px;
            object-fit: contain;
            float: left;
            margin-right: 15px;
        }

        .info-wrapper {
            /* background: red; */
        }

        .student-container {
            display: inline-block;
            width: 70%;
            vertical-align: top;
        }

        .student-info {
            display: table;
        }

        .student-info .row {
            display: table-row;
        }

        .student-info .label {
            display: table-cell;
            width: 30%;
            font-weight: bold;
            padding: 5px 0;
            padding-right: 50px;
        }

        .student-info .value {
            display: table-cell;
            width: 70%;
            padding: 5px 0;
        }

        .photo-box {
            /* width: 140px; */
            width: 20%;
            height: 100px;
            border: 2px solid #000;
            margin-left: 20px;
            text-align: center;
            font-size: 12px;
            padding-top: 55px;
            box-sizing: border-box;
            display: inline-block;
            vertical-align: top;
        }

        .roll-number {
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            margin: 15px 0;
            padding: 10px;
            border: 2px solid #000;
            background-color: #f0f0f0;
        }

        .footer {
            text-align: center;
            margin-top: 15px;
            font-size: 12px;
            border-top: 1px solid #000;
            padding-top: 10px;
        }

        .page-break {
            page-break-before: always;
        }
    </style>
</head>

<body class="container">

    <?php
date_default_timezone_set("Asia/Karachi");
    ?>

    <div class="roll-slip">
        <div class="header">
            <img src="{{ public_path('assets/media/logo.jpg') }}" alt="Logo" class="logo">
            <h2>Taleem Dost Forum</h2>
            <h3>Talent Test - 2025</h3>
            <h3>Roll Number Slip</h3>
        </div>
        <div class="roll-number">
            Roll Number: {{ $student->roll_number }}
        </div>

        <div class="info-wrapper">
            <div class="student-container">
                <div class="student-info">
                    <div class="row">
                        <div class="label">Name: </div>
                        <div class="value">{{ $student->display_name }}</div>
                    </div>
                    <div class="row">
                        <div class="label">Father Name: </div>
                        <div class="value">{{ $student->father }}</div>
                    </div>
                    <div class="row">
                        <div class="label">School: </div>
                        <div class="value">
                            {{ $student->participate_with === 'school' ? $student->school->school_name : $student->school_name }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="label">Grade: </div>
                        <div class="value">{{ $student->grade }}th</div>
                    </div>
                    <div class="row">
                        <div class="label">Gender: </div>
                        <div class="value">{{ ucfirst($student->gender) }}</div>
                    </div>
                    <div class="row">
                        <div class="label">Date of Birth: </div>
                        <div class="value">
                            {{ $student->dob ? date('d/m/Y', strtotime($student->dob)) : '-' }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="photo-box">Photo</div>
        </div>



        <div class="footer">
            <h3>Examination Center: The TIPS College, D-Ground Faisalabad.</h3>
            <p>Please keep this slip safe. It will be required for participation.</p>
            <p>Generated on: {{ date('d/m/Y H:i:s') }}</p>
        </div>
    </div>

</body>

</html>