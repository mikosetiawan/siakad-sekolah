<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ClassModel;

class ClassSeeder extends Seeder
{
    public function run(): void
    {
        $classes = [
            [
                'name' => '10 IPA 1',
                'code' => 'IPA101',
                'description' => 'Kelas 10 Ilmu Pengetahuan Alam 1',
            ],
            [
                'name' => '10 IPA 2',
                'code' => 'IPA102',
                'description' => 'Kelas 10 Ilmu Pengetahuan Alam 2',
            ],
            [
                'name' => '10 IPS 1',
                'code' => 'IPS101',
                'description' => 'Kelas 10 Ilmu Pengetahuan Sosial 1',
            ],
            [
                'name' => '11 IPA 1',
                'code' => 'IPA111',
                'description' => 'Kelas 11 Ilmu Pengetahuan Alam 1',
            ],
            [
                'name' => '11 IPA 2',
                'code' => 'IPA112',
                'description' => 'Kelas 11 Ilmu Pengetahuan Alam 2',
            ],
            [
                'name' => '11 IPS 1',
                'code' => 'IPS111',
                'description' => 'Kelas 11 Ilmu Pengetahuan Sosial 1',
            ],
            [
                'name' => '12 IPA 1',
                'code' => 'IPA121',
                'description' => 'Kelas 12 Ilmu Pengetahuan Alam 1',
            ],
            [
                'name' => '12 IPS 1',
                'code' => 'IPS121',
                'description' => 'Kelas 12 Ilmu Pengetahuan Sosial 1',
            ],
        ];

        foreach ($classes as $class) {
            ClassModel::create($class);
        }
    }
}