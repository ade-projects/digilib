@extends('layouts.app')
@section('title', 'Edit Buku')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Edit Buku: {{ $book->title }}</h1>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title">Form Edit Buku</h3>
                </div>

                <form action="{{ route('books.update', $book->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label>Judul Buku</label>
                                    <input type="text" name="title" class="form-control"
                                        value="{{ old('title', $book->title) }}" required>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Penulis</label>
                                            <input type="text" name="author" class="form-control"
                                                value="{{ old('author', $book->author) }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>ISBN</label>
                                            <input type="text" name="isbn" class="form-control"
                                                value="{{ old('isbn', $book->isbn) }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Kategori</label>
                                            <select name="category_id" class="form-control">
                                                @foreach ($categories as $cat)
                                                    <option value="{{ $cat->id }}" {{ $book->category_id == $cat->id ? 'selected' : '' }}> {{ $cat->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Stok</label>
                                            <input type="number" name="stock" class="form-control"
                                                value="{{ old('stock', $book->stock) }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Bahasa</label>
                                            <input type="text" name="language" class="form-control"
                                                value="{{ old('language', $book->language) }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Jumlah Halaman</label>
                                            <input type="number" name="pages" class="form-control"
                                                value="{{ old('language', $book->pages) }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Sinopsis</label>
                                    <textarea name="description" class="form-control"
                                        rows="4">{{ old('description', $book->description) }}</textarea>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Ganti Cover (Opsional)</label>
                                    <div class="custom-file">
                                        <input type="file" name="cover_image" class="custom-file-input" id="coverInput"
                                            accept="image/*">
                                        <label class="custom-file-label" for="coverInput">Pilih Gambar Baru</label>
                                    </div>
                                </div>
                                <div class="mt-3 text-center">
                                    @if ($book->cover)
                                        <img src="{{ asset('storage/' . $book->cover) }}" class="img-fluid rounded shadow"
                                            style="max-height: 300px;">
                                        <p class="text-muted text-sm mt-2">Cover Saat ini</p>
                                    @else
                                        <img src="https://placehold.co/200x300?text=No+Cover&font=roboto" id="coverPreview"
                                            class="img-fluid rounded shadow">
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <a href="{{ route('books.index') }}" class="btn btn-default">Kembali</a>
                        <button type="submit" class="btn btn-warning float-right"><i class="fas fa-save"> Update
                                Data</i></button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    @push('scripts')
        <script>
            $('.custom-file-input').on('change', function (evt) {
                let fileName = $(this).val().split('\\').pop();
                $(this).next('.custom-file-label').addClass("selected").html(fileName);
            });

            document.getElementById('coverInput').onchange = function (evt) {
                var tgt = evt.target || window.event.srcElement,
                    files = tgt.files;
                if (FileReader && files && files.length) {
                    var fr = new FileReader();
                    fr.onload = function () {
                        document.getElementById('coverPreview').src = fr.result;
                    }
                    fr.readAsDataURL(files[0]);
                }
            }
        </script>
    @endpush
@endsection