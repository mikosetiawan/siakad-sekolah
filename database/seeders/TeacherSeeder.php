<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Teacher;
use App\Models\Subject;

class TeacherSeeder extends Seeder
{
    public function run(): void
    {
        // Retrieve subject IDs based on subject names
        $matematika = Subject::where('name', 'Matematika')->firstOrFail();
        $bahasaIndonesia = Subject::where('name', 'Bahasa Indonesia')->firstOrFail();
        $fisika = Subject::where('name', 'Fisika')->first();

        $teachers = [
            [
                'name'       => 'Ibu Rina Marlina',
                'nip'        => '198001012005042001',
                'subject_id' => $matematika->id,
                'phone'      => '081234567890',
                'email'      => 'rina.marlina@example.com',
            ],
            [
                'name'       => 'Bapak Dedi Suhendar',
                'nip'        => '197512102006011003',
                'subject_id' => $fisika ? $fisika->id : $matematika->id, // Fallback to Matematika if Fisika not found
                'phone'      => '082345678901',
                'email'      => 'dedi.suhendar@example.com',
            ],
            [
                'name'       => 'Ibu Lilis Suryani',
                'nip'        => '198304152007022005',
                'subject_id' => $bahasaIndonesia->id,
                'phone'      => '083456789012',
                'email'      => 'lilis.suryani@example.com',
            ],
        ];

        foreach ($teachers as $teacher) {
            Teacher::create($teacher);
        }
    }
}