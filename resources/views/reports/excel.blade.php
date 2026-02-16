<table>
    <thead>
        <tr>
            <th colspan="6" style="text-align: center; font-weight: bold;">
                LAPORAN PERPUSTAKAAN ({{ $startDate }} s/d {{ $endDate }})
            </th>
        </tr>
        <tr>
            <th style="font-weight: bold; border: 1px solid black;">No</th>
            <th style="font-weight: bold; border: 1px solid black;">Tgl Pinjam</th>
            <th style="font-weight: bold; border: 1px solid black;">Tgl Kembali</th>
            <th style="font-weight: bold; border: 1px solid black;">Peminjam</th>
            <th style="font-weight: bold; border: 1px solid black;">Buku (Qty)</th>
            <th style="font-weight: bold; border: 1px solid black;">Denda</th>
            <th style="font-weight: bold; border: 1px solid black;">Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($transactions as $trx)
            <tr>
                <td style="border: 1px solid black;">{{ $loop->iteration }}</td>
                <td style="border: 1px solid black;">{{ $trx->borrow_date }}</td>
                <td style="border: 1px solid black;">{{ $trx->actual_return_date ?? '-' }}</td>
                <td style="border: 1px solid black;">{{ $trx->member->name }}</td>
                <td style="border: 1px solid black;">
                    @foreach ($trx->details as $detail)
                        {{ $detail->book->title }} ({{ $detail->qty }})
                    @endforeach
                </td>
                <td style="border: 1px solid black;">{{ $trx->fine}}</td>
                <td style="border: 1px solid black;">
                    {{ $trx->status == 'returned' ? 'Kembali' : 'Dipinjam'}}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>