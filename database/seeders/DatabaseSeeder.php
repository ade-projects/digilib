<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // memanggil seeder
        $this->call([
            userSeeder::class,
            memberSeeder::class,
            CategorySeeder::class,
            bookSeeder::class,
        ]);
    }
}
