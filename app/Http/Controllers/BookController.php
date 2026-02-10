<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BookController extends Controller
{
    public function index() {
        $total_buku = Book::count();
        $total_stok = Book::sum('stock');
        $stok_tipis = Book::where('stock', '<', 5)->count();
        $buku_baru = Book::whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->count();
        
        $books = Book::with('category')->latest()->get();
        return view('books.index', compact('books', 'total_buku', 'total_stok', 'stok_tipis', 'buku_baru'));
    }

    // tampil form tambah buku
    public function create() {
        $categories = Category::all();
        return view('books.create', compact('categories'));
    }

    // simpan data buku baru
    public function store(Request $request) {
        // validasi data
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id', 
            'stock' => 'required|integer|min:0',
            'isbn' => 'required|string|max:20',
            'pages' => 'nullable|integer',
            'language' => 'nullable|string|max:50',
            'description' => 'nullable|string',
            'cover_image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        try {
            // upload gambar
            $coverPath = null;
            if ($request->hasFile('cover_image')) {
                $coverPath = $request->file('cover_image')->store('covers', 'public');
            }

            // simpan data
            Book::create([
                'title' => $request->title,
                'author' => $request->author,
                'category_id' => $request->category_id,
                'stock' => $request->stock,
                'isbn' => $request->isbn,
                'pages' => $request->pages,
                'language' => $request->language,
                'description' => $request->description,
                'cover_image' => $coverPath,
            ]);

            return redirect()->route('books.index')->with('success', 'Buku berhasil ditambahkan.');

        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat menyimpan data.');
        }
    }

    // tampil detail buku
    public function show($id) {
        $book = Book::with('category')->findOrFail($id);
        return response()->json($book);
    }

    // tampil form edit
    public function edit(Book $book) {
        $categories = Category::all();
        return view('books.edit', compact('book', 'categories'));
    }

    // update data buku
    public function update(Request $request, Book $book) {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id', 
            'stock' => 'required|integer|min:0',
            'isbn' => 'required|string|max:20',
            'pages' => 'nullable|integer',
            'language' => 'nullable|string|max:50',
            'description' => 'nullable|string',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        try {
            $data = $request->except('cover_image');

            if ($request->hasFile('cover_image')) {
                if ($book->cover_image && Storage::disk('public')->exists($book->cover_image)) {
                    Storage::disk('public')->exists($book->cover);
                }

                $path = $request->file('cover_image')->store('covers', 'public');

                $data['cover_image'] = $path;
            }

            $book->update($data);

            return redirect()->route('books.index')->with('success', 'Data buku berhasil diperbarui.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal update data.');
        }
    }

    // hapus buku
    public function destroy(Book $book) {
        try {
            if ($book->cover_image && Storage::disk('public')->exists($book->cover_image)) {
                Storage::disk('public')->delete($book->cover_image);
            }

            $book->delete();

            return back()->with('success', 'Buku berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus buku.');
        }
    }
}
