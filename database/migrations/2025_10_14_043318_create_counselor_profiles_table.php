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
        Schema::create('counselor_profiles', function (Blueprint $table) {
            $table->id(); // Kolom ID auto-increment (primary key)

            // Kolom untuk relasi ke tabel users
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            $table->string('photo')->nullable(); // Kolom untuk path foto, boleh kosong
            $table->text('specializations')->nullable(); // Keahlian (bisa panjang), boleh kosong
            $table->integer('experience_years')->default(0); // Pengalaman dalam tahun
            $table->text('bio')->nullable(); // Deskripsi singkat/bio, boleh kosong
            $table->string('certificate_url')->nullable(); // Link ke sertifikat
            $table->boolean('is_verified')->default(false); // Status verifikasi oleh admin

            $table->timestamps(); // Kolom created_at dan updated_at
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('counselor_profiles');
    }
};
