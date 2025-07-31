<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Subject;

class SubjectSeeder extends Seeder
{
    public function run()
    {
        Subject::create([
            'name' => 'Matematika',
            'code' => 'MAT01',
            'description' => 'Pelajaran Matematika',
        ]);

        Subject::create([
            'name' => 'Bahasa Indonesia',
            'code' => 'BIN01',
            'description' => 'Pelajaran Bahasa Indonesia',
        ]);

        Subject::create([
            'name' => 'Bahasa Inggris',
            'code' => 'ENG01',
            'description' => 'Pelajaran Bahasa Inggris',
        ]);
    }
}