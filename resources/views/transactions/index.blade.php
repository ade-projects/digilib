@extends('layouts.app')
@section('title', 'Riwayat Transaksi')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Transaksi</h1>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $total_transaksi }}</h3>
                            <p>Total Peminjaman</p>
                        </div>
                        <div class="icon"><i class="fas fa-file-invoice"></i></div>
                        <div class="small-box-footer"></div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ $sedang_dipinjam }}</h3>
                            <p>Sedang Dipinjam</p>
                        </div>
                        <div class="icon"><i class="fas fa-hourglass-half"></i></div>
                        <div class="small-box-footer"></div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{ $terlambat }}</h3>
                            <p>Jatuh Tempo</p>
                        </div>
                        <div class="icon"><i class="fas fa-exclamation-circle"></i></div>
                        <div class="small-box-footer"></div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ $selesai }}</h3>
                            <p>Selesai / Kembali</p>
                        </div>
                        <div class="icon"><i class="fas fa-check-circle"></i></div>
                        <div class="small-box-footer"></div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Riwayat Peminjaman</h3>
                    <div class="card-tools">
                        <a href="{{ route('transactions.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Transaksi Baru
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Invoice</th>
                                <th>Peminjam</th>
                                <th>Tgl Pinjam</th>
                                <th>Jatuh Tempo</th>
                                <th>Status</th>
                                <th>Denda</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($transactions as $trx)
                                <tr>
                                    <td class="font-weight-bold text-primary">
                                        {{ $trx->invoice_no }}
                                    </td>
                                    <td>
                                        {{ $trx->member->name }} <br>
                                        <small class="text-muted">{{ $trx->details->count() }} Buku</small>
                                    </td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($trx->borrow_date)->format('d M Y') }}
                                    </td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($trx->return_date)->format('d M Y') }}
                                    </td>
                                    <td>
                                        @if ($trx->status == 'returned')
                                            <span class="badge badge-success">Kembali</span>
                                        @elseif (\Carbon\Carbon::now()->gt($trx->return_date))
                                            <span class="badge badge-danger">Terlambat</span>
                                        @else
                                            <span class="badge badge-warning">Dipinjam</span>
                                        @endif
                                    </td>
                                    <td>Rp {{ number_format($trx->fine) }}</td>
                                    <td>
                                        <button class="btn btn-info btn-sm btn-detail" data-id="{{ $trx->id }}">
                                            <i class="fas fa-eye"></i>
                                        </button>

                                        @if ($trx->status == 'borrowed')
                                            <button class="btn btn-success btn-sm btn-return" data-id="{{ $trx->id }}">
                                                <i class="fas fa-check"></i>
                                            </button>
                                            <form id="return-form-{{ $trx->id }}"
                                                action="{{ route('transactions.update', $trx->id) }}" method="POST"
                                                style="display: none;">
                                                @csrf
                                                @method('PUT')
                                            </form>
                                        @endif

                                        <button class="btn btn-danger btn-sm btn-delete" data-id="{{ $trx->id }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                        <form id="delete-form-{{ $trx->id }}"
                                            action="{{ route('transactions.destroy', $trx->id) }}" method="POST"
                                            style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">Belum ada data transaksi.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="modal-detail">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Detail Transaksi: <span id="val-invoice"></span></h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <strong>Peminjam:</strong> <span id="val-member"></span><br>
                            <strong>Petugas:</strong> <span id="val-user"></span>
                        </div>
                        <div class="col-md-6 text-right">
                            <strong>Tgl Pinjam:</strong> <span id="val-borrow"></span><br>
                            <strong>Jatuh Tempo:</strong> <span id="val-due" class="text-danger"></span>
                        </div>
                    </div>
                    <hr>
                    <h5>Daftar Buku Dipinjam:</h5>
                    <table class="table table-sm table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Judul Buku</th>
                                <th>Penulis</th>
                            </tr>
                        </thead>
                        <tbody id="val-books-list"></tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
    @push('scripts')
        <script>
            $(document).ready(function () {
                $('.btn-detail').on('click', function () {
                    let id = $(this).data('id');

                    $('#val-invoice').text('Loading...');

                    $.ajax({
                        url: "/transactions/" + id,
                        type: "GET",
                        success: function (response) {
                            $('#val-invoice').text(response.invoice_no);
                            $('#val-member').text(response.member.name);
                            $('#val-user').text(response.user.name);
                            $('#val-borrow').text(response.borrow_date);
                            $('#val-due').text(response.return_date);

                            let rows = '';
                            $.each(response.details, function (key, item) {
                                rows += `<tr>
                                                                                    <td>${key + 1}</td>
                                                                                    <td>${item.book.title}</td>
                                                                                    <td>${item.qty} Pcs</td>
                                                                                    <td>${item.book.author}</td>
                                                                                </tr>`;
                            });
                            $('#val-books-list').html(rows);
                            $('#modal-detail').modal('show');
                        },
                        error: function () {
                            $('#val-invoice').text('Error');
                        }
                    });
                });
                $('.btn-return').on('click', function () {
                    let id = $(this).data('id');

                    Swal.fire({
                        title: 'Kembalikan Buku?',
                        text: "Pastikan fisik buku sudah diterima & dicek!",
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#28a745',
                        confirmButtonText: 'Ya, Proses Kembali!',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $(`#return-form-${id}`).submit();
                        }
                    });
                });

                $('.btn-delete').on('click', function () {
                    let id = $(this).data('id');
                    Swal.fire({
                        title: 'Hapus Transaksi?',
                        text: "Hati-hati! Stok buku akan dikembalikan.",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        confirmButtonText: 'Ya, Hapus!',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $(`#delete-form-${id}`).submit();
                        }
                    });
                });

                @if (session('success'))
                    Swal.fire({ icon: 'success', title: 'Berhasil', text: '{{ session('success') }}' });
                @endif
                @if (session('warning'))
                    Swal.fire({ icon: 'warning', title: 'Perhatian!', text: '{{ session('warning') }}' });
                @endif
                @if (session('error'))
                    Swal.fire({ icon: 'error', title: 'Gagal!', text: '{{ session('error') }}' });
                @endif
                            });
        </script>
    @endpush
@endsection