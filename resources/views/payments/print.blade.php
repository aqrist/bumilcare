<!DOCTYPE html>
<html>

<head>
    <title>Invoice #{{ $payment->invoice_number }}</title>
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

        .total {
            font-weight: bold;
            font-size: 16px;
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
            <th width="30%">Invoice Number</th>
            <td>{{ $payment->invoice_number }}</td>
        </tr>
        <tr>
            <th>Date</th>
            <td>{{ $payment->created_at->format('d M Y H:i') }}</td>
        </tr>
        <tr>
            <th>Patient Name</th>
            <td>
                @if ($payment->type === 'examination')
                    {{ $payment->examination->patient->name }}
                @else
                    {{ $payment->prescription->examination->patient->name }}
                @endif
            </td>
        </tr>
        <tr>
            <th>Payment Type</th>
            <td>{{ ucfirst($payment->type) }}</td>
        </tr>
        <tr>
            <th>Payment Method</th>
            <td>
                @if ($payment->payment_method === 'insurance')
                    Insurance ({{ $payment->insurance_provider }})
                    <br>
                    <small>Insurance Number: {{ $payment->insurance_number }}</small>
                @else
                    {{ ucfirst($payment->payment_method) }}
                @endif
            </td>
        </tr>
    </table>

    @if ($payment->type === 'medicine')
        <h4>Medicine Details</h4>
        <table>
            <thead>
                <tr>
                    <th>Medicine</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($payment->prescription->details as $detail)
                    <tr>
                        <td>{{ $detail->medicine->name }}</td>
                        <td>{{ $detail->quantity }}</td>
                        <td>Rp {{ number_format($detail->medicine->price, 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($detail->medicine->price * $detail->quantity, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <div class="total">
        Total Amount: Rp {{ number_format($payment->amount, 0, ',', '.') }}
    </div>

    <div class="footer">
        <p>Cashier: {{ $payment->cashier->name }}</p>
        <br><br>
        <p>____________________</p>
        <p>Authorized Signature</p>
    </div>

    <button class="no-print" onclick="window.print()">Print</button>
</body>

</html>
