<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Patient;
use App\Models\Pregnancy;
use Illuminate\Http\Request;

class PregnancyController extends Controller
{
    public function create(Patient $patient)
    {
        return view('pregnancies.create', compact('patient'));
    }

    public function store(Request $request, Patient $patient)
    {
        $request->validate([
            'first_day_of_last_period' => 'required|date',
            'pregnancy_count' => 'required|integer|min:1',
            'is_high_risk' => 'boolean',
            'risk_notes' => 'nullable|string'
        ]);

        // Hitung perkiraan tanggal lahir (hari pertama haid terakhir + 280 hari)
        $firstDay = Carbon::parse($request->first_day_of_last_period);
        $estimatedDueDate = $firstDay->copy()->addDays(280);

        // Hitung usia kehamilan dalam minggu
        $now = Carbon::now();
        $pregnancyWeek = $now->diffInDays($firstDay) / 7;

        // Nonaktifkan kehamilan aktif lainnya
        $patient->pregnancies()->where('is_active', true)->update(['is_active' => false]);

        // Buat catatan kehamilan baru
        $pregnancy = new Pregnancy([
            'first_day_of_last_period' => $request->first_day_of_last_period,
            'estimated_due_date' => $estimatedDueDate,
            'pregnancy_count' => $request->pregnancy_count,
            'week' => floor($pregnancyWeek),
            'is_high_risk' => $request->is_high_risk ?? false,
            'risk_notes' => $request->risk_notes,
            'is_active' => true
        ]);

        $patient->pregnancies()->save($pregnancy);
        $patient->update(['is_pregnant' => true]);

        return redirect()->route('patients.show', $patient->id)
            ->with('success', 'Data kehamilan berhasil ditambahkan.');
    }

    public function show(Pregnancy $pregnancy)
    {
        return view('pregnancies.show', compact('pregnancy'));
    }

    public function edit(Pregnancy $pregnancy)
    {
        return view('pregnancies.edit', compact('pregnancy'));
    }

    public function update(Request $request, Pregnancy $pregnancy)
    {
        $request->validate([
            'first_day_of_last_period' => 'required|date',
            'pregnancy_count' => 'required|integer|min:1',
            'is_high_risk' => 'boolean',
            'risk_notes' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        // Hitung perkiraan tanggal lahir (hari pertama haid terakhir + 280 hari)
        $firstDay = Carbon::parse($request->first_day_of_last_period);
        $estimatedDueDate = $firstDay->copy()->addDays(280);

        // Hitung usia kehamilan dalam minggu
        $now = Carbon::now();
        $pregnancyWeek = $now->diffInDays($firstDay) / 7;

        $pregnancy->update([
            'first_day_of_last_period' => $request->first_day_of_last_period,
            'estimated_due_date' => $estimatedDueDate,
            'pregnancy_count' => $request->pregnancy_count,
            'week' => floor($pregnancyWeek),
            'is_high_risk' => $request->is_high_risk ?? false,
            'risk_notes' => $request->risk_notes,
            'is_active' => $request->is_active ?? false
        ]);

        // Jika kehamilan ini menjadi aktif, nonaktifkan yang lainnya
        if ($request->is_active) {
            $patient = $pregnancy->patient;
            $patient->pregnancies()
                ->where('id', '!=', $pregnancy->id)
                ->where('is_active', true)
                ->update(['is_active' => false]);

            $patient->update(['is_pregnant' => true]);
        }

        return redirect()->route('pregnancies.show', $pregnancy->id)
            ->with('success', 'Data kehamilan berhasil diperbarui.');
    }
}
