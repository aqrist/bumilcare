<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Queue;
use App\Models\Patient;
use Illuminate\Http\Request;

class QueueController extends Controller
{
    public function index()
    {
        $today = Carbon::today()->format('Y-m-d');
        $queues = Queue::where('queue_date', $today)
            ->orderBy('status', 'asc')
            ->orderBy('created_at', 'asc')
            ->paginate(10);

        return view('queues.index', compact('queues'));
    }

    public function create()
    {
        $patients = Patient::orderBy('name')->get();
        $doctors = User::role('doctor')->orderBy('name')->get();
        $serviceTypes = ['Check-up Kehamilan', 'Konsultasi Umum', 'USG'];

        return view('queues.create', compact('patients', 'doctors', 'serviceTypes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:users,id',
            'service_type' => 'required|string',
            'queue_date' => 'required|date'
        ]);

        // Generate nomor antrian
        $today = Carbon::parse($request->queue_date)->format('Y-m-d');
        $lastQueue = Queue::where('queue_date', $today)->latest()->first();

        $queueNumber = 1;
        if ($lastQueue) {
            $lastNumber = (int)substr($lastQueue->queue_number, -3);
            $queueNumber = $lastNumber + 1;
        }

        $formattedNumber = str_pad($queueNumber, 3, '0', STR_PAD_LEFT);
        $queueCode = Carbon::parse($request->queue_date)->format('Ymd') . $formattedNumber;

        $queue = Queue::create([
            'patient_id' => $request->patient_id,
            'doctor_id' => $request->doctor_id,
            'service_type' => $request->service_type,
            'queue_date' => $request->queue_date,
            'queue_number' => $queueCode,
            'status' => 'waiting'
        ]);

        return redirect()->route('queues.show', $queue->id)
            ->with('success', 'Pendaftaran antrian berhasil.');
    }

    public function show(Queue $queue)
    {
        return view('queues.show', compact('queue'));
    }

    public function updateStatus(Request $request, Queue $queue)
    {
        $request->validate([
            'status' => 'required|in:waiting,in_progress,completed,cancelled'
        ]);

        $queue->update(['status' => $request->status]);

        return redirect()->route('queues.index')
            ->with('success', 'Status antrian berhasil diperbarui.');
    }

    public function queueDisplay()
    {
        $today = Carbon::today()->format('Y-m-d');
        $waitingQueues = Queue::where('queue_date', $today)
            ->where('status', 'waiting')
            ->orderBy('created_at')
            ->get();

        $inProgressQueues = Queue::where('queue_date', $today)
            ->where('status', 'in_progress')
            ->with('doctor')
            ->get();

        return view('queues.display', compact('waitingQueues', 'inProgressQueues'));
    }
}
