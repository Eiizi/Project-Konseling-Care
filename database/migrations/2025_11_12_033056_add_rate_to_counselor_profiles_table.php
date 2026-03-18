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
        //rupiah nominal
        Schema::table('counselor_profiles', function (Blueprint $table) {
            $table->decimal('rate', 10, 2)->default(100000.00)->after('is_verified');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('counselor_profiles', function (Blueprint $table) {
            //
        });
    }
};
