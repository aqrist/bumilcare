<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Examination;
use Illuminate\Support\Str;
use App\Models\Prescription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::latest()->paginate(10);
        return view('payments.index', compact('payments'));
    }

    public function createExaminationPayment(Examination $examination)
    {
        // Cek apakah sudah ada pembayaran
        if ($examination->payment) {
            return redirect()->route('payments.show', $examination->payment->id);
        }

        // Buat invoice number
        $invoiceNumber = 'INV-' . date('Ymd') . '-' . Str::random(6);

        // Biaya pemeriksaan default (bisa disesuaikan berdasarkan jenis layanan)
        $amount = 150000;

        return view('payments.create-examination', compact('examination', 'invoiceNumber', 'amount'));
    }

    public function createPrescriptionPayment(Prescription $prescription)
    {
        // Cek apakah sudah ada pembayaran
        if ($prescription->payment) {
            return redirect()->route('payments.show', $prescription->payment->id);
        }

        // Buat invoice number
        $invoiceNumber = 'INV-' . date('Ymd') . '-' . Str::random(6);

        // Hitung total biaya obat
        $amount = 0;
        foreach ($prescription->details as $detail) {
            $amount += $detail->medicine->price * $detail->quantity;
        }

        return view('payments.create-prescription', compact('prescription', 'invoiceNumber', 'amount'));
    }

    public function storeExaminationPayment(Request $request, Examination $examination)
    {
        $request->validate([
            'invoice_number' => 'required|string|unique:payments',
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|in:cash,debit,credit,insurance',
            'insurance_number' => 'nullable|required_if:payment_method,insurance',
            'insurance_provider' => 'nullable|required_if:payment_method,insurance'
        ]);

        $payment = Payment::create([
            'invoice_number' => $request->invoice_number,
            'type' => 'examination',
            'examination_id' => $examination->id,
            'prescription_id' => null,
            'amount' => $request->amount,
            'payment_method' => $request->payment_method,
            'insurance_number' => $request->insurance_number,
            'insurance_provider' => $request->insurance_provider,
            'status' => 'paid',
            'cashier_id' => Auth::user()->id
        ]);

        return redirect()->route('payments.show', $payment->id)
            ->with('success', 'Pembayaran berhasil dicatat.');
    }

    public function storePrescriptionPayment(Request $request, Prescription $prescription)
    {
        $request->validate([
            'invoice_number' => 'required|string|unique:payments',
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|in:cash,debit,credit,insurance',
            'insurance_number' => 'nullable|required_if:payment_method,insurance',
            'insurance_provider' => 'nullable|required_if:payment_method,insurance'
        ]);

        $payment = Payment::create([
            'invoice_number' => $request->invoice_number,
            'type' => 'medicine',
            'examination_id' => null,
            'prescription_id' => $prescription->id,
            'amount' => $request->amount,
            'payment_method' => $request->payment_method,
            'insurance_number' => $request->insurance_number,
            'insurance_provider' => $request->insurance_provider,
            'status' => 'paid',
            'cashier_id' => Auth::user()->id
        ]);

        return redirect()->route('payments.show', $payment->id)
            ->with('success', 'Pembayaran berhasil dicatat.');
    }

    public function show(Payment $payment)
    {
        return view('payments.show', compact('payment'));
    }

    public function print(Payment $payment)
    {
        return view('payments.print', compact('payment'));
    }
}
