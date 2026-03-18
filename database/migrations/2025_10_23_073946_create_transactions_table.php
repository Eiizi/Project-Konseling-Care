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
        Schema::create('transactions', function (Blueprint $table) {
        $table->id();
        $table->foreignId('appointment_id')->constrained('appointments')->onDelete('cascade');
        $table->decimal('amount', 10, 2); // Jumlah pembayaran
        $table->string('payment_method')->nullable(); // Misal: 'Transfer Bank', 'E-Wallet'
        $table->string('status')->default('pending'); // pending, paid, verified, failed
        $table->string('transaction_code')->nullable()->unique(); // Kode unik transaksi
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
