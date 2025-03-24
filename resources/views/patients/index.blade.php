@extends('layouts.app')

@section('title', 'Patients List')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Patients List</h1>
        <a href="{{ route('patients.create') }}" class="btn btn-primary">Add New Patient</a>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>NIK</th>
                            <th>Name</th>
                            <th>Gender</th>
                            <th>Phone</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($patients as $patient)
                            <tr>
                                <td>{{ $patient->nik }}</td>
                                <td>{{ $patient->name }}</td>
                                <td>{{ $patient->gender == 'L' ? 'Male' : 'Female' }}</td>
                                <td>{{ $patient->phone }}</td>
                                <td>{{ $patient->is_pregnant ? 'Pregnant' : 'Not Pregnant' }}</td>
                                <td>
                                    <a href="{{ route('patients.show', $patient) }}" class="btn btn-sm btn-info">View</a>
                                    <a href="{{ route('patients.edit', $patient) }}" class="btn btn-sm btn-warning">Edit</a>
                                    <form action="{{ route('patients.destroy', $patient) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"
                                            onclick="return confirm('Are you sure?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">No patients found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $patients->links() }}
        </div>
    </div>
@endsection
