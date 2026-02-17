@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <h1 class="m-0">Dashboard Perpustakaan</h1>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $total_buku }}</h3>
                            <p>Total Judul Buku</p>
                        </div>
                        <div class="icon"><i class="fas fa-book"></i></div>
                        <a href="{{ route('books.index') }}" class="small-box-footer">Lihat Detail <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ $total_anggota }}</h3>
                            <p>Anggota Terdaftar</p>
                        </div>
                        <div class="icon"><i class="fas fa-users"></i></div>
                        <a href="{{ route('members.index') }}" class="small-box-footer">Lihat Detail <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ $transaksi_hari_ini }}</h3>
                            <p>Transaksi Hari Ini</p>
                        </div>
                        <div class="icon"><i class="fas fa-exchange-alt"></i></div>
                        <a href="{{ route('transactions.index') }}" class="small-box-footer">Lihat Detail <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>Rp {{ number_format($denda_bulan_ini / 1000, 0) }}k</h3>
                            <p>Denda Bulan Ini</p>
                        </div>
                        <div class="icon"><i class="fas fa-money-bill-wave"></i></div>
                        <a href="{{ route('reports.index') }}" class="small-box-footer">Lihat Detail <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>

            <div class="row">
                <section class="col-lg-7 connectedSortable">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-chart-pie mr-1"></i>
                                Tren Peminjaman (7 Hari Terakhir)
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="tab-content p-0">
                                <canvas id="revenue-chart-canvas" height="300" style="height: 300px;"></canvas>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="col-lg-5 connectedSortable">
                    <div class="card bg-gradient-primary">
                        <div class="card-header border-0">
                            <h3 class="card-title">
                                <i class="fas fa-medal mr-1"></i>
                                Anggota Paling Rajin
                            </h3>
                        </div>
                        <div class="card-body pt-0">
                            <table class="table table-borderless text-white">
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th class="text-right">Total Pinjam</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($anggota_rajin as $member)
                                        <tr>
                                            <td>{{ $member->member->name }}</td>
                                            <td class="text-right font-weight-bold">{{ $member->total }}x</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Buku Terpopuler</h3>
                        </div>
                        <div class="card-body p-0">
                            <ul class="products-list product-list-in-card pl-2 pr-2">
                                @foreach ($buku_terlaris as $item)
                                    <li class="item">
                                        <div class="product-img d-flex align-items-center justify-content-center bg-light rounded"
                                            style="width: 50px; height: 50px;">
                                            <i class="fas fa-book fa-lg text-secondary"></i>
                                        </div>
                                        <div class="product-info">
                                            <a href="javascript:void(0)" class="product-title">{{ $item->book->title }} <span
                                                    class="badge badge-info float-right">{{ $item->total }} Dipinjam</span></a>
                                            <span class="product-description">Penulis: {{ $item->book->author }}</span>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </section>
            </div>

            <div class="card">
                <div class="card-header border-transparent">
                    <h3 class="card-title">Riwayat Transaksi Terkini</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table m-0">
                            <thead>
                                <tr>
                                    <th>Invoice</th>
                                    <th>Anggota</th>
                                    <th>Tanggal</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($transaksi_terbaru as $trx)
                                    <tr>
                                        <td><a href="#">{{ $trx->invoice_no }}</a></td>
                                        <td>{{ $trx->member->name }}</td>
                                        <td>{{ \Carbon\Carbon::parse($trx->created_at)->diffForHumans() }}</td>
                                        <td>
                                            @if ($trx->status == 'borrowed')
                                                <span class="badge badge-warning">Dipinjam</span>
                                            @else
                                                <span class="badge badge-success">Kembali</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">Belum ada data.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer clearfix">
                    <a href="{{ route('transactions.create') }}" class="btn btn-sm btn-info float-left">Transaksi Baru</a>
                    <a href="{{ route('transactions.index') }}" class="btn btn-sm btn-secondary float-right">Lihat Semua</a>
                </div>
            </div>
        </div>
    </section>

    @push('scripts')
        <script src="{{ asset('adminlte/plugins/chart.js/Chart.min.js') }}"></script>
        <script>
            $(function () {
                // ambil data dari Controller
                var labelChart = @json($label_chart);
                var dataChart = @json($data_chart);

                // setting chart
                var salesChartCanvas = $('#revenue-chart-canvas').get(0).getContext('2d');
                var salesChartData = {
                    labels: labelChart,
                    datasets: [
                        {
                            label: 'Peminjaman',
                            backgroundColor: 'rgba(60,141,188,0.1)',
                            borderColor: 'rgba(60,141,188,0.8)',
                            pointRadius: 5,
                            pointColor: '#3b8bba',
                            pointStrokeColor: 'rgba(60,141,188,1)',
                            pointHighlightFill: '#fff',
                            pointHighlightStroke: 'rgba(60,141,188,1)',
                            fill: true,
                            data: dataChart
                        }
                    ]
                };

                var salesChartOptions = {
                    maintainAspectRatio: false,
                    responsive: true,
                    legend: { display: false },
                    scales: {
                        xAxes: [{ gridLines: { display: false } }],
                        yAxes: [{ gridlines: { display: true, color: 'rgba(0,0,0,0.05)' }, ticks: { stepSize: 1, beginAtZero: true } }]
                    }
                };

                // render chart
                var salesChart = new Chart(salesChartCanvas, {
                    type: 'line',
                    data: salesChartData,
                    options: salesChartOptions
                });
            });
        </script>
    @endpush
@endsection