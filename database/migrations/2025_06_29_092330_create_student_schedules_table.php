<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Membuat tabel student_schedules untuk relasi many-to-many antara siswa dan jadwal
    public function up(): void
    {
        Schema::create('student_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->onDelete('cascade'); // ID siswa dengan relasi ke tabel students
            $table->foreignId('schedule_id')->constrained()->onDelete('cascade'); // ID jadwal dengan relasi ke tabel schedules
            $table->timestamps(); // Kolom created_at dan updated_at

            // Memastikan kombinasi student_id dan schedule_id unik
            $table->unique(['student_id', 'schedule_id']);
        });
    }

    // Menghapus tabel student_schedules jika ada
    public function down(): void
    {
        Schema::dropIfExists('student_schedules');
    }
};