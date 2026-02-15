<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Member;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    // tampil daftar transaksi
    public function index() {
        // ambil data transaksi
        $transactions = Transaction::with(['member', 'user', 'details.book'])
            ->latest()
            ->get();

        // hitung data small box
        $total_transaksi = Transaction::count();
        $sedang_dipinjam = Transaction::where('status', 'borrowed')->count();
        $selesai = Transaction::where('status', 'returned')->count();

        $terlambat = Transaction::where('status', 'borrowed')
                        ->whereDate('return_date', '<', Carbon::now())
                        ->count();

        return view('transactions.index', compact('transactions', 'total_transaksi', 'sedang_dipinjam', 'selesai', 'terlambat'));
    }

    // form peminjaman baru
    public function create()
    {
        $members = Member::all();
        $books = Book::where('stock', '>', 0)->get();

        return view('transactions.create', compact('members', 'books'));
    }

    // proses simpan peminjaman
    public function store(Request $request) {
        // 1. Validasi
        $request->validate([
            'member_id' => 'required|exists:members,id',
            'book_ids' => 'required|array',
            'book_ids.*' => 'exists:books,id',
            'quantities' => 'required|array',
            'quantities.*' => 'integer|min:1', 
        ]);

        // 2. Gunakan DB transaction
        try {
            DB::beginTransaction();
            // cek stok 
            foreach ($request->book_ids as $index => $book_id) {
                $book = Book::find($book_id);
                $qty_diminta = $request->quantities[$index];

                if ($book->stock < $qty_diminta) {
                    return back()->with('error', "Stok buku '{$book->title}' tidak cukup! (Sisa: {$book->stock}, Diminta: {$qty_diminta})")->withInput();
                }
            }

            // buat header transaksi
            $transaction = Transaction::create([
                'invoice_no' => 'TRX-' . time(),
                'user_id' => Auth::id(), 
                'member_id' => $request->member_id,
                'borrow_date' => Carbon::now(),
                'return_date' => Carbon::now()->addDays(7),
                'status' => 'borrowed',
                'fine' => 0,
            ]);

            // Proses detail buku & kurangi stok
            foreach ($request->book_ids as $index => $book_id) {
                $qty = $request->quantities[$index];
                
                TransactionDetail::create([
                    'transaction_id' => $transaction->id,
                    'book_id' => $book_id,
                    'qty' => $qty,
                ]);

                Book::where('id', $book_id)->decrement('stock', $qty);
            }

            DB::commit();

            return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil disimpan!');
        
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memproses transaksi.');
        }
    }

    // Detail transaksi
    public function show($id) {
        $transaction = Transaction::with(['member', 'user', 'details.book'])->findOrFail($id);
        return response()->json($transaction);
    }

    // proses pengembalian buku
    public function update(Request $request, $id) {
        $transaction = Transaction::with('details.book')->findOrFail($id);

        if ($transaction->status == 'returned') {
            return back()->with('error', 'Transaksi ini sudah dikembalikan sebelumnya!');
        }

        try {
            DB::beginTransaction();

            // hitung denda
            $returnDate = Carbon::now();
            $dueDate = Carbon::parse($transaction->return_date);

            $denda = 0;

            if ($returnDate->gt($dueDate)) {
                $hariTelat = $returnDate->diffInDays($dueDate);
                $totalBuku = $transaction->details->sum('qty');

                $denda = $hariTelat * 1000 * $totalBuku;
            }

            // kembalikan stok buku
            foreach ($transaction->details as $detail) {
                $detail->book->increment('stock', $detail->qty);
            }

            // update status transaksi
            $transaction->update([
                'status' => 'returned',
                'actual_return_date' => $returnDate,
                'fine' => $denda,
            ]);

            DB::commit();

            // pesan feedback
            if ($denda > 0) {
                return back()->with('warning', 'Buku dikembalikan. Anggota terkena denda Rp ' . number_format($denda));
            }

            return back()->with('success', 'Buku berhasil dikembalikan. Tidak ada denda.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan sistem.');
        }
    }

    // hapus transaksi
    public function destroy($id) {
        $transaction = Transaction::with('details')->findOrFail($id);

        try {
            DB::beginTransaction();

            if ($transaction->status !== 'returned') {
                foreach ($transaction->details as $detail) {
                    Book::where('id', $detail->book_id)->increment('stock', $detail->qty);
                }
            }

            $transaction->delete();

            DB::commit();
            return back()->with('success', 'Riwayat transaksi dihapus dan stok buku telah dikembalikan.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menghapus data.');
        }
    }
}
