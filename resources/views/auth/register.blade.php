<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - PKL BNA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* CSS Kustom (Sesuai dengan login.blade.php) */
        .bg-custom-dark {
            background-color: #002D62; /* Biru gelap tema */
        }
        .register-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: url('{{ asset('gambar/bgsekolah.jpg') }}') center/cover no-repeat fixed;
            position: relative;
            padding: 30px 0;
        }
        .register-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.7); /* Overlay gelap */
            z-index: 1;
        }
        .card-register {
            width: 100%;
            max-width: 500px; /* Sedikit lebih lebar dari login karena lebih banyak field */
            z-index: 2;
        }
    </style>
</head>
<body>

<div class="register-container">
    <div class="card card-register p-4 shadow-lg border-0">
        <div class="card-body">
            <!-- Logo dan Judul -->
            <div class="text-center mb-4">
                <img src="{{ asset('gambar/logo.png') }}" alt="Logo PKL BNA" width="70" class="rounded-circle mb-3 border border-3 border-primary">
                <h3 class="fw-bold mb-0">Buat Akun Baru</h3>
                <p class="text-muted">Daftar untuk memulai Praktik Kerja Lapangan</p>
            </div>
            
            <!-- Pesan Error/Validasi -->
            @if ($errors->any())
                <div class="alert alert-danger small" role="alert">
                    <ul class="mb-0 ps-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Name -->
                <div class="mb-3">
                    <label for="name" class="form-label fw-semibold">Nama Lengkap</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" class="form-control form-control-lg">
                </div>

                <!-- Email Address -->
                <div class="mb-3">
                    <label for="email" class="form-label fw-semibold">Alamat Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" class="form-control form-control-lg">
                </div>

                <!-- Password -->
                <div class="mb-3">
                    <label for="password" class="form-label fw-semibold">Kata Sandi</label>
                    <input id="password" type="password" name="password" required autocomplete="new-password" class="form-control form-control-lg">
                </div>

                <!-- Confirm Password -->
                <div class="mb-4">
                    <label for="password_confirmation" class="form-label fw-semibold">Konfirmasi Kata Sandi</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" class="form-control form-control-lg">
                </div>

                <!-- Tombol dan Link Login -->
                <div class="d-grid mb-3">
                    <button type="submit" class="btn btn-primary btn-lg fw-bold shadow">
                        Daftar
                    </button>
                </div>

                <div class="text-center">
                    <p class="small">
                        Sudah terdaftar? <a href="{{ route('login') }}" class="text-primary fw-semibold text-decoration-none">Masuk</a>
                    </p>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>