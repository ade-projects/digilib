<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Daftar kategori populer
        $categories = [
            'Novel & Fiksi',
            'Komik & Manga',
            'Sains & Teknologi',
            'Biografi',
            'Ensiklopedia',
            'Agama & Filsafat',
            'Bisnis & Ekonomi', 
            'Pendidikan & Pelajaran',
            'Majalah',
            'Kamus',
            'Otobiografi',
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category
            ]);
        }
    }
}
