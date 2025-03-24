<?php

namespace App\Http\Controllers;

use App\Models\Queue;
use App\Models\Patient;
use App\Models\Examination;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExaminationController extends Controller
{
    public function create(Queue $queue)
    {
        $patient = $queue->patient;
        $pregnancy = $patient->activePregnancy;

        return view('examinations.create', compact('queue', 'patient', 'pregnancy'));
    }

    public function store(Request $request, Queue $queue)
    {
        $request->validate([
            'weight' => 'nullable|numeric',
            'height' => 'nullable|numeric',
            'blood_pressure_systolic' => 'nullable|integer',
            'blood_pressure_diastolic' => 'nullable|integer',
            'temperature' => 'nullable|numeric',
            'usg_result' => 'nullable|string',
            'diagnosis' => 'required|string',
            'notes' => 'nullable|string',
            'need_medication' => 'boolean'
        ]);

        $examination = Examination::create([
            'queue_id' => $queue->id,
            'patient_id' => $queue->patient_id,
            'pregnancy_id' => $request->pregnancy_id,
            'doctor_id' => Auth::user()->id,
            'weight' => $request->weight,
            'height' => $request->height,
            'blood_pressure_systolic' => $request->blood_pressure_systolic,
            'blood_pressure_diastolic' => $request->blood_pressure_diastolic,
            'temperature' => $request->temperature,
            'usg_result' => $request->usg_result,
            'diagnosis' => $request->diagnosis,
            'notes' => $request->notes,
            'need_medication' => $request->need_medication ?? false
        ]);

        // Update status antrean
        $queue->update(['status' => 'completed']);

        if ($request->need_medication) {
            return redirect()->route('prescriptions.create', $examination->id);
        }

        return redirect()->route('examinations.show', $examination->id)
            ->with('success', 'Hasil pemeriksaan berhasil disimpan.');
    }

    public function show(Examination $examination)
    {
        return view('examinations.show', compact('examination'));
    }

    public function print(Examination $examination)
    {
        return view('examinations.print', compact('examination'));
    }

    public function history(Patient $patient)
    {
        $examinations = $patient->examinations()->latest()->paginate(10);
        return view('examinations.history', compact('patient', 'examinations'));
    }
}
