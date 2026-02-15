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
                                    <label>Pilih Buku (Bisa lebih dari 1) <span class="text-danger">*</span></label>
                                    <select name="book_ids[]" class="form-control select2" multiple="multiple"
                                        style="width: 100%;" required>
                                        @foreach ($books as $book)
                                            <option value="{{ $book->id }}">
                                                {{ $book->title }} (Stok: {{ $book->stock }})
                                            </option>
                                        @endforeach
                                    </select>
                                    <small class="text-muted">Ketik judul buku untuk mencari.</small>
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
                    placeholder: 'Pilih data...'
                });
            })
        </script>
    @endpush
@endsection