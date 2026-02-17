<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Member;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index() {
        // small box data
        $total_buku = Book::count();
        $total_anggota = Member::count();
        $transaksi_hari_ini = Transaction::whereDate('created_at', Carbon::today())->count();
        $denda_bulan_ini = Transaction::whereMonth('actual_return_date', Carbon::now()->month)
            ->where('status', 'returned')
            ->sum('fine');

        // chart data transaksi seminggu terakhir
        $label_chart = [];
        $data_chart = [];

        for ($i=6; $i>=0 ; $i--) {
            $date = Carbon::now()->subDays($i);
            $label_chart[] = $date->format('d M');

            $count = Transaction::whereDate('created_at', $date)->count();
            $data_chart[] = $count;
        }

        // top 5 buku terlaris
        $buku_terlaris = TransactionDetail::select('book_id', DB::raw('sum(qty) as total'))
                            ->with('book')
                            ->groupBy('book_id')
                            ->orderByDesc('total')
                            ->limit(5)
                            ->get();

        // top 5 anggota rajin
        $anggota_rajin = Transaction::select('member_id', DB::raw('count(*) as total'))
                            ->with('member')
                            ->groupBy('member_id')
                            ->orderByDesc('total')
                            ->limit(5)
                            ->get();

        // riwayat peminjaman terbaru
        $transaksi_terbaru = Transaction::with('member', 'user')
                                ->latest()
                                ->limit(5)
                                ->get();

        return view('dashboard', compact(
            'total_buku',
            'total_anggota',
            'transaksi_hari_ini',
            'denda_bulan_ini',
            'label_chart',
            'data_chart',
            'buku_terlaris',
            'anggota_rajin',
            'transaksi_terbaru',
        ));
    }
}
