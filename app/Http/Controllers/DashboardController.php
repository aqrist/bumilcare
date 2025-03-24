<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Queue;
use App\Models\Payment;
use App\Models\Examination;
use App\Models\Prescription;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        // Data untuk dashboard
        $todayPatients = Queue::where('queue_date', $today->format('Y-m-d'))->count();
        $todayExaminations = Examination::whereDate('created_at', $today)->count();
        $todayPrescriptions = Prescription::whereDate('created_at', $today)->count();
        $todayIncome = Payment::whereDate('created_at', $today)->where('status', 'paid')->sum('amount');

        $waitingQueues = Queue::where('queue_date', $today->format('Y-m-d'))
            ->where('status', 'waiting')
            ->with('patient')
            ->get();

        $inProgressQueues = Queue::where('queue_date', $today->format('Y-m-d'))
            ->where('status', 'in_progress')
            ->with(['patient', 'doctor'])
            ->get();

        // Data grafik untuk 7 hari terakhir
        $last7Days = [];
        $dailyPatients = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = $today->copy()->subDays($i);
            $last7Days[] = $date->format('d/m');

            $count = Queue::whereDate('queue_date', $date->format('Y-m-d'))->count();
            $dailyPatients[] = $count;
        }

        return view('dashboard', compact(
            'todayPatients',
            'todayExaminations',
            'todayPrescriptions',
            'todayIncome',
            'waitingQueues',
            'inProgressQueues',
            'last7Days',
            'dailyPatients'
        ));
    }
}
