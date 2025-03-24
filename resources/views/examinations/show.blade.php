@extends('layouts.app')

@section('title', 'Examination Details')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3>Examination Details</h3>
            <div>
                <a href="{{ route('examinations.print', $examination) }}" class="btn btn-info" target="_blank">Print</a>
                @if ($examination->need_medication && !$examination->prescription)
                    <a href="{{ route('prescriptions.create', $examination) }}" class="btn btn-primary">Create
                        Prescription</a>
                @endif
                <a href="{{ route('examinations.history', $examination->patient) }}" class="btn btn-secondary">Back to
                    History</a>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h4>Patient Information</h4>
                    <table class="table">
                        <tr>
                            <th width="30%">Name</th>
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

                    <h4 class="mt-4">Physical Examination</h4>
                    <table class="table">
                        <tr>
                            <th width="30%">Weight</th>
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
                                    {{ $examination->blood_pressure_systolic }}/{{ $examination->blood_pressure_diastolic }}
                                    mmHg
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

                <div class="col-md-6">
                    <h4>Clinical Examination</h4>
                    @if ($examination->pregnancy)
                        <div class="mb-3">
                            <label class="fw-bold">USG Result</label>
                            <p>{{ $examination->usg_result ?: 'No USG result recorded' }}</p>
                        </div>
                    @endif

                    <div class="mb-3">
                        <label class="fw-bold">Diagnosis</label>
                        <p>{{ $examination->diagnosis }}</p>
                    </div>

                    <div class="mb-3">
                        <label class="fw-bold">Additional Notes</label>
                        <p>{{ $examination->notes ?: 'No additional notes' }}</p>
                    </div>

                    @if ($examination->prescription)
                        <div class="card mt-3">
                            <div class="card-header bg-info text-white">
                                <h5 class="mb-0">Prescription</h5>
                            </div>
                            <div class="card-body">
                                <a href="{{ route('prescriptions.show', $examination->prescription) }}"
                                    class="btn btn-primary">View Prescription</a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
