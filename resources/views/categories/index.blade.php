@extends('layouts.app')

@section('title', 'Manajemen Kategori')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">
                        Kategori Buku
                    </h1>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-lg-4 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $total }}</h3>
                            <p>Total Kategori</p>
                        </div>
                        <div class="icon"><i class="fas fa-list"></i></div>
                        <div class="small-box-footer"></div>
                    </div>
                </div>
                <div class="col-lg-4 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ $used }}</h3>
                            <p>Kategori Terpakai</p>
                        </div>
                        <div class="icon"><i class="fas fa-check-circle"></i></div>
                        <div class="small-box-footer"></div>
                    </div>
                </div>
                <div class="col-lg-4 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{ $empty }}</h3>
                            <p>Kategori Kosong</p>
                        </div>
                        <div class="icon"><i class="fas fa-times-circle"></i></div>
                        <div class="small-box-footer"></div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Daftar Kategori</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                            data-target="#modal-create">
                            <i class="fas fa-plus"></i> Tambah Kategori
                        </button>
                    </div>
                </div>
                <div class="card-body p-0">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th style="width: 10px;">#</th>
                                <th>Nama Kategori</th>
                                <th>Jumlah Buku</th>
                                <th style="width: 150px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($categories as $category)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $category->name }}</td>
                                    <td>
                                        @if ($category->books_count > 0)
                                            <span class="badge badge-success">{{ $category->books_count }} Judul</span>
                                        @else
                                            <span class="badge badge-danger">Kosong</span>
                                        @endif
                                    </td>
                                    <td>
                                        <button class="btn btn-warning btn-sm btn-edit" data-id="{{ $category->id }}"
                                            data-name="{{ $category->name }}" data-toggle="modal" data-target="#modal-edit">
                                            <i class="fas fa-edit"></i>
                                        </button>

                                        <form action="{{ route('categories.destroy', $category->id) }}" method="POST"
                                            class="d-inline" onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"><i
                                                    class="fas fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">Belum ada data kategori.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="modal-create">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Kategori Baru</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form action="{{ route('categories.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nama Kategori</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                placeholder="Contoh: Novel" required>
                            @error('name')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-edit">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Kategori</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form id="form-edit" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nama Kategori</label>
                            <input type="text" name="name" id="edit-name" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- jquery script -->
    <script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>

    <script>
        $(document).ready(function () {
            $(document).on('click', '.btn-edit', function () {
                // Ambil data
                var id = $(this).data('id');
                var name = $(this).data('name');

                // isi kolom input
                $('#edit-name').val(name);

                var url = "{{ route('categories.index') }}" + "/" + id;
                $('#form-edit').attr('action', url);
            });
            // re-open modal
            @if ($errors->any())
                $('#modal-create').modal('show');
            @endif
                 });
    </script>
@endsection