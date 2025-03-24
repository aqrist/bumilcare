@extends('layouts.app')

@section('title', 'Pregnancy Details')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3>Pregnancy Details for {{ $pregnancy->patient->name }}</h3>
            <div>
                <a href="{{ route('pregnancies.edit', $pregnancy) }}" class="btn btn-warning">Edit</a>
                <a href="{{ route('patients.show', $pregnancy->patient) }}" class="btn btn-secondary">Back to Patient</a>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table">
                        <tr>
                            <th width="40%">First Day of Last Period</th>
                            <td>{{ $pregnancy->first_day_of_last_period->format('d M Y') }}</td>
                        </tr>
                        <tr>
                            <th>Estimated Due Date</th>
                            <td>{{ $pregnancy->estimated_due_date->format('d M Y') }}</td>
                        </tr>
                        <tr>
                            <th>Current Week</th>
                            <td>Week {{ $pregnancy->week }}</td>
                        </tr>
                        <tr>
                            <th>Pregnancy Count</th>
                            <td>{{ $pregnancy->pregnancy_count }}</td>
                        </tr>
                        <tr>
                            <th>Risk Status</th>
                            <td>
                                @if ($pregnancy->is_high_risk)
                                    <span class="badge bg-danger">High Risk</span>
                                @else
                                    <span class="badge bg-success">Normal</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                @if ($pregnancy->is_active)
                                    <span class="badge bg-primary">Active</span>
                                @else
                                    <span class="badge bg-secondary">Inactive</span>
                                @endif
                            </td>
                        </tr>
                        @if ($pregnancy->risk_notes)
                            <tr>
                                <th>Risk Notes</th>
                                <td>{{ $pregnancy->risk_notes }}</td>
                            </tr>
                        @endif
                    </table>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5>Examination History</h5>
                        </div>
                        <div class="card-body">
                            @if ($pregnancy->examinations && $pregnancy->examinations->count() > 0)
                                <ul class="list-group">
                                    @foreach ($pregnancy->examinations as $examination)
                                        <li class="list-group-item">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span>{{ $examination->examination_date->format('d M Y') }}</span>
                                                <a href="{{ route('examinations.show', $examination) }}"
                                                    class="btn btn-sm btn-info">View Details</a>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="text-muted">No examination records found.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
