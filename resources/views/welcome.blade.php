<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome - PKL BNA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* CSS Tambahan untuk kustomisasi */
        /* Warna Aksen Kustom (misalnya, biru tua) */
        .bg-custom-dark {
            background-color: #002D62;
            /* Biru gelap untuk footer atau elemen lain */
        }

        .text-custom-primary {
            color: #007bff;
            /* Warna biru primer */
        }

        /* Hero Section */
        .hero-section {
            padding: 10rem 0;
            /* Membuat Hero lebih tinggi */
            background-attachment: fixed;
            /* Efek parallax ringan */
            background-size: cover;
            position: relative;
            z-index: 1;
            /* Agar konten di atas overlay */
        }

        .hero-overlay {
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.6);
            /* Lebih gelap agar teks putih lebih menonjol */
            z-index: 2;
        }

        .hero-content {
            position: relative;
            z-index: 3;
        }

        /* Card Hover Effect */
        .card-hover-effect:hover {
            transform: translateY(-5px);
            /* Geser ke atas saat di-hover */
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15) !important;
            /* Bayangan lebih jelas */
            transition: all 0.3s ease;
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-custom-dark shadow-lg sticky-top">
        <div class="container">
            {{-- PERHATIAN: src="{{ asset('gambar/logo.png') }}" HANYA BEKERJA DI LARAVEL/BLADE --}}
            <a class="navbar-brand fw-bolder fs-4" href="#">
                <img src="gambar/logo.png" alt="Logo" width="40" height="40"
                    class="me-2 rounded-circle border border-white">
                PKL BNA
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom" href="#tentang">Tentang PKL</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom" href="#profile">Profil Sekolah</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom" href="#alamat">Alamat</a>
                    </li>
                </ul>

            </div>
        </div>
    </nav>

    <header class="text-white text-center hero-section" {{-- PERHATIAN: style="background-image: url('{{ asset('gambar/bgsekolah.jpg') }}');" HANYA BEKERJA DI LARAVEL/BLADE --}}
        style="background-image: url('gambar/bgsekolah.jpg');">
        <div class="hero-overlay"></div>
        <div class="container hero-content">
            <h1 class="display-3 fw-bold mb-3 animate__animated animate__fadeInDown">SMK BELA NUSANTARA ANDIKA</h1>
            <p class="lead fs-4 mb-5 animate__animated animate__fadeInUp">Praktek Kerja Lapangan
            </p>

            @if (Route::has('login'))
                <div class="d-flex justify-content-center gap-3 animate__animated animate__fadeInUp animate__delay-1s">
                    @guest
                        {{-- Masuk --}}
                        <a href="{{ route('login') }}"
                            class="btn btn-warning btn-lg px-5 py-3 fw-bold rounded-pill shadow-lg">Masuk</a>

                        {{-- register  --}}
                    @else
                        <a href="{{ route('dashboard') }}"
                            class="btn btn-success btn-lg px-5 py-3 fw-bold rounded-pill shadow-lg">Akses Dashboard</a>
                    @endguest
                </div>
            @endif

        </div>
    </header>

    <section id="tentang" class="py-5 bg-light">
        <div class="container">
            <h2 class="display-5 fw-bold text-center mb-5 text-custom-primary">Tentang PKL</h2>
            <div class="row g-4 justify-content-center">
                <div class="col-lg-4 col-md-6">
                    <div class="card shadow-sm h-100 p-3 border-0 card-hover-effect">
                        <div class="card-body text-center">
                            <i class="bi bi-briefcase-fill d-block fs-1 mb-3 text-custom-primary"></i>
                            <h5 class="card-title fw-bolder mb-3">Apa itu PKL?</h5>
                            <p class="card-text text-muted">PKL adalah kegiatan belajar di dunia kerja untuk
                                mengembangkan keterampilan, pengalaman nyata, dan pemahaman mendalam tentang lingkungan
                                profesional.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="card shadow-sm h-100 p-3 border-0 card-hover-effect">
                        <div class="card-body text-center">
                            <i class="bi bi-bullseye d-block fs-1 mb-3 text-custom-primary"></i>
                            <h5 class="card-title fw-bolder mb-3">Tujuan PKL</h5>
                            <p class="card-text text-muted">Meningkatkan kompetensi profesional dan kesiapan kerja
                                melalui pengalaman industri yang terstruktur dan terarah.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="card shadow-sm h-100 p-3 border-0 card-hover-effect">
                        <div class="card-body text-center">
                            <i class="bi bi-graph-up d-block fs-1 mb-3 text-custom-primary"></i>
                            <h5 class="card-title fw-bolder mb-3">Manfaat PKL</h5>
                            <p class="card-text text-muted">Menambah wawasan, membangun relasi kerja yang luas, dan
                                mempersiapkan diri secara mental dan keahlian untuk memasuki dunia kerja.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="profile" class="bg-custom-dark text-white py-5">
        <div class="container">
            <h2 class="display-5 fw-bold text-center mb-5">🏫 Profil Sekolah</h2>

            <div class="row g-5">
                <div class="col-md-6">
                    <h3 class="fw-bold border-bottom pb-2 mb-4">Tentang SMK BNA</h3>
                    <p class="lead">
                        SMK Bela Nusantara Andika berorientasi pada sekolah berstandar internasional dan menerapkan
                        Manajemen Mutu SNI-ISO 9001-2008, didukung oleh ratusan Instansi dan Industri.
                    </p>
                    <p class="small">
                        Yayasan Pendidikan Bela Nusantara peduli dan berkomitmen pada peningkatan kualitas pendidikan,
                        dengan isin operasional keputusan Kepala Kanwil Depdikbud Provinsi Jawa Barat No.
                        339/1.02/OT/98, merupakan satu – satunya Sekolah Swasta yang menerapkan Manajemen Mutu SNI-ISO
                        9001-2008 dan berkomitmen terhadap pencapaian mutu lulusan yang unggul serta keberadaannya
                        didukung oleh lebih dari 279 Instansi dan Industri yang berada di wilayah Cianjur, Jakarta,
                        Bogor, Bandung, Tangerang, Sukabumi dan Kota – Kota lainnya. Sejalan dengan visi Dinas
                        Pendidikan Provinsi Jawa Barat serta visi dari Dinas Pendidikan dan Kebudayaan Kabupaten
                        Cianjur. SMK Bela Nusantara Andika hadir memenuhi tuntutan masyarakat yang mendambakan lulusan
                        SMK yang beriman, bertakwa, berakhlak mulia, berketerampilan serta berpengetahuan dan langsung
                        dapat bekerja atau melanjutkan ke Perguruan tinggi. SMK Bela Nusantara Andika berorientasi pada
                        sekolah berstandar internasional dan keberadaannya didukung oleh lebih dari 99 industri yang
                        berada di Cianjur, Jakarta, Bogor, Bandung, Tangerang, Sukabumi, dan lain-lain.
                    </p>
                    <ul class="list-unstyled mt-4 small">
                        <li>NPSN: 69933509</li>
                        <li>Status: Swasta</li>
                        <li>Bentuk Pendidikan: SMK</li>
                        <li>Tanggal SK Pendirian: 2015-02-03</li>
                    </ul>
                </div>

                <div class="col-md-6">
                    <h3 class="fw-bold border-bottom pb-2 mb-4">Visi & Misi</h3>

                    <div class="mb-4 p-3 bg-white rounded shadow-sm text-dark">
                        <p class="fw-bolder mb-1 text-custom-primary">Visi:</p>
                        <p class="small">Terwujudnya SMK Bela Nusantara Cianjur yang didasari Iman dan Taqwa sebagai
                            SMK Model dengan tamatan yang kompeten untuk bekerja atau mengikuti pendidikan lebih lanjut
                            dan mampu bersaing di tingkat regional, nasional maupun internasional.</p>
                    </div>

                    <p class="fw-bolder text-warning mt-3 mb-2">Misi:</p>
                    <ul class="small">
                        <li>Mengembangkan sikap dan perilaku peserta didik yang beriman dan bertaqwa kepada Tuhan Yang
                            Maha Esa.</li>
                        <li>Mengembangkan kesadaran tentang pentingnya kedisiplinan dan kesehatan kerja serta lingkungan
                            yang bersih, hijau, dan sehat.</li>
                        <li>Mengembangkan sikap kreatif dan inovatif peserta didik untuk menjawab tantangan revolusi
                            industri 4.0.</li>
                        <li>Mengembangkan kerjasama dengan DU/DI dalam membentuk karakter kerja dan karakter
                            berwirausaha peserta didik.</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section id="alamat" class="py-5 bg-light">
        <div class="container text-center">
            <h2 class="display-5 fw-bold mb-4 text-custom-primary">📍 Alamat Kami</h2>
            <p class="lead mb-4">Jl.raya btn korpri, Sirnagalih, Kec. Cilaku, Kabupaten Cianjur, Jawa Barat 43285</p>

            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3961.20427739231!2d107.12728307499594!3d-6.866107193132491!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68518a31c05399%3A0x1c53c19627fdf16b!2sSMK%20Bela%20Nusantara%20Cianjur!5e0!3m2!1sid!2sid!4v1764577704966!5m2!1sid!2sid"
                class="mt-3 w-100 rounded shadow-lg" height="400" style="border:0;" allowfullscreen=""
                loading="lazy"></iframe>
        </div>
    </section>

    <footer class="bg-dark text-white py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-6 text-md-start text-center mb-3 mb-md-0">
                    <p class="mb-0 small">© 2025 PKL SMK BNA. Hak Cipta Dilindungi.</p>
                </div>
                <div class="col-md-6 text-md-end text-center">
                    <div class="d-flex justify-content-center justify-content-md-end gap-4 small">
                        <span>Telp. (0263) 272209</span>
                        <span>Fax. (0263) 264844</span>
                        <span>E-Mail: hallo@smkbna.sch.id</span>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    {{-- @if (Route::has('login'))
        <div class="h-14.5 hidden lg:block"></div>
    @endif --}}
</body>

</html>
