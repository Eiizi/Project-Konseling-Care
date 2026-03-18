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
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('counselor_id')->constrained('users')->onDelete('cascade'); // ID Konselor
            $table->string('day_of_week'); // Misal: 'Monday', 'Tuesday', dll.
            $table->time('start_time'); // Jam mulai tersedia
            $table->time('end_time');   // Jam selesai tersedia
            $table->timestamps();

            // Pastikan kombinasi konselor, hari, dan jam mulai unik
            $table->unique(['counselor_id', 'day_of_week', 'start_time']); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
