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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number')->unique();
            $table->enum('type', ['examination', 'medicine', 'both']);
            $table->foreignId('examination_id')->nullable()->constrained();
            $table->foreignId('prescription_id')->nullable()->constrained();
            $table->decimal('amount', 10, 2);
            $table->enum('payment_method', ['cash', 'debit', 'credit', 'insurance']);
            $table->string('insurance_number')->nullable();
            $table->string('insurance_provider')->nullable();
            $table->enum('status', ['pending', 'paid', 'cancelled']);
            $table->foreignId('cashier_id')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
