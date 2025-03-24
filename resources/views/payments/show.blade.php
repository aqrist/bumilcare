@extends('layouts.app')

@section('title', 'Payment Details')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3>Payment Details</h3>
            <div>
                <a href="{{ route('payments.print', $payment) }}" class="btn btn-info" target="_blank">Print</a>
                <a href="{{ route('payments.index') }}" class="btn btn-secondary">Back</a>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table">
                        <tr>
                            <th width="30%">Invoice Number</th>
                            <td>{{ $payment->invoice_number }}</td>
                        </tr>
                        <tr>
                            <th>Date</th>
                            <td>{{ $payment->created_at->format('d M Y H:i') }}</td>
                        </tr>
                        <tr>
                            <th>Type</th>
                            <td>{{ ucfirst($payment->type) }}</td>
                        </tr>
                        <tr>
                            <th>Patient</th>
                            <td>
                                @if ($payment->type === 'examination')
                                    {{ $payment->examination->patient->name }}
                                @else
                                    {{ $payment->prescription->examination->patient->name }}
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Amount</th>
                            <td>Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <th>Payment Method</th>
                            <td>
                                @if ($payment->payment_method === 'insurance')
                                    Insurance ({{ $payment->insurance_provider }})
                                    <br>
                                    <small class="text-muted">Insurance Number: {{ $payment->insurance_number }}</small>
                                @else
                                    {{ ucfirst($payment->payment_method) }}
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                <span class="badge bg-success">{{ ucfirst($payment->status) }}</span>
                            </td>
                        </tr>
                        <tr>
                            <th>Cashier</th>
                            <td>{{ $payment->cashier->name }}</td>
                        </tr>
                    </table>
                </div>

                @if ($payment->type === 'medicine')
                    <div class="col-md-6">
                        <h4>Medicine Details</h4>
                        <table class="table">
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
                                        <td>Rp
                                            {{ number_format($detail->medicine->price * $detail->quantity, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @endforeach
                                <tr class="table-info">
                                    <th colspan="3">Total</th>
                                    <th>Rp {{ number_format($payment->amount, 0, ',', '.') }}</th>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
