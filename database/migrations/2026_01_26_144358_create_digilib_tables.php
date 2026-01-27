<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Tabel users -> petugas
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('username')->unique();
            $table->string('password');
            $table->enum('role', ['admin', 'staff'])->default('staff');
            $table->timestamps();
        });

        // 2. Tabel members -> anggota
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('nim',20)->unique();
            $table->string('name');
            $table->string('phone', 15)->nullable();
            $table->text('address')->nullable();
            $table->timestamps();
        });

        // 3. Tabel books -> daftar buku
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

        // 4. Tabel transactions -> peminjaman
        Schema::create('transactions', function(Blueprint $table) {
            $table->id();
            $table->string('invoice_no', 20)->unique();
            $table->foreIgnId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreIgnId('member_id')->constrained('members')->onDelete('cascade');
            $table->date('borrow_date');
            $table->date('return_date');
            $table->date('actual_return_date')->nullable();
            $table->enum('status', ['borrowed', 'returned', 'late'])->default('borrowed');
            $table->timestamps();
        });

        // 5. Tabel transaction_details -> detail buku
        Schema::create('transactions_details', function(Blueprint $table) {
            $table->id();
            $table->foreignId('transaction_id')->constrained('transactions')->onDelete('cascade');
            $table->foreignId('book_id')->constrained('books')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_details');
        Schema::dropIfExists('transactions');
        Schema::dropIfExists('books');
        Schema::dropIfExists('members');
        Schema::dropIfExists('users');
    }
};
