<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - Helpdesk</title>

    <!-- Vendor CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/base/vendor.bundle.base.css') }}">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="shortcut icon" href="{{ asset('user/img/logo/logoo.jpeg') }}" />

    <style>
        body {
            background: linear-gradient(135deg, #bcd9ff, #d9eaff);
            font-family: "Poppins", sans-serif;
        }

        .auth-form-transparent {
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            padding: 2.5rem;
            width: 90%;
            max-width: 420px;
            animation: fadeInUp 0.6s ease;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .brand-logo img {
            width: 130px;
            height: auto;
        }

        .btn-google {
            background-color: #db4437;
            color: #fff !important;
            border: none;
        }

        .btn-google:hover {
            background-color: #c23321;
        }

        .login-half-bg {
            background: url('{{ asset('assets/images/auth/helpdesk.png') }}') center center no-repeat;
            background-size: cover;
            position: relative;
            border-radius: 0 20px 20px 0;
            min-height: 100vh;
            display: flex;
            align-items: flex-end;
            justify-content: center;
        }

        .login-half-bg::before {
            content: "";
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.35);
            border-radius: 0 20px 20px 0;
        }

        .login-half-bg p {
            position: relative;
            z-index: 2;
            color: #ffffff;
            font-size: 14px;
            margin-bottom: 25px;
        }

        .auth-form-btn {
            border-radius: 10px;
            transition: 0.3s;
        }

        .auth-form-btn:hover {
            transform: translateY(-2px);
        }

        @media (max-width: 992px) {
            .login-half-bg {
                display: none;
            }

            .auth-form-transparent {
                margin: 3rem auto;
            }
        }
    </style>
</head>

<body>
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="content-wrapper d-flex align-items-stretch auth auth-img-bg">
                <div class="row flex-grow">
                    <!-- Left Form Section -->
                    <div class="col-lg-6 d-flex align-items-center justify-content-center">
                        <div class="auth-form-transparent text-left">

                            <!-- Brand Logo -->
                            <div class="brand-logo text-center mb-4">
                                <img src="{{ asset('user/img/logo/logoo.jpeg') }}" alt="logo">
                            </div>

                            <h4 class="text-center mb-1 fw-bold text-primary">Selamat Datang!</h4>
                            <p class="text-center text-muted mb-4">Silakan login untuk melanjutkan ke sistem Helpdesk</p>

                            <!-- Error Message -->
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    {{ $errors->first() }}
                                </div>
                            @endif

                            <form class="pt-3" method="POST" action="{{ route('login.post') }}">
                                @csrf

                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-transparent border-right-0">
                                            <i class="mdi mdi-email-outline text-primary"></i>
                                        </span>
                                        <input type="email" name="email"
                                            class="form-control form-control-lg border-left-0"
                                            placeholder="Masukkan email" required>
                                    </div>
                                </div>

                                <div class="form-group mt-3">
                                    <label for="password">Password</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-transparent border-right-0">
                                            <i class="mdi mdi-lock-outline text-primary"></i>
                                        </span>
                                        <input type="password" name="password"
                                            class="form-control form-control-lg border-left-0"
                                            placeholder="Masukkan password" required>
                                    </div>
                                </div>

                                <div class="my-2 d-flex justify-content-between align-items-center">
                                    <div class="form-check">
                                        <label class="form-check-label text-muted">
                                            <input type="checkbox" class="form-check-input"> Ingat saya
                                        </label>
                                    </div>
                                </div>

                                <div class="my-3">
                                    <button type="submit"
                                        class="btn btn-primary btn-block btn-lg font-weight-medium auth-form-btn">
                                        LOGIN
                                    </button>
                                </div>

                                <div class="mb-2 d-flex">
                                    <a href="{{ route('google.redirect') }}" class="btn btn-google auth-form-btn flex-grow">
                                        <i class="mdi mdi-google me-2"></i> Login dengan Google
                                    </a>
                                </div>

                                <div class="text-center mt-4 font-weight-light">
                                    Belum punya akun?
                                    <span class="text-muted">Silakan masuk menggunakan akun Google.</span>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Right Background Section -->
                    <div class="col-lg-6 login-half-bg">
                        <p class="text-white font-weight-medium text-center mb-3">
                            © {{ date('Y') }} Helpdesk — All Rights Reserved
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JS -->
    <script src="{{ asset('assets/vendors/base/vendor.bundle.base.js') }}"></script>
    <script src="{{ asset('assets/js/off-canvas.js') }}"></script>
    <script src="{{ asset('assets/js/hoverable-collapse.js') }}"></script>
    <script src="{{ asset('assets/js/template.js') }}"></script>
</body>

</html>
