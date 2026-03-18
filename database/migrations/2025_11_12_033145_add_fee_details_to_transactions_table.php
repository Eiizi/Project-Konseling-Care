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
        Schema::table('transactions', function (Blueprint $table) {
            // Ganti nama ammount
            $table->renameColumn('amount', 'total_amount'); 
            
            // Tambahkan kolom baru
            $table->decimal('base_price', 10, 2)->after('id'); // Harga asli konselor
            $table->decimal('admin_fee', 10, 2)->after('base_price'); // Potongan 30%
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            //
        });
    }
};
