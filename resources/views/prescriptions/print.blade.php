<!DOCTYPE html>
<html>

<head>
    <title>Prescription #{{ $prescription->prescription_number }}</title>
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

        .medicines {
            margin-top: 30px;
        }

        .footer {
            margin-top: 50px;
            text-align: right;
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

    <table>
        <tr>
            <th width="30%">Prescription Number</th>
            <td>{{ $prescription->prescription_number }}</td>
        </tr>
        <tr>
            <th>Date</th>
            <td>{{ $prescription->created_at->format('d M Y') }}</td>
        </tr>
        <tr>
            <th>Patient Name</th>
            <td>{{ $prescription->examination->patient->name }}</td>
        </tr>
        <tr>
            <th>Doctor</th>
            <td>{{ $prescription->examination->doctor->name }}</td>
        </tr>
    </table>

    <div class="medicines">
        <h3>Medicines</h3>
        <table>
            <thead>
                <tr>
                    <th>Medicine</th>
                    <th>Quantity</th>
                    <th>Dosage</th>
                    <th>Instructions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($prescription->details as $detail)
                    <tr>
                        <td>{{ $detail->medicine->name }}</td>
                        <td>{{ $detail->quantity }}</td>
                        <td>{{ $detail->dosage }}</td>
                        <td>{{ $detail->instructions }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="footer">
        <p>Doctor's Signature</p>
        <br><br>
        <p>____________________</p>
        <p>{{ $prescription->examination->doctor->name }}</p>
    </div>

    <button class="no-print" onclick="window.print()">Print</button>
</body>

</html>
