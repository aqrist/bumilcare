@extends('layouts.app')

@section('title', 'Payment History')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3>Payment History</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Invoice #</th>
                            <th>Date</th>
                            <th>Type</th>
                            <th>Patient</th>
                            <th>Amount</th>
                            <th>Method</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($payments as $payment)
                            <tr>
                                <td>{{ $payment->invoice_number }}</td>
                                <td>{{ $payment->created_at->format('d M Y') }}</td>
                                <td>{{ ucfirst($payment->type) }}</td>
                                <td>
                                    @if ($payment->type === 'examination')
                                        {{ $payment->examination->patient->name }}
                                    @else
                                        {{ $payment->prescription->examination->patient->name }}
                                    @endif
                                </td>
                                <td>Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                                <td>
                                    @if ($payment->payment_method === 'insurance')
                                        Insurance ({{ $payment->insurance_provider }})
                                    @else
                                        {{ ucfirst($payment->payment_method) }}
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-success">{{ ucfirst($payment->status) }}</span>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('payments.show', $payment) }}" class="btn btn-sm btn-info">View</a>
                                        <a href="{{ route('payments.print', $payment) }}" class="btn btn-sm btn-secondary"
                                            target="_blank">Print</a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">No payment records found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $payments->links() }}
        </div>
    </div>
@endsection
