<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index() {
        // hitung jumlah kategori
        $total = Category::count();

        // hitung jumlah kategori yang punya relasi->buku
        $used = Category::has('books')->count();

        // hitung kategori tanpa relasi
        $empty = Category::doesntHave('books')->count();

        $categories = Category::latest()->withCount('books')->get();

        return view('categories.index', compact('categories','total', 'used', 'empty'));
    }

    // Tambah kategori
    public function store(Request $request) {
        // Validasi data
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ], [
            // custom messages
            'name.unique' => 'Nama kategori ini sudah ada, gunakan nama lain.',
        ]);

        Category::create(['name' => $request->name]);
        return back()->with('success', 'Kategori berhasil ditambahkan');
    }

    // Edit kategori
    public function update(Request $request, Category $category) {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
        ]);

        $category->update(['name' => $request->name]);

        return back()->with('success', 'Kategori berhasil diperbarui.');
    }

    // hapus kategori
    public function destroy(Category $category) {
        try {
            $category->delete();
            return back()->with('success', 'Kategori berhasil dihapus.');
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == "23000") {
                return back()->with('error', 'Gagal menghapus! Kateogri ini sedang digunakan oleh buku. Hapus bukunya terlebih dahulu.');
            }
            return back()->with('error', 'Terjadi kesalahan sistem.');
        }
    }
}
