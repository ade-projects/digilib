<?php

namespace App\Exports;

use App\Models\Transaction;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Phpoffice\PhpSpreadsheet\Worksheet\Worksheet;

class TransactionExport implements FromView, ShouldAutoSize, WithStyles
{
    protected $startDate;
    protected $endDate;

    public function __construct($startDate, $endDate) {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function view(): View {
        return view('reports.excel', [
            'transactions' => Transaction::with(['member', 'details.book', 'user'])
                ->whereBetween('borrow_date', [$this->startDate, $this->endDate])
                ->latest()
                ->get(),
            'startDate' => $this->startDate,
            'endDate' => $this->endDate
        ]);
    }

    public function styles(Worksheet $sheet) {
        return [
            // baris 1 -> header judul
            1 => ['font' => ['bold' => true, 'size' => 14]],
            // baris 2 -> header tabel
            2 => ['font' => ['bold' => true]],
        ];
    }
}
