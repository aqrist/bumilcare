@extends('layouts.app')

@section('title', 'Examination History')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3>Examination History - {{ $patient->name }}</h3>
            <a href="{{ route('patients.show', $patient) }}" class="btn btn-secondary">Back to Patient</a>
        </div>
        <div class="card-body">
            @if ($examinations->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Doctor</th>
                                <th>Diagnosis</th>
                                <th>Pregnancy Week</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($examinations as $examination)
                                <tr>
                                    <td>{{ $examination->created_at->format('d M Y') }}</td>
                                    <td>{{ $examination->doctor->name }}</td>
                                    <td>{{ Str::limit($examination->diagnosis, 50) }}</td>
                                    <td>
                                        @if ($examination->pregnancy)
                                            Week {{ $examination->pregnancy->week }}
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td>
                                        @if ($examination->prescription)
                                            @if ($examination->prescription->status === 'completed')
                                                <span class="badge bg-success">Completed</span>
                                            @elseif($examination->prescription->status === 'processing')
                                                <span class="badge bg-warning">Processing</span>
                                            @else
                                                <span class="badge bg-info">Prescribed</span>
                                            @endif
                                        @else
                                            <span class="badge bg-secondary">No Prescription</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('examinations.show', $examination) }}"
                                                class="btn btn-sm btn-info">View</a>
                                            <a href="{{ route('examinations.print', $examination) }}"
                                                class="btn btn-sm btn-secondary" target="_blank">Print</a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $examinations->links() }}
            @else
                <div class="text-center">
                    <p class="text-muted">No examination records found.</p>
                </div>
            @endif
        </div>
    </div>
@endsection
