<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Exports\TransactionExport;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function index(Request $request) {
        // set default tanggal
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->toDateString());

        $transactions = Transaction::with(['member', 'details.book', 'user'])
            ->whereBetween('borrow_date', [$startDate, $endDate])
            ->latest()
            ->get();

        $total_denda = $transactions->sum('fine');
        $total_transaksi = $transactions->count();
        $buku_dipinjam = $transactions->flatMap(function($t) {
            return $t->details;
        })->sum('qty');

        $buku_kembali = $transactions->where('status', 'returned')->count();
        $buku_telat = $transactions->where('status', 'returned')->where('fine', '>', 0)->count();

        return view('reports.index', compact(
            'transactions',
            'startDate',
            'endDate',
            'total_denda',
            'total_transaksi',
            'buku_dipinjam',
            'buku_kembali',
            'buku_telat',
        ));
    }

    public function print(Request $request) {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $transactions = Transaction::with(['member', 'details.book'])
            ->whereBetween('borrow_date', [$startDate, $endDate])
            ->get();

        $total_denda = $transactions->sum('fine');

        return view('reports.print', compact('transactions', 'startDate', 'endDate', 'total_denda'));
    }

    public function exportExcel(Request $request) {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $filename = 'Laporan-' . $startDate . '-sd-' . $endDate . '.xlsx';

        return Excel::download(new TransactionExport($startDate, $endDate), $filename);
    }
}
