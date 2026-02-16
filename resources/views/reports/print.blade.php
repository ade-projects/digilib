<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Laporan Perpustakaan</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">
    <style>
        @media print {
            .no-print {
                display: none;
            }
        }

        body {
            background-color: white;
            font-family: sans-serif;
        }
    </style>
</head>

<body onload="window.print()">
    <div class="container mt-4">
        <h2 class="text-center mb-4">LAPORAN PERPUSTAKAAN</h2>
        <h5 class="text-center mb-4">
            Periode: {{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} s/d
            {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}
        </h5>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tgl Pinjam</th>
                    <th>Tgl Kembali</th>
                    <th>Peminjam</th>
                    <th>Buku</th>
                    <th>Denda</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transactions as $trx)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ \Carbon\Carbon::parse($trx->borrow_date)->format('d/m/Y') }}</td>
                        <td>
                            {{ $trx->actual_return_date ? \Carbon\Carbon::parse($trx->actual_return_date)->format('d/m/Y') : '-' }}
                        </td>
                        <td>
                            {{ $trx->member->name }}
                        </td>
                        <td>
                            @foreach ($trx->details as $detail)
                                - {{ $detail->book->title }} ({{ $detail->qty }})<br>
                            @endforeach
                        </td>
                        <td>Rp {{ number_format($trx->fine) }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="5" class="text-right">Total Pendapatan Denda</th>
                    <th>Rp {{ number_format($total_denda) }}</th>
                </tr>
            </tfoot>
        </table>

        <div class="row mt-5">
            <div class="col-4 offset-8 text-center">
                <p>Cilacap, {{ date('d F Y') }}</p>
                <br><br><br>
                <p><u>Administrator</u></p>
            </div>
        </div>
    </div>


</body>

</html>