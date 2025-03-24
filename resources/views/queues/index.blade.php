@extends('layouts.app')

@section('title', 'Queue Management')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Queue Management</h1>
        <a href="{{ route('queues.create') }}" class="btn btn-primary">Add New Queue</a>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Queue Number</th>
                            <th>Patient</th>
                            <th>Doctor</th>
                            <th>Service Type</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($queues as $queue)
                            <tr>
                                <td>{{ substr($queue->queue_number, -3) }}</td>
                                <td>{{ $queue->patient->name }}</td>
                                <td>{{ $queue->doctor->name }}</td>
                                <td>{{ $queue->service_type }}</td>
                                <td>
                                    @switch($queue->status)
                                        @case('waiting')
                                            <span class="badge bg-warning">Waiting</span>
                                        @break

                                        @case('in_progress')
                                            <span class="badge bg-primary">In Progress</span>
                                        @break

                                        @case('completed')
                                            <span class="badge bg-success">Completed</span>
                                        @break

                                        @case('cancelled')
                                            <span class="badge bg-danger">Cancelled</span>
                                        @break
                                    @endswitch
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('queues.show', $queue) }}" class="btn btn-sm btn-info">View</a>
                                        @if ($queue->status == 'waiting')
                                            <form action="{{ route('queues.updateStatus', $queue) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="in_progress">
                                                <button type="submit" class="btn btn-sm btn-primary">Start</button>
                                            </form>
                                        @elseif($queue->status == 'in_progress')
                                            <form action="{{ route('queues.updateStatus', $queue) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="completed">
                                                <button type="submit" class="btn btn-sm btn-success">Complete</button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">No queues found for today.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                {{ $queues->links() }}
            </div>
        </div>
    @endsection
