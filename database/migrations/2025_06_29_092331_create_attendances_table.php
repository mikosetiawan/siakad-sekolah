<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    // Membuat tabel attendances
    public function up(): void
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('schedule_id')->constrained()->onDelete('cascade');
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->date('date');
            $table->enum('status', ['Hadir', 'Tidak Hadir', 'Terlambat', 'Izin']);
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    // Menghapus tabel attendances jika ada
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};