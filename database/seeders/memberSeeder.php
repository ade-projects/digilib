<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Member;

class memberSeeder extends Seeder
{
    use WithoutModelEvents;
    
    public function run(): void
    {
        // 1. Membuat member dummy
        Member::create([
            'nim' => '12345678',
            'name' => 'Budi Santoso',
            'phone' => '08123456789',
            'address' => 'Jl. Cendana No. 17',
        ]);
    }
}
