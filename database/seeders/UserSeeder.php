<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Data admin yang akan dibuat
        $admins = [
            [
                'name' => 'Admin',
                'email' => 'admin@example.com',
                'password' => Hash::make('password'), // Password: password
                'role' => 'admin',
            ],

             [
                'name' => 'Kholis',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('password'), // Password: password
                'role' => 'admin',
            ],
            // Bisa tambah admin lain di sini jika perlu
        ];

        // Buat atau update data admin
        foreach ($admins as $admin) {
            User::updateOrCreate(
                ['email' => $admin['email']], // Cek berdasarkan email
                $admin // Data yang akan dimasukkan/diupdate
            );
        }
    }
}