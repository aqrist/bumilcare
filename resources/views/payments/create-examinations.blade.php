@extends('layouts.app')

@section('title', 'Create Examination Payment')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3>Create Examination Payment</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h4>Examination Details</h4>
                    <table class="table">
                        <tr>
                            <th width="30%">Patient</th>
                            <td>{{ $examination->patient->name }}</td>
                        </tr>
                        <tr>
                            <th>Doctor</th>
                            <td>{{ $examination->doctor->name }}</td>
                        </tr>
                        <tr>
                            <th>Date</th>
                            <td>{{ $examination->created_at->format('d M Y') }}</td>
                        </tr>
                    </table>
                </div>

                <div class="col-md-6">
                    <form action="{{ route('payments.store.examination', $examination) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Invoice Number</label>
                            <input type="text" class="form-control" value="{{ $invoiceNumber }}" readonly
                                name="invoice_number">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Amount</label>
                            <input type="number" class="form-control @error('amount') is-invalid @enderror" name="amount"
                                value="{{ old('amount', $amount) }}" required>
                            @error('amount')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Payment Method</label>
                            <select name="payment_method" class="form-select @error('payment_method') is-invalid @enderror"
                                id="paymentMethod" required>
                                <option value="">Select Payment Method</option>
                                <option value="cash">Cash</option>
                                <option value="debit">Debit Card</option>
                                <option value="credit">Credit Card</option>
                                <option value="insurance">Insurance</option>
                            </select>
                            @error('payment_method')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div id="insuranceFields" style="display: none;">
                            <div class="mb-3">
                                <label class="form-label">Insurance Number</label>
                                <input type="text" class="form-control @error('insurance_number') is-invalid @enderror"
                                    name="insurance_number">
                                @error('insurance_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Insurance Provider</label>
                                <input type="text" class="form-control @error('insurance_provider') is-invalid @enderror"
                                    name="insurance_provider">
                                @error('insurance_provider')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('payments.index') }}" class="btn btn-secondary">Back</a>
                            <button type="submit" class="btn btn-primary">Process Payment</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.getElementById('paymentMethod').addEventListener('change', function() {
                const insuranceFields = document.getElementById('insuranceFields');
                insuranceFields.style.display = this.value === 'insurance' ? 'block' : 'none';
            });
        </script>
    @endpush
@endsection
