@extends('layouts.app')
@section('title', 'Laporan Bulanan')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <h1 class="m-0">Laporan Peminjaman</h1>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">

            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">Filter Periode</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('reports.index') }}" method="get">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Dari Tanggal</label>
                                    <input type="date" name="start_date" class="form-control" value="{{ $startDate }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Sampai Tanggal</label>
                                    <input type="date" name="end_date" class="form-control" value="{{ $endDate }}">
                                </div>
                            </div>
                            <div class="col-md-4 d-flex align-items-end">
                                <div class="form-group w-100">
                                    <button type="submit" class="btn btn-primary"><i class="fas fa-filter">
                                            Filter</i></button>
                                    <a href="{{ route('reports.export_excel', ['start_date' => $startDate, 'end_date' => $endDate]) }}"
                                        class="btn btn-success">
                                        <i class="fas fa-file-excel"> Excel</i>
                                    </a>
                                    <a href="{{ route('reports.print', ['start_date' => $startDate, 'end_date' => $endDate]) }}"
                                        target="_blank" class="btn btn-danger float-right"><i class="fas fa-print"></i>
                                        Cetak PDF</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1"><i class="fas fa-file-invoice"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total Transaksi</span>
                            <span class="info-box-number">{{ $total_transaksi }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-success elevation-1"><i class="fas fa-book"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Buku Keluar</span>
                            <span class="info-box-number">{{ $buku_dipinjam }} Eks</span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-coins"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total Denda</span>
                            <span class="info-box-number">Rp {{ number_format($total_denda) }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-clock"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Kasus Telat</span>
                            <span class="info-box-number">{{ $buku_telat }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Detail Laporan</h3>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Peminjam</th>
                                <th>Buku (Jml)</th>
                                <th>Status</th>
                                <th>Denda</th>
                                <th>Petugas</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($transactions as $trx)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ \Carbon\Carbon::parse($trx->borrow_date)->format('d/m/Y') }}</td>
                                    <td>{{ $trx->member->name }} <br><small class="text-muted">{{ $trx->member->nim }}</small>
                                    </td>
                                    <td>
                                        <ul class="pl-3 mb-0">
                                            @foreach ($trx->details as $detail)
                                                <li>{{ $detail->book->title }} ({{ $detail->qty }})</li>
                                            @endforeach
                                        </ul>
                                    </td>
                                    <td>
                                        @if ($trx->status == 'returned')
                                            <span class="badge badge-success">Kembali</span><br>
                                            <small>{{ $trx->actual_return_date ? \Carbon\Carbon::parse($trx->actual_return_date)->format('d/m/Y') : '-' }}</small>
                                        @else
                                            <span class="badge badge-warning">Dipinjam</span>
                                        @endif
                                    </td>
                                    <td>Rp {{ number_format($trx->fine) }}</td>
                                    <td>{{ $trx->user->name ?? 'System' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">Tidak ada data pada periode ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection