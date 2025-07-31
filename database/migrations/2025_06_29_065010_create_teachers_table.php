<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    // Membuat tabel teachers
    public function up(): void
    {
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('nip')->unique();
            $table->foreignId('subject_id')->constrained()->onDelete('restrict');
            $table->string('phone');
            $table->string('email')->unique();
            $table->timestamps();
        });
    }

    // Menghapus tabel teachers jika ada
    public function down(): void
    {
        Schema::dropIfExists('teachers');
    }
};