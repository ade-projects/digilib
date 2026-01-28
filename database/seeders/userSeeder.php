<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class userSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // 1. Membuat akun admin
        User::create([
            'name' => 'Administrator',
            'username' => 'admin',
            'password' => Hash::make('P@ssw0rd'),
            'role' => 'admin',
        ]);

        // 2. Membuat akun staff
        User::create([
            'name' => 'Staff Perpustakaan',
            'username' => 'staff',
            'password' => Hash::make('P@ssw0rd'),
            'role' => 'staff',
        ]);
    }
}
