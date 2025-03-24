<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use App\Models\Examination;
use Illuminate\Support\Str;
use App\Models\Prescription;
use Illuminate\Http\Request;
use App\Models\PrescriptionDetail;
use Illuminate\Support\Facades\Auth;

class PrescriptionController extends Controller
{
    public function create(Examination $examination)
    {
        $medicines = Medicine::orderBy('name')->get();
        return view('prescriptions.create', compact('examination', 'medicines'));
    }

    public function store(Request $request, Examination $examination)
    {
        $request->validate([
            'medicine_id' => 'required|array',
            'medicine_id.*' => 'exists:medicines,id',
            'quantity' => 'required|array',
            'quantity.*' => 'integer|min:1',
            'dosage' => 'required|array',
            'dosage.*' => 'string',
            'instructions' => 'required|array',
            'instructions.*' => 'string'
        ]);

        // Generate nomor resep unik
        $prescriptionNumber = 'RX-' . date('Ymd') . '-' . Str::random(6);

        // Buat resep baru
        $prescription = Prescription::create([
            'examination_id' => $examination->id,
            'prescription_number' => $prescriptionNumber,
            'status' => 'created',
            'pharmacist_id' => null
        ]);

        // Simpan detail resep
        for ($i = 0; $i < count($request->medicine_id); $i++) {
            PrescriptionDetail::create([
                'prescription_id' => $prescription->id,
                'medicine_id' => $request->medicine_id[$i],
                'quantity' => $request->quantity[$i],
                'dosage' => $request->dosage[$i],
                'instructions' => $request->instructions[$i]
            ]);
        }

        return redirect()->route('prescriptions.show', $prescription->id)
            ->with('success', 'Resep berhasil dibuat.');
    }

    public function show(Prescription $prescription)
    {
        return view('prescriptions.show', compact('prescription'));
    }

    public function print(Prescription $prescription)
    {
        return view('prescriptions.print', compact('prescription'));
    }

    public function pharmacyList()
    {
        $prescriptions = Prescription::whereIn('status', ['created', 'processed'])
            ->latest()
            ->paginate(10);

        return view('prescriptions.pharmacy', compact('prescriptions'));
    }

    public function process(Prescription $prescription)
    {
        $prescription->update([
            'status' => 'processed',
            'pharmacist_id' => Auth::user()->id,
        ]);

        return redirect()->route('prescriptions.pharmacy')
            ->with('success', 'Resep sedang diproses.');
    }

    public function complete(Prescription $prescription)
    {
        $prescription->update([
            'status' => 'completed'
        ]);

        // Kurangi stok obat
        foreach ($prescription->details as $detail) {
            $medicine = $detail->medicine;
            $medicine->update([
                'stock' => $medicine->stock - $detail->quantity
            ]);
        }

        return redirect()->route('prescriptions.pharmacy')
            ->with('success', 'Resep telah selesai diproses.');
    }
}
