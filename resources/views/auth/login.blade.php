<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - PKL BNA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .bg-custom-dark {
            background-color: #002D62;
        }
        .login-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: url('{{ asset('gambar/bgsekolah.jpg') }}') center/cover no-repeat fixed;
            position: relative;
            padding: 30px 0;
        }
        .login-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.7);
            z-index: 1;
        }
        .card-login {
            width: 100%;
            max-width: 450px;
            z-index: 2;
        }
    </style>
</head>
<body>

<div class="login-container">
    <div class="card card-login p-4 shadow-lg border-0">
        <div class="card-body">

            <!-- LOGO & TITLE -->
            <div class="text-center mb-4">
                <img src="{{ asset('gambar/logo.png') }}" 
                     alt="Logo PKL BNA" 
                     width="70" 
                     class="rounded-circle mb-3 border border-3 border-primary">

                <h3 class="fw-bold mb-0">Selamat Datang</h3>
                <p class="text-muted">Praktik Kerja Lapangan SMK Bela Nusantara Andika</p>
            </div>

            <!-- STATUS / ERROR MESSAGE -->
            @if (session('status'))
                <div class="alert alert-success small">{{ session('status') }}</div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger small">
                    <ul class="mb-0 ps-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- LOGIN FORM -->
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- USERNAME -->
                <div class="mb-3">
                    <label for="username" class="form-label fw-semibold">Username/NIS/NIP</label>
                    <input id="username" 
                           type="text" 
                           name="username" 
                           value="{{ old('username') }}"
                           required 
                           autofocus 
                           autocomplete="off"
                           class="form-control form-control-lg">
                </div>

                <!-- PASSWORD -->
                <div class="mb-3">
                    <label for="password" class="form-label fw-semibold">Kata Sandi</label>
                    <input id="password" 
                           type="password" 
                           name="password" 
                           required 
                           autocomplete="new-password"
                           class="form-control form-control-lg">
                </div>

                <!-- LOGIN BUTTON -->
                <div class="d-grid mb-3">
                    <button type="submit" class="btn btn-primary btn-lg fw-bold shadow">
                        Masuk
                    </button>
                </div>

                <!-- Forgot Password -->
                <div class="text-center">
                    @if (Route::has('password.request'))
                        <a class="small text-decoration-none text-muted" 
                           href="{{ route('password.request') }}">
                            Lupa Kata Sandi?
                        </a>
                    @endif
                </div>

            </form>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.
