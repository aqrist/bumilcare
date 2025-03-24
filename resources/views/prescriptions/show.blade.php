@extends('layouts.app')

@section('title', 'Prescription Details')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3>Prescription #{{ $prescription->prescription_number }}</h3>
            <div>
                <a href="{{ route('prescriptions.print', $prescription) }}" class="btn btn-info" target="_blank">Print</a>
                <a href="{{ route('examinations.show', $prescription->examination) }}" class="btn btn-secondary">Back</a>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table">
                        <tr>
                            <th width="30%">Patient Name</th>
                            <td>{{ $prescription->examination->patient->name }}</td>
                        </tr>
                        <tr>
                            <th>Doctor</th>
                            <td>{{ $prescription->examination->doctor->name }}</td>
                        </tr>
                        <tr>
                            <th>Date</th>
                            <td>{{ $prescription->created_at->format('d M Y H:i') }}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                @switch($prescription->status)
                                    @case('created')
                                        <span class="badge bg-info">Created</span>
                                    @break

                                    @case('processed')
                                        <span class="badge bg-warning">Processing</span>
                                    @break

                                    @case('completed')
                                        <span class="badge bg-success">Completed</span>
                                    @break
                                @endswitch
                            </td>
                        </tr>
                    </table>
                </div>

                @if ($prescription->pharmacist)
                    <div class="col-md-6">
                        <table class="table">
                            <tr>
                                <th width="30%">Pharmacist</th>
                                <td>{{ $prescription->pharmacist->name }}</td>
                            </tr>
                            <tr>
                                <th>Process Date</th>
                                <td>{{ $prescription->updated_at->format('d M Y H:i') }}</td>
                            </tr>
                        </table>
                    </div>
                @endif
            </div>

            <h4 class="mt-4">Medicines</h4>
            <div class="table-responsive">
                <table class="table table-striped">
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
        </div>
    </div>
@endsection
