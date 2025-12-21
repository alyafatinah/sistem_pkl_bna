@stack('scripts')

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Dashboard | PKL SMK BNA</title>

    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="{{ asset('sbadmin1/css/styles.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('sbadmin1/js/scripts.js') }}"></script>

    <style>
        .sidebar-premium {
            background: #002D62;
            color: white;
            width: 250px;
        }

        .sidebar-premium .nav-link {
            transition: all 0.3s ease;
            padding: 10px 20px;
            border-radius: 4px;
            margin: 2px 6px;
        }

        .sidebar-premium .nav-link:hover {
            background: #004a99;
            transform: translateX(5px);
        }

        .nested-menu .nav-link {
            font-size: 0.9rem;
            padding-left: 35px;
        }

        .badge-notif {
            background: #ff4757;
            padding: 4px 8px;
            border-radius: 10px;
            font-size: 0.65rem;
            margin-left: auto;
            color: white;
        }

        .nav-icon {
            width: 20px;
            display: inline-block;
        }

        .text-custom-second {
            font-size: 0.75rem;
            /* lebih kecil */
            color: #adb5bd;
            /* grey lembut */
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
    </style>
</head>

<body class="sb-nav-fixed">

    {{-- ===================== TOP NAVBAR ===================== --}}
    <nav class="sb-topnav navbar navbar-expand navbar-dark" style="background-color: #0050a5;">
        <a class="navbar-brand ps-3 fw-bold d-flex align-items-center gap-2" href="{{ route('dashboard') }}">
            <img src="{{ asset('gambar/logo.png') }}" alt="Logo BNA" style="height: 35px;">
            PKL SMK BNA
        </a>

        <button class="btn btn-link btn-sm me-4" id="sidebarToggle">
            <i class="fas fa-bars"></i>
        </button>

        <ul class="navbar-nav ms-auto me-3">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                    {{ Auth::user()->name }}
                </a>

                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <a class="dropdown-item" href="{{ route('profile.edit') }}">Profile</a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="dropdown-item">Logout</button>
                        </form>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>

    <div id="layoutSidenav">

        {{-- ===================== SIDEBAR ===================== --}}
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sidebar-premium" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">

                        {{-- MENU UMUM --}}
                        <div class="sb-sidenav-menu-heading text-custom-second">
                            Core
                        </div>

                        {{-- dashboard humas dan admin --}}
                        @if (in_array(auth()->user()->role_id, [2, 5]))
                            <a class="nav-link text-white" href="{{ route('dashboard') }}">
                                <i class="bi bi-speedometer2 nav-icon"></i> Dashboard
                            </a>
                        @endif

                        {{-- dashboard kaprod --}}
                        @if (auth()->user()->role_id == 1)
                            <a class="nav-link text-white" href="{{ route('dashboard.kaprodi') }}">
                                <i class="bi bi-speedometer2 nav-icon"></i> Dashboard
                            </a>
                        @endif

                        {{-- dashboard guru pembimbing --}}
                        @if (auth()->user()->role_id == 3)
                            <a class="nav-link text-white" href="{{ route('dashboard.guru') }}">
                                <i class="bi bi-speedometer2 nav-icon"></i> Dashboard
                            </a>
                        @endif

                        {{-- dashboard siswa --}}
                        @if (auth()->user()->role_id == 4)
                            <a class="nav-link text-white" href="{{ route('dashboard.siswa') }}">
                                <i class="bi bi-speedometer2 nav-icon"></i> Dashboard
                            </a>
                        @endif

                        @if (Route::has('jadwal.index'))
                            <a class="nav-link text-white" href="{{ route('jadwal.index') }}">
                                <i class="bi bi-calendar-week-fill nav-icon"></i> Jadwal PKL
                            </a>
                        @endif

                        {{-- ===================== ADMIN ===================== --}}
                        @if (auth()->user()->role_id == 5)

                            <div class="sb-sidenav-menu-heading text-custom-second">
                                Data
                            </div>

                            {{-- DATA SISWA --}}
                            @if (Route::has('siswa.index'))
                                <a class="nav-link text-white d-flex align-items-center"
                                    href="{{ route('siswa.index') }}">
                                    <i class="bi bi-people-fill nav-icon me-2"></i>
                                    <span>Data Siswa</span>
                                </a>
                            @endif

                            {{-- DATA GURU PEMBIMBING --}}
                            @if (Route::has('guruPembimbing.index'))
                                <a class="nav-link text-white d-flex align-items-center"
                                    href="{{ route('guruPembimbing.index') }}">
                                    <i class="bi bi-person-badge-fill nav-icon me-2"></i>
                                    <span>Data Guru Pembimbing</span>
                                </a>
                            @endif

                            {{-- DATA MITRA DUDI --}}
                            @if (Route::has('mitra.index'))
                                <a class="nav-link text-white d-flex align-items-center"
                                    href="{{ route('mitra.index') }}">
                                    <i class="bi bi-buildings-fill nav-icon me-2"></i>
                                    <span>Data Mitra DUDI</span>
                                </a>
                            @endif

                            {{-- Halaman kelola Kaprodi --}}
                            @if (Route::has('kaprod.index'))
                                <a class="nav-link text-white d-flex align-items-center"
                                    href="{{ route('kaprod.index') }}">
                                    <i class="bi bi-person-badge-fill nav-icon me-2"></i>
                                    <span>Data Kepala Prodi</span>
                                </a>
                            @endif

                            {{-- halaman user --}}
                            @if (Route::has('user.index'))
                                <a class="nav-link text-white d-flex align-items-center"
                                    href=" {{ route('user.index') }}">
                                    <i class="bi bi-person-lines-fill nav-icon me-2"></i>
                                    <span>Data Semua User</span>
                                </a>
                            @endif

                            {{-- Halaman Humas --}}
                            @if (Route::has('humas.index'))
                                <a class="nav-link text-white d-flex align-items-center" href="#">
                                    {{-- href="{{ route('user.index') }}"> --}}
                                    <i class="bi bi-buildings-fill nav-icon me-2"></i>
                                    <span>Data Humas</span>
                                </a>
                            @endif

                            {{-- Halaman Jurusan --}}
                            @if (Route::has('jurusan.index'))
                                <a class="nav-link text-white d-flex align-items-center" href="#">
                                    {{-- href="{{ route('user.index') }}"> --}}
                                    <i class="bi bi-buildings-fill nav-icon me-2"></i>
                                    <span>Data Jurusan</span>
                                </a>
                            @endif

                            {{-- Halaman role --}}
                            @if (Route::has('role.index'))
                                <a class="nav-link text-white d-flex align-items-center" href="#">
                                    {{-- href="{{ route('user.index') }}"> --}}
                                    <i class="bi bi-buildings-fill nav-icon me-2"></i>
                                    <span>Data Role</span>
                                </a>
                            @endif

                            <div class="sb-sidenav-menu-heading text-custom-second">
                                Kegiatan PKL
                            </div>

                            {{-- Halaman Jurnal --}}
                            @if (Route::has('jurnal.index'))
                                <div>
                                    <a class="nav-link text-white" href="{{ route('jurnal.index') }}">
                                        <i class="bi bi-journal-text nav-icon"></i> Jurnal Siswa
                                    </a>
                                </div>
                            @endif

                            {{-- halaman nilai --}}
                            <a class="nav-link text-white" href="{{ route('nilai.index') }}">
                                <i class="bi bi-file-earmark-text-fill nav-icon"></i>
                                <span>Nilai PKL</span>
                            </a>


                        @endif

                        {{-- ===================== KAPRODI ===================== --}}
                        @if (auth()->user()->role_id == 1)
                            <div class="sb-sidenav-menu-heading text-custom-second">
                                Data
                            </div>

                            {{-- DATA SISWA --}}

                            <a class="nav-link text-white d-flex align-items-center"
                                href="{{ route('siswa.per_jurusan', auth()->user()->kaprod->jurusan_id) }}">
                                <i class="bi bi-people-fill nav-icon me-2"></i>
                                <span>Data Siswa </span>
                            </a>


                            {{-- DATA GURU PEMBIMBING --}}
                            <a class="nav-link text-white d-flex align-items-center"
                                href="{{ route('gurupembimbing.per_jurusan', auth()->user()->kaprod->jurusan_id) }}">
                                <i class="bi bi-people-fill nav-icon me-2"></i>
                                <span> Data Guru Pembimbing </span>
                            </a>

                            {{-- DATA MITRA DUDI --}}
                            @if (Route::has('mitra.index'))
                                <a class="nav-link text-white d-flex align-items-center"
                                    href="{{ route('mitra.index') }}">
                                    <i class="bi bi-buildings-fill nav-icon me-2"></i>
                                    <span>Semua Mitra DUDI</span>
                                </a>
                            @endif


                            <div class="sb-sidenav-menu-heading text-custom-second">
                                Kegiatan PKL
                            </div>

                            {{-- Halaman Jurnal_perJurusan --}}
                            <a class="nav-link text-white d-flex align-items-center"
                                href="{{ route('jurnal.per_jurusan', auth()->user()->kaprod->jurusan_id) }}">
                                <i class="bi bi-journal-text nav-icon me-2"></i>
                                <span>Jurnal Siswa</span>
                            </a>

                            {{-- halaman nilai --}}
                            <a class="nav-link text-white d-flex align-items-center"
                                href="{{ route('nilai.per_jurusan', auth()->user()->kaprod->jurusan_id) }}">
                                <i class="bi bi-award-fill nav-icon me-2"></i>
                                <span>Nilai Siswa</span>
                            </a>


                        @endif


                        {{-- ===================== HUMAS ===================== --}}
                        @if (auth()->user()->role_id == 2)
                            <div class="sb-sidenav-menu-heading text-custom-second">
                                Data
                            </div>

                            {{-- DATA SISWA --}}
                            @if (Route::has('siswa.index'))
                                <a class="nav-link text-white d-flex align-items-center"
                                    href="{{ route('siswa.index') }}">
                                    <i class="bi bi-people-fill nav-icon me-2"></i>
                                    <span>Data Siswa</span>
                                </a>
                            @endif

                            {{-- DATA GURU PEMBIMBING --}}
                            @if (Route::has('guruPembimbing.index'))
                                <a class="nav-link text-white d-flex align-items-center"
                                    href="{{ route('guruPembimbing.index') }}">
                                    <i class="bi bi-person-badge-fill nav-icon me-2"></i>
                                    <span>Data Guru Pembimbing</span>
                                </a>
                            @endif

                            {{-- DATA MITRA DUDI --}}
                            @if (Route::has('mitra.index'))
                                <a class="nav-link text-white d-flex align-items-center"
                                    href="{{ route('mitra.index') }}">
                                    <i class="bi bi-buildings-fill nav-icon me-2"></i>
                                    <span>Data Mitra DUDI</span>
                                </a>
                            @endif

                            {{-- Halaman kelola Kaprodi --}}
                            @if (Route::has('kaprod.index'))
                                <a class="nav-link text-white d-flex align-items-center"
                                    href="{{ route('kaprod.index') }}">
                                    <i class="bi bi-person-badge-fill nav-icon me-2"></i>
                                    <span>Data Kepala Prodi</span>
                                </a>
                            @endif

                            <div class="sb-sidenav-menu-heading text-custom-second">
                                Kegiatan PKL
                            </div>

                            {{-- halaman nilai --}}
                            <a class="nav-link text-white" href="{{ route('nilai.index') }}">
                                <i class="bi bi-file-earmark-text-fill nav-icon"></i>
                                <span>Nilai PKL</span>
                            </a>


                        @endif

                        {{-- ===================== GURU PEMBIMBING===================== --}}
                        @if (auth()->user()->role_id == 3)
                            <div class="sb-sidenav-menu-heading text-custom-second">
                                Data
                            </div>

                            {{-- DATA SISWA --}}
                            <a class="nav-link text-white d-flex align-items-center"
                                href="{{ route('siswa.per_jurusan', auth()->user()->guruPembimbing->jurusan_id) }}">
                                <i class="bi bi-people-fill nav-icon me-2"></i>
                                <span>Data Siswa Jurusan</span>
                            </a>


                            <div class="sb-sidenav-menu-heading text-custom-second">
                                Kegiatan PKL
                            </div>

                            {{-- Halaman Jurnal_perJurusan --}}
                            <a class="nav-link text-white d-flex align-items-center"
                                href="{{ route('jurnal.per_jurusan', auth()->user()->guruPembimbing->jurusan_id) }}">
                                <i class="bi bi-journal-text nav-icon me-2"></i>
                                <span>Jurnal Siswa</span>
                            </a>

                            {{-- halaman nilai --}}
                            <a class="nav-link text-white d-flex align-items-center"
                                href="{{ route('nilai.per_jurusan', auth()->user()->guruPembimbing->jurusan_id) }}">
                                <i class="bi bi-award-fill nav-icon me-2"></i>
                                <span>Nilai Siswa</span>
                            </a>
                        @endif

                        {{-- ===================== SISWA ===================== --}}
                        @if (auth()->user()->role_id == 4)
                            <div class="sb-sidenav-menu-heading text-custom-second">
                                Kegiatan PKL
                            </div>

                            {{-- Halaman Jurnal --}}

                            <a class="nav-link text-white d-flex align-items-center"
                                href="{{ route('jurnal.per_siswa', auth()->user()->siswa->id) }}">
                                <i class="bi bi-journal-text nav-icon me-2"></i>
                                <span>Jurnal Siswa</span>
                            </a>

                            {{-- halaman nilai --}}
                            <a class="nav-link text-white d-flex align-items-center"
                                href="{{ route('nilai.per_siswa', auth()->user()->siswa->id) }}">
                                <i class="bi bi-file-earmark-text-fill nav-icon me-2"></i>
                                <span>Nilai PKL</span>
                            </a>
                        @endif



                    </div>
                </div>

                <div class="sb-sidenav-footer text-custom-primary">
                    <div class="small">Logged in as:</div>
                    <strong>{{ Auth::user()->name }}</strong>
                </div>
            </nav>
        </div>

        {{-- ===================== CONTENT ===================== --}}
        <div id="layoutSidenav_content">
            <main class="p-4 bg-white">
                @yield('content')
            </main>
        </div>

    </div>
</body>

</html>
