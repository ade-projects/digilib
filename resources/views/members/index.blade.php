@extends('layouts.app')
@section('title', 'Manajemen Anggota')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Data Anggota</h1>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Daftar Anggota Perpustakaan</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                            data-target="#modal-create">
                            <i class="fas fa-plus"></i> Tambah Anggota
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th style="width: 10px;">No</th>
                                <th>NIM</th>
                                <th>Nama Lengkap</th>
                                <th>No. HP</th>
                                <th>Alamat</th>
                                <th style="width: 120px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($members as $member)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="font-weight-bold">{{ $member->nim }}</td>
                                    <td>{{ $member->name }}</td>
                                    <td>{{ $member->phone ?? '-' }}</td>
                                    <td>{{ Str::limit($member->address, 30) }}</td>
                                    <td>
                                        <button class="btn btn-warning btn-sm btn-edit" data-id="{{ $member->id }}"
                                            data-nim="{{ $member->nim }}" data-name="{{ $member->name }}"
                                            data-phone="{{ $member->phone }}" data-address="{{ $member->address }}">
                                            <i class="fas fa-edit"></i>
                                        </button>

                                        <button class="btn btn-danger btn-sm btn-delete" data-id="{{ $member->id }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                        <form id="delete-form-{{ $member->id }}"
                                            action="{{ route('members.destroy', $member->id) }}" method="POST"
                                            style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">Belum ada data anggota.</td>
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
                    <h4 class="modal-title">Tambah Anggota Baru</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form action="{{ route('members.store') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>NIM<span class="text-danger">*</span></label>
                            <input type="number" name="nim" class="form-control" required placeholder="Contoh: 10123001">
                        </div>
                        <div class="form-group">
                            <label>Nama Lengkap<span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>No. HP/WhatsApp</label>
                            <input type="number" name="phone" class="form-control" placeholder="08...">
                        </div>
                        <div class="form-group">
                            <label>Alamat</label>
                            <textarea name="address" class="form-control" rows="3"></textarea>
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
                    <h4 class="modal-title">Edit Data Anggota</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form id="form-edit" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="form-group">
                            <label>NIM</label>
                            <input type="number" name="nim" id="edit-nim" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Nama Lengkap</label>
                            <input type="text" name="name" id="edit-name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>No. HP/WhatsApp</label>
                            <input type="number" name="phone" id="edit-phone" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Alamat</label>
                            <textarea name="address" id="edit-address" rows="3" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-warning">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function () {
                $('.btn-edit').on('click', function () {
                    let id = $(this).data('id');
                    let nim = $(this).data('nim');
                    let name = $(this).data('name');
                    let phone = $(this).data('phone');
                    let address = $(this).data('address');

                    $('#edit-nim').val(nim);
                    $('#edit-name').val(name);
                    $('#edit-phone').val(phone);
                    $('#edit-address').val(address);

                    $('#form-edit').attr('action', '/members/' + id);

                    $('#modal-edit').modal('show');
                });

                $('.btn-delete').on('click', function () {
                    let id = $(this).data('id');
                    Swal.fire({
                        title: 'Hapus Anggota?',
                        text: "Data tidak bisa dikembalikan!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Ya, Hapus!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $(`#delete-form-${id}`).submit();
                        }
                    });
                });

                @if ($errors->any())
                    $('#modal-create').modal('show');
                @endif
                                                        });
        </script>
    @endpush
@endsection