@extends('layouts.app')
@section('title', 'Transaksi Baru')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <h1 class="m-0">Form Peminjaman Buku</h1>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Input Transaksi</h3>
                </div>

                <form action="{{ route('transactions.store') }}" method="post">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Nomor Invoice</label>
                                    <input type="text" class="form-control" value="TRX-{{ time() }}" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Tanggal Pinjam</label>
                                    <input type="text" class="form-control" value="{{ date('d M Y') }}" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Jatuh Tempo</label>
                                    <input type="text" class="form-control text-danger font-weight-bold"
                                        value="{{ date('d M Y', strtotime('+7 days')) }}" readonly>
                                </div>
                            </div>

                            <div class="col-md-8">
                                <div class="form-group">
                                    <label>Pilih Anggota <span class="text-danger">*</span></label>
                                    <select name="member_id" class="form-control select2" style="width: 100%;" required>
                                        <option value="">-- Cari Nama / NIM --</option>
                                        @foreach ($members as $member)
                                            <option value="{{ $member->id }}">{{ $member->nim }} - {{ $member->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Daftar Buku yang Dipinjam</label>
                                    <table class="table table-bordered table-sm">
                                        <thead>
                                            <tr>
                                                <th>Judul Buku</th>
                                                <th width="100">Jumlah</th>
                                                <th width="50">#</th>
                                            </tr>
                                        </thead>
                                        <tbody id="transaction-rows">
                                            <tr>
                                                <td>
                                                    <select name="book_ids[]" class="form-control select2-book" required>
                                                        <option value="-- Pilih Buku --"></option>
                                                        @foreach ($books as $book)
                                                            <option value="{{ $book->id }}" data-stock="{{ $book->stock }}">
                                                                {{ $book->title }} (Sisa: {{ $book->stock }})
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="number" name="quantities[]" class="form-control" min="1"
                                                        value="1" required>
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-danger btn-sm btn-remove" disabled>
                                                        <i class="fas fa-minus"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <button type="button" class="btn btn-success btn-sm mt-2" id="add-row">
                                        <i class="fas fa-plus"></i> Tambah Buku Lain
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('transactions.index') }}" class="btn btn-default">Kembali</a>
                        <button type="submit" class="btn btn-primary float-right"><i class="fas fa-save"></i> Simpan
                            Transaksi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    @push('scripts')
        <script>
            $(document).ready(function () {
                $('.select2').select2({
                    theme: 'bootstrap4',
                });

                function initBookSelect() {
                    $('.select2-book').select2({
                        theme: 'bootstrap4',
                        placeholder: "Pilih Buku"
                    });
                }
                initBookSelect();

                $('#add-row').click(function () {
                    let row = `<tr>
                                                <td>
                                                    <select name="book_ids[]" class="form-control select2-book" required>
                                                        <option value="">-- Pilih Buku --</option>
                                                        @foreach($books as $book)
                                                            <option value="{{ $book->id }}">{{ $book->title }} (Sisa: {{ $book->stock }})</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="number" name="quantities[]" class="form-control" min="1" value="1" required>
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-danger btn-sm btn-remove">
                                                        <i class="fas fa-minus"></i>
                                                    </button>
                                                </td>
                                            </tr>`;

                    $('#transaction-rows').append(row);
                    initBookSelect();
                });

                // hapus BARIS
                $(document).on('click', '.btn-remove', function () {
                    $(this).closest('tr').remove();
                });
            });
        </script>
    @endpush
@endsection