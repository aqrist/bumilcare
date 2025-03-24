<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('examinations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('queue_id')->constrained();
            $table->foreignId('patient_id')->constrained();
            $table->foreignId('pregnancy_id')->nullable()->constrained();
            $table->foreignId('doctor_id')->constrained('users');
            $table->float('weight')->nullable();
            $table->float('height')->nullable();
            $table->integer('blood_pressure_systolic')->nullable();
            $table->integer('blood_pressure_diastolic')->nullable();
            $table->float('temperature')->nullable();
            $table->string('usg_result')->nullable();
            $table->text('diagnosis');
            $table->text('notes')->nullable();
            $table->boolean('need_medication')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('examinations');
    }
};
