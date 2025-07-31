<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Student;
use App\Models\ClassModel;

class StudentSeeder extends Seeder
{
    public function run(): void
    {
        // Mengambil ID kelas berdasarkan nama kelas
        $class10IPA1 = ClassModel::where('name', '10 IPA 1')->firstOrFail()->id;
        $class10IPA2 = ClassModel::where('name', '10 IPA 2')->firstOrFail()->id;
        $class10IPS1 = ClassModel::where('name', '10 IPS 1')->firstOrFail()->id;
        $class11IPA1 = ClassModel::where('name', '11 IPA 1')->firstOrFail()->id;
        $class11IPA2 = ClassModel::where('name', '11 IPA 2')->firstOrFail()->id;
        $class11IPS1 = ClassModel::where('name', '11 IPS 1')->firstOrFail()->id;
        $class12IPA1 = ClassModel::where('name', '12 IPA 1')->firstOrFail()->id;
        $class12IPS1 = ClassModel::where('name', '12 IPS 1')->firstOrFail()->id;

        $students = [
            [
                'name' => 'Ahmad Fauzi',
                'nis' => '1234567890',
                'class_id' => $class10IPA1,
                'birth_date' => '2007-08-15',
                'address' => 'Jl. Merdeka No. 10',
            ],
            [
                'name' => 'Siti Rahma',
                'nis' => '1234567891',
                'class_id' => $class10IPA2,
                'birth_date' => '2007-09-10',
                'address' => 'Jl. Kenanga No. 22',
            ],
            [
                'name' => 'Budi Santoso',
                'nis' => '1234567892',
                'class_id' => $class11IPS1,
                'birth_date' => '2006-11-20',
                'address' => 'Jl. Mawar No. 5',
            ],
            [
                'name' => 'Rina Amelia',
                'nis' => '1234567893',
                'class_id' => $class10IPS1,
                'birth_date' => '2007-12-05',
                'address' => 'Jl. Anggrek No. 15',
            ],
            [
                'name' => 'Dedi Pratama',
                'nis' => '1234567894',
                'class_id' => $class11IPA1,
                'birth_date' => '2006-03-22',
                'address' => 'Jl. Melati No. 8',
            ],
            [
                'name' => 'Lina Sari',
                'nis' => '1234567895',
                'class_id' => $class11IPA2,
                'birth_date' => '2006-07-14',
                'address' => 'Jl. Flamboyan No. 12',
            ],
            [
                'name' => 'Eko Nugroho',
                'nis' => '1234567896',
                'class_id' => $class12IPA1,
                'birth_date' => '2005-05-30',
                'address' => 'Jl. Kamboja No. 3',
            ],
            [
                'name' => 'Fitriani Dewi',
                'nis' => '1234567897',
                'class_id' => $class12IPS1,
                'birth_date' => '2005-09-25',
                'address' => 'Jl. Teratai No. 7',
            ],
            [
                'name' => 'Rudi Hartono',
                'nis' => '1234567898',
                'class_id' => $class10IPA1,
                'birth_date' => '2007-04-18',
                'address' => 'Jl. Cendana No. 9',
            ],
            [
                'name' => 'Maya Putri',
                'nis' => '1234567899',
                'class_id' => $class11IPS1,
                'birth_date' => '2006-02-10',
                'address' => 'Jl. Dahlia No. 20',
            ],
        ];

        foreach ($students as $student) {
            Student::create($student);
        }
    }
}