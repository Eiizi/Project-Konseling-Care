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
            Schema::table('users', function (Blueprint $table) {
                // Tambahkan kolom baru setelah 'role'
                $table->integer('age')->nullable()->after('role');
                $table->string('gender')->nullable()->after('age'); // Misal: 'pria', 'wanita'
                $table->string('phone_number')->nullable()->after('gender');
                $table->string('photo_path')->nullable()->after('phone_number'); // Path untuk foto profil
            });
        }

    /**
     * Reverse the migrations.
     */
    public function down(): void
        {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn(['age', 'gender', 'phone_number', 'photo_path']);
            });
        }
};
