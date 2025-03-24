@extends('layouts.app')

@section('title', 'Create New Queue')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3>Create New Queue</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('queues.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="patient_id" class="form-label">Patient</label>
                    <select class="form-select @error('patient_id') is-invalid @enderror" id="patient_id" name="patient_id"
                        required>
                        <option value="">Select Patient</option>
                        @foreach ($patients as $patient)
                            <option value="{{ $patient->id }}" {{ old('patient_id') == $patient->id ? 'selected' : '' }}>
                                {{ $patient->name }} - {{ $patient->nik }}
                            </option>
                        @endforeach
                    </select>
                    @error('patient_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="doctor_id" class="form-label">Doctor</label>
                    <select class="form-select @error('doctor_id') is-invalid @enderror" id="doctor_id" name="doctor_id"
                        required>
                        <option value="">Select Doctor</option>
                        @foreach ($doctors as $doctor)
                            <option value="{{ $doctor->id }}" {{ old('doctor_id') == $doctor->id ? 'selected' : '' }}>
                                {{ $doctor->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('doctor_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="service_type" class="form-label">Service Type</label>
                    <select class="form-select @error('service_type') is-invalid @enderror" id="service_type"
                        name="service_type" required>
                        <option value="">Select Service Type</option>
                        @foreach ($serviceTypes as $type)
                            <option value="{{ $type }}" {{ old('service_type') == $type ? 'selected' : '' }}>
                                {{ $type }}
                            </option>
                        @endforeach
                    </select>
                    @error('service_type')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="queue_date" class="form-label">Queue Date</label>
                    <input type="date" class="form-control @error('queue_date') is-invalid @enderror" id="queue_date"
                        name="queue_date" value="{{ old('queue_date', date('Y-m-d')) }}" required>
                    @error('queue_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('queues.index') }}" class="btn btn-secondary">Back</a>
                    <button type="submit" class="btn btn-primary">Create Queue</button>
                </div>
            </form>
        </div>
    </div>
@endsection
