@extends('layouts.app')

@section('title', 'Kelola Pengguna')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Kelola Pengguna</h1>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-lg-4 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ $active }}</h3>
                            <p>User Active</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-user"></i>
                        </div>
                        <div class="small-box-footer"></div>
                    </div>
                </div>
                <div class="col-lg-4 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ $pending }}</h3>
                            <p>User Pending</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-user-clock"></i>
                        </div>
                        <div class="small-box-footer"></div>
                    </div>
                </div>
                <div class="col-lg-4 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{ $banned }}</h3>
                            <p>User Banned</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-user-slash"></i>
                        </div>
                        <div class="small-box-footer"></div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        Daftar Semua Pengguna
                    </h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                            data-target="#modal-create">
                            <i class="fas fa-plus"></i> Tambah User
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th>Nama Lengkap</th>
                                <th>Username</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th width="15%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->username }}</td>
                                    <td>
                                        <span class="badge badge-info">
                                            {{ ucfirst($user->role) }}
                                        </span>
                                    </td>
                                    <td>
                                        @if ($user->status == 'active')
                                            <span class="badge badge-success">Active</span>
                                        @elseif ($user->status == 'pending')
                                            <span class="badge badge-warning">Pending</span>
                                        @else
                                            <span class="badge badge-danger">Banned</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($user->status == 'pending')
                                            <form action="{{ route('users.update', $user->id) }}" method="POST"
                                                style="display: inline;">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="active">
                                                <input type="hidden" name="name" value="{{ $user->name }}">
                                                <input type="hidden" name="username" value="{{ $user->username }}">
                                                <input type="hidden" name="role" value="{{ $user->role }}">
                                                <button type="submit" class="btn btn-sm btn-success" title="Approve">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            </form>

                                            <form action="{{ route('users.update', $user->id) }}" method="POST"
                                                style="display: inline;"
                                                onsubmit="return confirm ('Yakin ingin menolak user ini? Status akan diubah menjadi Banned.');">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="banned">
                                                <input type="hidden" name="name" value="{{ $user->name }}">
                                                <input type="hidden" name="role" value="{{ $user->role }}">
                                                <button type="submit" class="btn btn-sm btn-danger" title="Tolak">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </form>

                                        @else
                                            <button type="button" class="btn btn-sm btn-warning btn-edit" data-toggle="modal"
                                                data-target="#modal-edit" data-id="{{ $user->id }}" data-name="{{ $user->name }}"
                                                data-username="{{ $user->username }}" data-role="{{ $user->role }}"
                                                data-status="{{ $user->status }}">
                                                <i class="fas fa-edit" title="Edit"></i>
                                            </button>

                                            <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                                                style="display: inline;"
                                                onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
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
                    <h4 class="modal-title">Tambah Pengguna Baru</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="{{ route('users.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nama Lengkap</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                placeholder="Nama Lengkap" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" name="username" class="form-control @error('username') is-invalid
                            @enderror" placeholder="Username (Min. 5 digit)" value="{{ old('username') }}" required>
                            @error('username')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Role</label>
                                    <select name="role" class="form-control">
                                        <option value="staff" {{ old('role') == 'staff' ? 'selected' : '' }}>Staff</option>
                                        <option value="admin" {{ old('role') == 'staff' ? 'selected' : '' }}>Admin</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Status</label>
                                    <select name="status" class="form-control">
                                        <option value="active" {{ old('status' == 'active' ? 'selected' : '') }}>Active
                                        </option>
                                        <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending
                                        </option>
                                        <option value="banned" {{ old('banned' ? 'selected' : '') }}>Banned</option>
                                    </select>
                                </div>
                            </div>
                        </div>


                        <div class="form-group">
                            <label>Password</label>
                            <div class="input-group">
                                <input type="password" name="password" class="form-control @error('password') is-invalid
                                @enderror" id="create_password" placeholder="Password" required>
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-eye toggle-password" data-target="#create_password"
                                            style="cursor: pointer;"></span>
                                    </div>
                                </div>
                                @error('password')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <p class="password-hint">
                            <i class="fas fa-info-circle mr-1"></i> Min. 8 karakter, kombinasi
                            huruf, angka & simbol.
                        </p>
                        <div class="form-group">
                            <label>Konfirmasi Password</label>
                            <div class="input-group">
                                <input type="password" name="password_confirmation" class="form-control"
                                    id="create_password_confirm" placeholder="Ulangi Password" required>
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-eye toggle-password" data-target="#create_password_confirm"
                                            style="cursor: pointer;"></span>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-edit">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Pengguna</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form id="form-edit" method="POST">
                    @csrf
                    @method('PUT') <div class="modal-body">
                        <div class="form-group">
                            <label>Nama Lengkap</label>
                            <input type="text" name="name" id="edit-name" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" name="username" id="edit-username" class="form-control" readonly>
                        </div>

                        <div class="form-group">
                            <label>Role</label>
                            <select name="role" id="edit-role" class="form-control">
                                <option value="admin">Admin</option>
                                <option value="staff">Staff</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Status</label>
                            <select name="status" id="edit-status" class="form-control">
                                <option value="active">Active</option>
                                <option value="pending">Pending</option>
                                <option value="banned">Banned</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Password Baru<small class="text-muted">(Kosongkan jika tidak ingin mengubah)
                                </small></label>
                            <div class="input-group">
                                <input type="password" name="password" id="edit_password" class="form-control @error('password') is-invalid
                                @enderror" placeholder="Password Baru">

                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-eye toggle-password" data-target="#edit_password"
                                            style="cursor: pointer;"></span>
                                    </div>
                                </div>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <p class="password-hint">
                            <i class="fas fa-info-circle mr-1"></i> Min. 8 karakter, kombinasi
                            huruf, angka & simbol.
                        </p>

                        <div class="form-group">
                            <label>Konfirmasi Password</label>
                            <div class="input-group">
                                <input type="password" name="password_confirmation" id="edit_password_confirmation"
                                    class="form-control" placeholder="Ulangi Password Baru">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-eye toggle-password" data-target="#edit_password_confirmation"
                                            style="cursor: pointer;"></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- jquery script -->
    <script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>

    <script>
        $(document).ready(function () {
            // script isi data->modal edit
            $(document).on("click", ".btn-edit", function () {
                // ambil data
                let id = $(this).data("id");
                let name = $(this).data("name");
                let username = $(this).data("username");
                let role = $(this).data("role");
                let status = $(this).data("status");


                // isi form modal
                $("#edit-name").val(name);
                $("#edit-username").val(username);
                $("#edit-role").val(role);
                $("#edit-status").val(status);
                $("#edit_password").val('');
                $('#edit_password_confirmation').val('');

                let url = "{{ route('users.index') }}" + "/" + id;
                $("#form-edit").attr("action", url);
            });
            // re-open modal
            @if ($errors->any())
                $('#modal-create').modal('show');
            @endif
                                                                                                                                });
    </script>

@endsection
<!-- Inspect Password -->
@push('scripts')
    <script src="{{ asset('assets/js/inspectPassword.js') }}"></script>
@endpush