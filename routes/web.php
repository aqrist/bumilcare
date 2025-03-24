<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QueueController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PregnancyController;
use App\Http\Controllers\ExaminationController;
use App\Http\Controllers\PrescriptionController;

Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes();

// Add this debug route temporarily
Route::get('/debug-role', function () {
    $user = Auth::user()->id;
    dd([
        'user' => $user->name,
        'email' => $user->email,
        'roles' => $user->roles->pluck('name'),
        'has_admin' => $user->hasRole('admin'),
        'has_doctor' => $user->hasRole('doctor'),
        'has_nurse' => $user->hasRole('nurse'),
    ]);
})->middleware('auth');


// Rute untuk halaman dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');

// Display antrean (public)
Route::get('queues/display', [QueueController::class, 'queueDisplay'])->name('queues.display');

// Grup rute untuk admin, dokter, perawat, apoteker, dan kasir
Route::middleware(['auth'])->group(function () {
    // Manajemen pasien (admin, dokter, perawat)
    Route::middleware(['role:admin,doctor,nurse'])->group(function () {
        Route::resource('patients', PatientController::class);
        Route::get('patients/{patient}/pregnancies/create', [PregnancyController::class, 'create'])->name('pregnancies.create');
        Route::post('patients/{patient}/pregnancies', [PregnancyController::class, 'store'])->name('pregnancies.store');
    });

    // Data kehamilan (admin, dokter, perawat)
    Route::middleware(['role:admin,doctor,nurse'])->group(function () {
        Route::get('pregnancies/{pregnancy}', [PregnancyController::class, 'show'])->name('pregnancies.show');
        Route::get('pregnancies/{pregnancy}/edit', [PregnancyController::class, 'edit'])->name('pregnancies.edit');
        Route::put('pregnancies/{pregnancy}', [PregnancyController::class, 'update'])->name('pregnancies.update');
    });

    // Manajemen antrean (admin, perawat)
    Route::middleware(['role:admin,nurse,doctor'])->group(function () {
        Route::resource('queues', QueueController::class)->except(['edit', 'update', 'destroy']);
        Route::put('queues/{queue}/status', [QueueController::class, 'updateStatus'])->name('queues.updateStatus');
    });

    // Pemeriksaan (dokter)
    Route::middleware(['role:doctor'])->group(function () {
        Route::get('queues/{queue}/examinations/create', [ExaminationController::class, 'create'])->name('examinations.create');
        Route::post('queues/{queue}/examinations', [ExaminationController::class, 'store'])->name('examinations.store');
        Route::get('examinations/{examination}', [ExaminationController::class, 'show'])->name('examinations.show');
        Route::get('examinations/{examination}/print', [ExaminationController::class, 'print'])->name('examinations.print');
        Route::get('patients/{patient}/history', [ExaminationController::class, 'history'])->name('examinations.history');
    });

    // Resep (dokter)
    Route::middleware(['role:doctor'])->group(function () {
        Route::get('examinations/{examination}/prescriptions/create', [PrescriptionController::class, 'create'])->name('prescriptions.create');
        Route::post('examinations/{examination}/prescriptions', [PrescriptionController::class, 'store'])->name('prescriptions.store');
    });

    // Detail resep (dokter, apoteker)
    Route::middleware(['role:doctor,pharmacist'])->group(function () {
        Route::get('prescriptions/{prescription}', [PrescriptionController::class, 'show'])->name('prescriptions.show');
        Route::get('prescriptions/{prescription}/print', [PrescriptionController::class, 'print'])->name('prescriptions.print');
    });

    // Pengelolaan obat (apoteker)
    Route::middleware(['role:pharmacist'])->group(function () {
        Route::get('pharmacy', [PrescriptionController::class, 'pharmacyList'])->name('prescriptions.pharmacy');
        Route::put('prescriptions/{prescription}/process', [PrescriptionController::class, 'process'])->name('prescriptions.process');
        Route::put('prescriptions/{prescription}/complete', [PrescriptionController::class, 'complete'])->name('prescriptions.complete');
        Route::resource('medicines', MedicineController::class);
    });

    // Pembayaran (kasir)
    Route::middleware(['role:cashier'])->group(function () {
        Route::get('payments', [PaymentController::class, 'index'])->name('payments.index');
        Route::get('examinations/{examination}/payments/create', [PaymentController::class, 'createExaminationPayment'])->name('payments.create.examination');
        Route::post('examinations/{examination}/payments', [PaymentController::class, 'storeExaminationPayment'])->name('payments.store.examination');
        Route::get('prescriptions/{prescription}/payments/create', [PaymentController::class, 'createPrescriptionPayment'])->name('payments.create.prescription');
        Route::post('prescriptions/{prescription}/payments', [PaymentController::class, 'storePrescriptionPayment'])->name('payments.store.prescription');
        Route::get('payments/{payment}', [PaymentController::class, 'show'])->name('payments.show');
        Route::get('payments/{payment}/print', [PaymentController::class, 'print'])->name('payments.print');
    });
});
