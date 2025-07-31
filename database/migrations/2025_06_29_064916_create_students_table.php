<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    // Membuat tabel students
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('nis')->unique();
            $table->foreignId('class_id')->constrained('classes')->onDelete('cascade');
            $table->date('birth_date');
            $table->text('address');
            $table->timestamps();
        });
    }

    // Menghapus tabel students jika ada
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};