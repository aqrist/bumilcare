@extends('layouts.app')

@section('title', 'Pharmacy Queue')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3>Pharmacy Queue</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Prescription #</th>
                            <th>Patient</th>
                            <th>Doctor</th>
                            <th>Status</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($prescriptions as $prescription)
                            <tr>
                                <td>{{ $prescription->prescription_number }}</td>
                                <td>{{ $prescription->examination->patient->name }}</td>
                                <td>{{ $prescription->examination->doctor->name }}</td>
                                <td>
                                    @switch($prescription->status)
                                        @case('created')
                                            <span class="badge bg-info">Created</span>
                                        @break

                                        @case('processed')
                                            <span class="badge bg-warning">Processing</span>
                                        @break
                                    @endswitch
                                </td>
                                <td>{{ $prescription->created_at->format('d M Y H:i') }}</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('prescriptions.show', $prescription) }}"
                                            class="btn btn-sm btn-info">View</a>

                                        @if ($prescription->status === 'created')
                                            <form action="{{ route('prescriptions.process', $prescription) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-sm btn-primary">
                                                    Process
                                                </button>
                                            </form>
                                        @elseif($prescription->status === 'processed')
                                            <form action="{{ route('prescriptions.complete', $prescription) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-sm btn-success">
                                                    Complete
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">No prescriptions in queue</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                {{ $prescriptions->links() }}
            </div>
        </div>
    @endsection
