@extends('layouts.app')

@section('title', 'Patient Details')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3>Patient Details</h3>
            <div>
                <a href="{{ route('patients.edit', $patient) }}" class="btn btn-warning">Edit</a>
                <a href="{{ route('patients.index') }}" class="btn btn-secondary">Back</a>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table">
                        <tr>
                            <th width="30%">NIK</th>
                            <td>{{ $patient->nik }}</td>
                        </tr>
                        <tr>
                            <th>Name</th>
                            <td>{{ $patient->name }}</td>
                        </tr>
                        <tr>
                            <th>Birth Date</th>
                            <td>{{ $patient->birth_date }}</td>
                        </tr>
                        <tr>
                            <th>Gender</th>
                            <td>{{ $patient->gender == 'L' ? 'Male' : 'Female' }}</td>
                        </tr>
                        <tr>
                            <th>Address</th>
                            <td>{{ $patient->address }}</td>
                        </tr>
                        <tr>
                            <th>Phone</th>
                            <td>{{ $patient->phone }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ $patient->email ?: '-' }}</td>
                        </tr>
                        <tr>
                            <th>Blood Type</th>
                            <td>{{ $patient->blood_type ?: '-' }}</td>
                        </tr>
                        <tr>
                            <th>Pregnancy Status</th>
                            <td>{{ $patient->is_pregnant ? 'Pregnant' : 'Not Pregnant' }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5>Pregnancy History</h5>
                        </div>
                        <div class="card-body">
                            @if ($patient->pregnancies && $patient->pregnancies->count() > 0)
                                <ul class="list-group">
                                    @foreach ($patient->pregnancies as $pregnancy)
                                        <li class="list-group-item">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span>Pregnancy #{{ $loop->iteration }}</span>
                                                <a href="{{ route('pregnancies.show', $pregnancy) }}"
                                                    class="btn btn-sm btn-info">View Details</a>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="text-muted">No pregnancy records found.</p>
                            @endif

                            @if ($patient->gender == 'P')
                                <div class="mt-3">
                                    <a href="{{ route('pregnancies.create', $patient) }}" class="btn btn-primary">Add
                                        Pregnancy Record</a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
