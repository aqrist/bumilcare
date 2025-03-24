<!DOCTYPE html>
<html>

<head>
    <title>Examination Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .clinic-name {
            font-size: 24px;
            font-weight: bold;
        }

        .clinic-address {
            font-size: 14px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            width: 30%;
        }

        .section {
            margin-bottom: 20px;
        }

        .section-title {
            font-weight: bold;
            margin-bottom: 10px;
        }

        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body>
    <div class="header">
        <div class="clinic-name">Pregnancy Clinic</div>
        <div class="clinic-address">
            123 Health Street<br>
            City, Country<br>
            Phone: (123) 456-7890
        </div>
    </div>

    <div class="section">
        <div class="section-title">Patient Information</div>
        <table>
            <tr>
                <th>Name</th>
                <td>{{ $examination->patient->name }}</td>
            </tr>
            <tr>
                <th>NIK</th>
                <td>{{ $examination->patient->nik }}</td>
            </tr>
            <tr>
                <th>Doctor</th>
                <td>{{ $examination->doctor->name }}</td>
            </tr>
            <tr>
                <th>Date</th>
                <td>{{ $examination->created_at->format('d M Y H:i') }}</td>
            </tr>
        </table>
    </div>

    <div class="section">
        <div class="section-title">Physical Examination</div>
        <table>
            <tr>
                <th>Weight</th>
                <td>{{ $examination->weight ? $examination->weight . ' kg' : '-' }}</td>
            </tr>
            <tr>
                <th>Height</th>
                <td>{{ $examination->height ? $examination->height . ' cm' : '-' }}</td>
            </tr>
            <tr>
                <th>Blood Pressure</th>
                <td>
                    @if ($examination->blood_pressure_systolic && $examination->blood_pressure_diastolic)
                        {{ $examination->blood_pressure_systolic }}/{{ $examination->blood_pressure_diastolic }} mmHg
                    @else
                        -
                    @endif
                </td>
            </tr>
            <tr>
                <th>Temperature</th>
                <td>{{ $examination->temperature ? $examination->temperature . ' °C' : '-' }}</td>
            </tr>
        </table>
    </div>

    <div class="section">
        <div class="section-title">Clinical Examination</div>
        @if ($examination->pregnancy)
            <table>
                <tr>
                    <th>USG Result</th>
                    <td>{{ $examination->usg_result ?: 'No USG result recorded' }}</td>
                </tr>
            </table>
        @endif

        <table>
            <tr>
                <th>Diagnosis</th>
                <td>{{ $examination->diagnosis }}</td>
            </tr>
            <tr>
                <th>Additional Notes</th>
                <td>{{ $examination->notes ?: 'No additional notes' }}</td>
            </tr>
        </table>
    </div>

    <div class="section">
        <div class="section-title">Doctor's Signature</div>
        <div style="margin-top: 50px;">
            <div style="border-top: 1px solid #000; width: 200px; text-align: center;">
                {{ $examination->doctor->name }}
            </div>
        </div>
    </div>

    <button class="no-print" onclick="window.print()">Print</button>
</body>

</html>
