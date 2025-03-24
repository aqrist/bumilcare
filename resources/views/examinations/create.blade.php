@extends('layouts.app')

@section('title', 'New Examination')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3>New Examination for {{ $patient->name }}</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('examinations.store', $queue) }}" method="POST">
                @csrf
                @if ($pregnancy)
                    <input type="hidden" name="pregnancy_id" value="{{ $pregnancy->id }}">
                @endif

                <div class="row">
                    <div class="col-md-6">
                        <h4>Physical Examination</h4>
                        <div class="mb-3">
                            <label for="weight" class="form-label">Weight (kg)</label>
                            <input type="number" step="0.1" class="form-control @error('weight') is-invalid @enderror"
                                id="weight" name="weight" value="{{ old('weight') }}">
                            @error('weight')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="height" class="form-label">Height (cm)</label>
                            <input type="number" step="0.1" class="form-control @error('height') is-invalid @enderror"
                                id="height" name="height" value="{{ old('height') }}">
                            @error('height')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="blood_pressure_systolic" class="form-label">Blood Pressure
                                        (Systolic)</label>
                                    <input type="number"
                                        class="form-control @error('blood_pressure_systolic') is-invalid @enderror"
                                        id="blood_pressure_systolic" name="blood_pressure_systolic"
                                        value="{{ old('blood_pressure_systolic') }}">
                                    @error('blood_pressure_systolic')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="blood_pressure_diastolic" class="form-label">Blood Pressure
                                        (Diastolic)</label>
                                    <input type="number"
                                        class="form-control @error('blood_pressure_diastolic') is-invalid @enderror"
                                        id="blood_pressure_diastolic" name="blood_pressure_diastolic"
                                        value="{{ old('blood_pressure_diastolic') }}">
                                    @error('blood_pressure_diastolic')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="temperature" class="form-label">Temperature (°C)</label>
                            <input type="number" step="0.1"
                                class="form-control @error('temperature') is-invalid @enderror" id="temperature"
                                name="temperature" value="{{ old('temperature') }}">
                            @error('temperature')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <h4>Clinical Examination</h4>
                        @if ($pregnancy)
                            <div class="mb-3">
                                <label for="usg_result" class="form-label">USG Result</label>
                                <textarea class="form-control @error('usg_result') is-invalid @enderror" id="usg_result" name="usg_result"
                                    rows="3">{{ old('usg_result') }}</textarea>
                                @error('usg_result')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        @endif

                        <div class="mb-3">
                            <label for="diagnosis" class="form-label">Diagnosis</label>
                            <textarea class="form-control @error('diagnosis') is-invalid @enderror" id="diagnosis" name="diagnosis" rows="3"
                                required>{{ old('diagnosis') }}</textarea>
                            @error('diagnosis')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="notes" class="form-label">Additional Notes</label>
                            <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="3">{{ old('notes') }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="need_medication" name="need_medication"
                                    value="1" {{ old('need_medication') ? 'checked' : '' }}>
                                <label class="form-check-label" for="need_medication">
                                    Need Medication
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between mt-3">
                    <a href="{{ route('queues.show', $queue) }}" class="btn btn-secondary">Back</a>
                    <button type="submit" class="btn btn-primary">Save Examination</button>
                </div>
            </form>
        </div>
    </div>
@endsection
