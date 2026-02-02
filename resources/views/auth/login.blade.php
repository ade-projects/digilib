<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome to Digilib</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">
    <!-- auth page style-->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
</head>

<body>
    <!-- /.login-box -->
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
                                            <h1 class="h4 text-gray-900">Selamat Datang di <b>Digilib</b></h1>
                                            <p class="small text-muted">Silakan masuk untuk melanjutkan</p>
                                        </div>

                                        @if ($errors->any())
                                            <div class="alert alert-danger alert dismissable fade show" role="alert" style="font-size: 0.9rem;">
                                                    <i class="fas fa-exclamation-triangle mr-2"></i>
                                                    <span>
                                                        {{ $errors->first() }}
                                                    </span>
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">
                                                        &times;
                                                    </span>
                                                </button>
                                            </div>
                                        @endif

                                        @if (session('success'))
                                            <div class="alert alert-success alert-dismissible fade show" role="alert" style="font-size: 0.9rem;">
                                                <i class="fas fa-check-circle mr-1"></i> {{ session('success') }}
                                            </div>
                                        @endif
                                        
                                        <form action="{{ route('login') }}" method="post">
                                            @csrf

                                            <div class="form-group mb-3">
                                                <input type="text" name="username"
                                                    class="form-control form-control-user py-4"
                                                    placeholder="Username" value="{{ old('username') }}"
                                                    required>
                                            </div>

                                            <div class="form-group mb-3">
                                                <div class="input-group">
                                                    <input type="password" name="password"
                                                        class="form-control form-control-user py-4"
                                                        placeholder="Password" required id="password" style="border-right: 0;">
                                                    <div class="input-group-append">
                                                        <div class="input-group-text bg-white" style="border-left: 0;">
                                                            <span class="fas fa-eye toggle-password" data-target="#password"
                                                                style="cursor: pointer; color: #6c757d;"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <button type="submit" class="btn btn-primary btn-block py-2 mt-3">
                                                Masuk
                                            </button>
                                        </form>

                                        <hr>
                                        <div class="text-center">
                                            <p class="mb-0">Belum punya akun? <a class="medium"
                                                href="{{ route('register') }}">Daftar disini</a></p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6 d-none d-lg-block image-section">
                                    <div id="carouselLogin" class="carousel slide h-100" data-ride="carousel">
                                        <ol class="carousel-indicators">
                                            <li data-target="#carouselLogin" data-slide-to="0" class="active"></li>
                                            <li data-target="#carouselLogin" data-slide-to="1"></li>
                                            <li data-target="#carouselLogin" data-slide-to="2"></li>
                                        </ol>
                                        <div class="carousel-inner h-100">
                                            <div class="carousel-item active h-100">
                                                <img class="image-cover" style="object-fit: cover;"
                                                    src="{{ asset('assets/img/2.jpg') }}" alt="Library 1">
                                            </div>
                                            <div class="carousel-item h-100">
                                                <img class="image-cover"
                                                    src="{{ asset('assets/img/3.jpg') }}" alt="Library 2">
                                            </div>
                                            <div class="carousel-item h-100">
                                                <img class="image-cover"
                                                    src="{{ asset('assets/img/7.jpg') }}" alt="Library 3">
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
    <!-- Inspect Password -->
    <script src="{{ asset('assets/js/inspectPassword.js') }}"></script>
    <!-- jQuery -->
    <script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('adminlte/dist/js/adminlte.min.js') }}"></script>
</body>

</html>