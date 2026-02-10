@extends('layouts.app')

@section('title', 'Manajemen Buku')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Kelola Buku</h1>
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
                            <h3>{{ $total_buku }}</h3>
                            <p>Total Judul</p>
                        </div>
                        <div class="icon"><i class="fas fa-book"></i></div>
                        <div class="small-box-footer"></div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ $total_stok }}</h3>
                            <p>Total Eksemplar</p>
                        </div>
                        <div class="icon"><i class="fas fa-layer-group"></i></div>
                        <div class="small-box-footer"></div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ $stok_tipis }}</h3>
                            <p>Stok Menipis</p>
                        </div>
                        <div class="icon"><i class="fas fa-exclamation-triangle"></i></div>
                        <div class="small-box-footer"></div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-indigo">
                        <div class="inner">
                            <h3>{{ $buku_baru }}</h3>
                            <p>Buku Baru (Bulan Ini)</p>
                        </div>
                        <div class="icon"><i class="fas fa-plus-circle"></i></div>
                        <div class="small-box-footer"></div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Daftar Pustaka</h3>
                    <div class="card-tools">
                        <a href="{{ route('books.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"> Tambah Buku Baru</i>
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th style="width: 10px;">No</th>
                                <th style="width: 60px;">Cover</th>
                                <th>Info Buku</th>
                                <th>Kategori</th>
                                <th>Stok</th>
                                <th style="width: 150px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($books as $book)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        @if ($book->cover_image)
                                            <img src="{{ asset('storage/' . $book->cover_image) }}" alt="Cover" width="50"
                                                class="img-thumbnail">
                                        @else
                                            <span class="text-muted">No IMG</span>
                                        @endif
                                    </td>
                                    <td>
                                        <strong>
                                            {{ $book->title }}
                                        </strong>
                                        <br>
                                        <small class="text-muted">
                                            {{ $book->author }} | {{ $book->language }} ({{ $book->pages }})
                                        </small>
                                    </td>
                                    <td>{{ $book->category->name }}</td>
                                    <td>
                                        @if ($book->stock < 5)
                                            <span class="badge badge-warning">
                                                {{ $book->stock }}
                                            </span>
                                        @else
                                            <span class="badge badge-success">{{ $book->stock }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <button class="btn btn-info btn-sm btn-detail" data-id="{{ $book->id }}">
                                            <i class="fas fa-eye"></i>
                                        </button>

                                        <a href="{{ route('books.edit', $book->id) }}" class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <form action="{{ route('books.destroy', $book->id) }}" method="POST" class="d-inline"
                                            onsubmit="return confirm('Yakin hapus buku ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-sm">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">Belum ada data buku.</td>
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
                    <h4 class="modal-title">Detail Buku</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4 text-center">
                            <img id="detail-cover" src="" class="img-fluid rounded shadow" style="max-height: 300px;">
                        </div>
                        <div class="col-md-8">
                            <h3 id="detail-title" class="text-primary font-weight-bold"></h3>
                            <p class="text-muted">
                                Penulis: <span id="detail-author"></span>
                                <br>
                                ISBN: <span id="detail-isbn"></span> <span id="detail-isbn"></span>
                            </p>
                            <hr>
                            <strong>Kategori:</strong> <span id="detail-category" class="badge badge-info"></span>
                            <br>
                            <strong>Stok:</strong> <span id="detail-stock"></span>
                            <br>
                            <strong>Bahasa:</strong> <span id="detail-language"></span>
                            <br>
                            <strong>Jumlah Halaman:</strong> <span id="detail-pages"></span>
                            <br>
                            <strong>Sinopsis:</strong>
                            <p id="detail-description" class="mt-2 text-justify"></p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            $(document).on('click', '.btn-detail', function () {
                let id = $(this).data('id');

                // Panggil controller show
                $.ajax({
                    url: "/books/" + id,
                    type: "GET",
                    success: function (response) {
                        // isi data->modal
                        $('#detail-title').text(response.title);
                        $('#detail-author').text(response.author);
                        $('#detail-isbn').text(response.isbn);
                        $('#detail-category').text(response.category ? response.category.name : '-');
                        $('#detail-stock').text(response.stock);
                        $('#detail-language').text(response.language || '-');
                        $('#detail-pages').text(response.pages || '-');
                        $('#detail-description').text(response.description || '- Tidak ada deskripsi -');

                        // Handle Gambar
                        if (response.cover_image) {
                            $('#detail-cover').attr('src', '/storage/' + response.cover_image);
                        } else {
                            $('#detail-cover').attr('src', 'https://placehold.co/150?text=No+Cover&font=roboto');
                        }

                        // tampil modal
                        $('#modal-detail').modal('show');
                    },
                    error: function (xhr) {
                        alert("Gagal mengambil data buku.");
                    }
                });
            });
        </script>
    @endpush
@endsection