@extends('layouts.app')
@section('title', 'Tambah Buku')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Tambah Buku Baru</h1>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Form Input Buku</h3>
                </div>

                <form action="{{ route('books.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label>Judul Buku</label>
                                    <input type="text" name="title"
                                        class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}"
                                        placeholder="Masukkan judul">
                                    @error('title') <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Penulis</label>
                                            <input type="text" name="author" class="form-control"
                                                value="{{ old('author') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>ISBN</label>
                                            <input type="text" name="isbn" class="form-control" value="{{ old('isbn') }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Kategori</label>
                                            <select name="category_id" class="form-control">
                                                <option value="">-- Pilih Kategori --</option>
                                                @foreach ($categories as $cat)
                                                    <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                                        {{ $cat->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                 <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Stok</label>
                                            <input type="number" name="stock" class="form-control" value="{{ old('stock') }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                     <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Bahasa</label>
                                            <input type="text" name="language" class="form-control" value="{{ old('language') }}">
                                        </div>
                                     </div>
                                </div>

                                   
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Jumlah Halaman</label>
                                            <input type="number" name="pages" class="form-control" value="{{ old('pages') }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Sinopsis / Deskripsi</label>
                                    <textarea name="description" class="form-control" rows="4">{{ old('description') }}</textarea>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Cover Buku</label>
                                    <div class="custom-file">
                                        <input type="file" name="cover_image" class="custom-file-input" id="coverInput" accept="image/*">
                                        <label class="custom-file-label">Pilih Gambar</label>
                                    </div>
                                    <small class="text-muted">Format: jpg, png, webp. Maks: 2MB</small>
                                </div>
                                <div class="mt-3 text-center">
                                    <img id="coverPreview" src="https://placehold.co/200x300?text=No+Cover&font=roboto" class="img-fluid rounded shadow" style="max-height: 300px;">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <a href="{{ route('books.index') }}" class="btn btn-default">Kembali</a>
                        <button type="submit" class="btn btn-primary float-right"><i class="fas fa-save"> Simpan Buku</i></button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    @push('scripts')
        <script>
          $(document).ready(function() {

            $('.custom-file-input').on('change', function() {
                let fileName = $(this).val().split('\\').pop();
                $(this).next('.custom-file-label').addClass("selected").html(fileName);
            });

            $('#coverInput').on('change', function(evt) {
                var files = evt.target.files;

                if (files && files.length) {
                    var fr = new FileReader();
                    fr.onload = function () {
                        $('#coverPreview').attr('src', fr.result);
                    }
                    fr.readAsDataURL(files[0]);
                }
            });
          })
        </script>
    @endpush
@endsection