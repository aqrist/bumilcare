@extends('layouts.app')

@section('title', 'Add Pregnancy Record')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3>Add Pregnancy Record for {{ $patient->name }}</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('pregnancies.store', $patient) }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="first_day_of_last_period" class="form-label">First Day of Last Period</label>
                    <input type="date" class="form-control @error('first_day_of_last_period') is-invalid @enderror"
                        id="first_day_of_last_period" name="first_day_of_last_period"
                        value="{{ old('first_day_of_last_period') }}" required>
                    @error('first_day_of_last_period')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="pregnancy_count" class="form-label">Pregnancy Count</label>
                    <input type="number" class="form-control @error('pregnancy_count') is-invalid @enderror"
                        id="pregnancy_count" name="pregnancy_count" value="{{ old('pregnancy_count', 1) }}" min="1"
                        required>
                    @error('pregnancy_count')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="is_high_risk" name="is_high_risk" value="1"
                            {{ old('is_high_risk') ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_high_risk">
                            High Risk Pregnancy
                        </label>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="risk_notes" class="form-label">Risk Notes</label>
                    <textarea class="form-control @error('risk_notes') is-invalid @enderror" id="risk_notes" name="risk_notes"
                        rows="3">{{ old('risk_notes') }}</textarea>
                    @error('risk_notes')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('patients.show', $patient) }}" class="btn btn-secondary">Back</a>
                    <button type="submit" class="btn btn-primary">Save Pregnancy Record</button>
                </div>
            </form>
        </div>
    </div>
@endsection
