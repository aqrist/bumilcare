@extends('layouts.app')

@section('title', 'Queue Details')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3>Queue Details #{{ substr($queue->queue_number, -3) }}</h3>
            <a href="{{ route('queues.index') }}" class="btn btn-secondary">Back to Queue List</a>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table">
                        <tr>
                            <th width="30%">Queue Number</th>
                            <td>{{ $queue->queue_number }}</td>
                        </tr>
                        <tr>
                            <th>Patient Name</th>
                            <td>{{ $queue->patient->name }}</td>
                        </tr>
                        <tr>
                            <th>Doctor</th>
                            <td>{{ $queue->doctor->name }}</td>
                        </tr>
                        <tr>
                            <th>Service Type</th>
                            <td>{{ $queue->service_type }}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
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
                        </tr>
                    </table>

                    <div class="mt-4">
                        @if (auth()->user()->hasRole('doctor') && $queue->status === 'waiting')
                            <a href="{{ route('examinations.create', $queue) }}" class="btn btn-primary">
                                Start Examination
                            </a>
                        @endif

                        @if (auth()->user()->hasRole('nurse') && $queue->status === 'waiting')
                            <form action="{{ route('queues.updateStatus', $queue) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="cancelled">
                                <button type="submit" class="btn btn-danger"
                                    onclick="return confirm('Are you sure you want to cancel this queue?')">
                                    Cancel Queue
                                </button>
                            </form>
                        @endif
                    </div>
                </div>

                @if ($queue->examination)
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header bg-info text-white">
                                <h5 class="mb-0">Examination Details</h5>
                            </div>
                            <div class="card-body">
                                <p><strong>Date:</strong> {{ $queue->examination->created_at->format('d M Y H:i') }}</p>
                                <p><strong>Doctor:</strong> {{ $queue->examination->doctor->name }}</p>
                                <a href="{{ route('examinations.show', $queue->examination) }}" class="btn btn-info">View
                                    Examination</a>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
