<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
         // Buat tabel books -> daftar buku
        Schema::create('books', function(Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('author');
            $table->string('category', 50)->nullable();
            $table->integer('stock')->default(0);
            $table->string('isbn', 20)->unique()->nullable();
            $table->integer('pages')->nullable();
            $table->string('language', 50)->nullable();
            $table->text('description')->nullable();
            $table->string('cover_image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
