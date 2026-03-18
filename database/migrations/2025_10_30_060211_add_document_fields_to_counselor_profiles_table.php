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
    Schema::table('counselor_profiles', function (Blueprint $table) {
        $table->string('cv_url')->nullable()->after('certificate_url');
        $table->string('identity_url')->nullable()->after('cv_url');
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
