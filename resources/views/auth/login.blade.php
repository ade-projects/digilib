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
</head>

<body class="hold-transition login-page">
    <!-- /.login-box -->
    <div class="login-page"
        style="height: 100vh; display: flex; align-items: center; justify-content: center; background: #e9ecef;">

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-11 col-xl-10">

                    <div class="card border-0 shadow-lg overflow-hidden" style="border-radius: 15px;">
                        <div class="card-body p-0">

                            <div class="row no-gutters">

                                <div class="col-lg-6 d-flex align-items-center bg-white">
                                    <div class="p-5 w-100" style="min-height: 450px;">
                                        <div class="text-center mb-4">
                                            <h1 class="h4 text-gray-900 mb-4">Selamat Datang di <b>Digilib</b></h1>
                                        </div>

                                        @if ($errors->any())
                                            <div class="alert alert-danger alert dismissable fade show" role="alert">
                                                <div class="d-flex align-items-center">
                                                    <i class="fas fa-exclamation-triangle mr-2"></i>
                                                    <span>
                                                        Username atau password Anda salah.
                                                    </span>
                                                </div>
                                                {{-- <button type="button" class="close" data-dismiss="alert"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button> --}}
                                            </div>
                                        @endif
                                        <form action="{{ route('login') }}" method="post">
                                            @csrf
                                            <div class="form-group mb-3">
                                                <input type="text" name="username"
                                                    class="form-control form-control-user py-4"
                                                    placeholder="Masukkan Username" required>
                                            </div>
                                            <div class="form-group mb-3">
                                                <input type="password" name="password"
                                                    class="form-control form-control-user py-4"
                                                    placeholder="Masukkan Password" required>
                                            </div>
                                            <div class="form-group">
                                                <div class="custom-control custom-checkbox small">
                                                    <input type="checkbox" class="custom-control-input"
                                                        id="customCheck">
                                                    <label class="custom-control-label" for="customCheck">Ingat
                                                        Saya</label>
                                                </div>
                                            </div>
                                            <button type="submit" class="btn btn-primary btn-block py-2">
                                                Login
                                            </button>
                                        </form>

                                        <hr>
                                        <div class="text-center">
                                            <a class="small" href="#">Lupa Password?</a>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6 d-none d-lg-block bg-primary p-0">
                                    <div id="carouselIndicators" class="carousel slide h-100" data-ride="carousel">
                                        <ol class="carousel-indicators">
                                            <li data-target="#carouselIndicators" data-slide-to="0" class="active"></li>
                                            <li data-target="#carouselIndicators" data-slide-to="1"></li>
                                            <li data-target="#carouselIndicators" data-slide-to="2"></li>
                                        </ol>
                                        <div class="carousel-inner h-100">
                                            <div class="carousel-item active h-100">
                                                <img class="d-block w-100 h-100" style="object-fit: cover;"
                                                    src="{{ asset('assets/img/1.jpg') }}" alt="Slide 1">
                                                <div class="carousel-caption d-none d-md-block">
                                                </div>
                                            </div>
                                            <div class="carousel-item h-100">
                                                <img class="d-block w-100 h-100" style="object-fit: cover;"
                                                    src="{{ asset('assets/img/1.jpg') }}" alt="Slide 2">
                                            </div>
                                            <div class="carousel-item h-100">
                                                <img class="d-block w-100 h-100" style="object-fit: cover;"
                                                    src="{{ asset('assets/img/1.jpg') }}" alt="Slide 3">
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
    <!-- jQuery -->
    <script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('adminlte/dist/js/adminlte.min.js') }}"></script>
</body>

</html>