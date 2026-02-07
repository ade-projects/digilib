<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Book;
use App\Models\Category;

class bookSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $novel = Category::where('name', 'Novel & Fiksi')->first();
        $bio = Category::where('name', 'Otobiografi')->first();

        if (!$novel || !$bio) {
            $this->command->error('Error: Kategori tidak ditemukan! Jalankan CategorySeeder dulu.');
            return;
        }
        
        // 1. Dummy buku
        Book::create([
            'title' => 'Laskar Pelangi',
            'author' => 'Andrea Hirata',
            'category_id' => $novel->id,
            'stock' => 10,
            'isbn' => '979-3062-79-7',
            'pages' => '529',
            'language' => 'Indonesia',
            'description' => 'Laskar Pelangi karya Andrea Hirata adalah novel inspiratif yang menceritakan perjuangan sepuluh anak dari keluarga miskin di Belitung yang bersekolah di SD Muhammadiyah, sebuah sekolah sederhana yang hampir ditutup karena kekurangan murid. Dengan latar kehidupan penuh keterbatasan, mereka tetap bersemangat menuntut ilmu berkat dedikasi dua guru luar biasa, Bu Muslimah dan Pak Harfan. Kisah ini menyoroti persahabatan, mimpi, dan optimisme anak-anak yang tak pernah padam meski menghadapi berbagai rintangan, sekaligus menjadi potret indah tentang kekuatan pendidikan dan harapan di tengah kesederhanaan.',
            'cover_image' => 'laskar_pelangi.jpg',
        ]);
                
        // 2. Dummy buku
        Book::create([
            'title' => 'Mein Kampf',
            'author' => 'Adolf Hitler',
            'category_id' => $bio->id,
            'stock' => 1,
            'isbn' => '978-0395951057',
            'pages' => '720',
            'language' => 'Jerman',
            'description' => 'Mein Kampf adalah buku yang ditulis oleh Adolf Hitler pada tahun 1925–1926 yang berisi otobiografi sekaligus manifesto politiknya. Dalam buku ini, Hitler menceritakan pengalaman hidupnya, pandangan ideologis, serta rencana politik yang kelak menjadi dasar bagi gerakan Nazi di Jerman. Ia menuliskan gagasan tentang nasionalisme ekstrem, antisemitisme, dan keyakinan akan superioritas ras Arya, yang kemudian digunakan sebagai justifikasi kebijakan diskriminatif dan agresif pada masa kekuasaannya. Buku ini dianggap berbahaya karena menyebarkan ideologi kebencian, namun juga penting secara historis sebagai dokumen yang menjelaskan asal-usul pemikiran Nazi dan dampaknya terhadap sejarah dunia.',
            'cover_image' => 'mein_kampf.jpeg',
        ]);
    }
}
