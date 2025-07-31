<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin Utama',
            'email' => 'admin@example.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'photo' => null,
            'sign' => null,
        ]);

        User::create([
            'name' => 'Guru Pertama',
            'email' => 'guru@example.com',
            'password' => Hash::make('password123'),
            'role' => 'guru',
            'photo' => null,
            'sign' => null,
        ]);

        User::create([
            'name' => 'Wali Kelas',
            'email' => 'wali_kelas@example.com',
            'password' => Hash::make('password123'),
            'role' => 'wali_kelas',
            'photo' => null,
            'sign' => null,
        ]);

        User::create([
            'name' => 'Kepala Sekolah',
            'email' => 'kepsek@example.com',
            'password' => Hash::make('password123'),
            'role' => 'kepala_sekolah',
            'photo' => null,
            'sign' => null,
        ]);
    }
}
