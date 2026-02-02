<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Join Digilib</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">
    <!-- auth page style-->
    <link rel='stylesheet' type='text/css' href='{{ asset('assets/css/style.css') }}'>
</head>

<body>
    <div class="auth-page">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-11 col-xl-10">

                    <div class="card border-0 shadow-lg card-fixed-height">
                        <div class="card-body p-0 h-100">
                            <div class="row no-gutters h-100">

                                <div class="col-lg-6 bg-white form-section">
                                    <div class="form-container">
                                        <div class="text-center mb-4">
                                            <h1 class="h4 text-gray-900">Daftar Akun <b>Digilib</b></h1>
                                            <p class="small text-muted">Lengkapi data untuk mengajukan akses</p>
                                        </div>

                                        @if ($errors->any())
                                            <div class="alert alert-danger alert-dismissible fade show" role="alert"
                                                style="font-size: 0.9rem;">
                                                <ul class="mb-0 pl-3">
                                                    @foreach ($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                        @endif

                                        <form action="{{ route('register') }}" method="post">
                                            @csrf

                                            <div class="form-group mb-3">
                                                <input type="text" name="name" class="form-control form-control-user"
                                                    placeholder="Nama Lengkap" value="{{ old('name') }}" required>
                                            </div>

                                            <div class="form-group mb-3">
                                                <input type="text" name="username"
                                                    class="form-control form-control-user"
                                                    placeholder="Username (Min. 5 Karakter)"
                                                    value="{{ old('username') }}" required
                                                    style="text-transform: lowercase;"
                                                    oninput="this.value = this.value.toLowerCase()">
                                            </div>

                                            <div class="form-group mb-0">
                                                <div class="input-group">
                                                    <input type="password" name="password"
                                                        class="form-control form-control-user" placeholder="Password"
                                                        required id="password" style="border-right: 0;">
                                                    <div class="input-group-append">
                                                        <div class="input-group-text bg-white" style="border-left: 0;">
                                                            <span class="fas fa-eye toggle-password"
                                                                data-target="#password"
                                                                style="cursor: pointer; color: #6c757d;"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <p class="password-hint">
                                                <i class="fas fa-info-circle mr-1"></i> Min. 8 karakter, kombinasi
                                                huruf, angka & simbol.
                                            </p>

                                            <div class="form-group mb-4">
                                                <div class="input-group">
                                                    <input type="password" name="password_confirmation"
                                                        class="form-control form-control-user"
                                                        placeholder="Ulangi Password" required
                                                        id="password_confirmation" style="border-right: 0;">
                                                    <div class="input-group-append">
                                                        <div class="input-group-text bg-white" style="border-left: 0;">
                                                            <span class="fas fa-eye toggle-password"
                                                                data-target="#password_confirmation"
                                                                style="cursor: pointer; color: #6c757d;"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <button type="submit" class="btn btn-primary btn-block py-2">
                                                Daftar Sekarang
                                            </button>
                                        </form>

                                        <hr>
                                        <div class="text-center">
                                            <p>Sudah punya akun? <a class="medium" href="{{ route('login') }}">Login</a>
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6 d-none d-lg-block image-section">
                                    <div id="carouselRegister" class="carousel slide h-100" data-ride="carousel">
                                        <ol class="carousel-indicators">
                                            <li data-target="#carouselRegister" data-slide-to="0" class="active"></li>
                                            <li data-target="#carouselRegister" data-slide-to="1"></li>
                                            <li data-target="#carouselRegister" data-slide-to="2"></li>
                                        </ol>
                                        <div class="carousel-inner h-100">
                                            <div class="carousel-item active h-100">
                                                <img class="image-cover" src="{{ asset('assets/img/1.webp') }}"
                                                    alt="Library 1">
                                            </div>
                                            <div class="carousel-item h-100">
                                                <img class="image-cover" src="{{ asset('assets/img/2.webp') }}"
                                                    alt="Library 2">
                                            </div>
                                            <div class="carousel-item h-100">
                                                <img class="image-cover" src="{{ asset('assets/img/3.webp') }}"
                                                    alt="Library 3">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>


<!-- Inspect password -->
<script src="{{ asset('assets/js/inspectPassword.js') }}"></script>
<!-- jQuery -->
<script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
</body>

</html>