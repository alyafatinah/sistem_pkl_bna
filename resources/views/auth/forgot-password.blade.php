<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Kata Sandi - PKL BNA</title>
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
            inset: 0;
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

            {{-- LOGO & TITLE --}}
            <div class="text-center mb-4">
                <img src="{{ asset('gambar/logo.png') }}" alt="Logo PKL BNA" width="70"
                     class="rounded-circle mb-3 border border-3 border-primary">
                <h3 class="fw-bold mb-0">Lupa Kata Sandi?</h3>
                <p class="text-muted small mb-0">
                    Praktik Kerja Lapangan SMK Bela Nusantara Andika
                </p>
            </div>

            {{-- INFO TEXT --}}
            <p class="text-muted small mb-3">
                Lupa kata sandi? Tidak masalah. Masukkan alamat email yang terdaftar pada sistem.
                Kami akan mengirimkan tautan untuk mengatur ulang kata sandi Anda.
            </p>

            {{-- STATUS BERHASIL KIRIM LINK --}}
            @if (session('status'))
                <div class="alert alert-success py-2 small">
                    {{ session('status') }}
                </div>
            @endif

            {{-- ERROR VALIDASI --}}
            @if ($errors->any())
                <div class="alert alert-danger py-2 small">
                    <ul class="mb-0 ps-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- FORM RESET PASSWORD --}}
            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="mb-3">
                    <label for="email" class="form-label fw-semibold">Alamat Email</label>
                    <input id="email"
                           type="email"
                           name="email"
                           value="{{ old('email') }}"
                           class="form-control form-control-lg"
                           required
                           autofocus>
                </div>

                <div class="d-grid mb-3">
                    <button type="submit" class="btn bg-custom-dark text-white fw-bold btn-lg">
                        Kirim Link Reset Kata Sandi
                    </button>
                </div>

                <div class="text-center">
                    <a href="{{ route('login') }}" class="small text-decoration-none text-muted">
                        &larr; Kembali ke halaman masuk
                    </a>
                </div>
            </form>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
