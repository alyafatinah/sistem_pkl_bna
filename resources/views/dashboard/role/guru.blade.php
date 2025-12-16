<div class="container-fluid px-4">

    <h1 class="mt-4 mb-4 text-primary fw-bold">
        <i class="bi bi-speedometer2"></i> Dashboard Guru
    </h1>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row g-4">

         {{-- JURUSAN --}}
        <div class="col-xl-3 col-md-6">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="bg-secondary text-white rounded-3 p-3 me-3">
                        <i class="bi bi-diagram-3-fill fs-3"></i>
                    </div>
                    <div>
                        <div class="text-muted small"></div>
                        <div class="fs-4 fw-bold">{{ $namaJurusan }}</div>
                        <div class="fw-semibold">Jurusan Anda</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- SISWA JURUSAN --}}
        <div class="col-xl-3 col-md-6">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="bg-primary text-white rounded-3 p-3 me-3">
                        <i class="bi bi-people-fill fs-3"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Total</div>
                        <div class="fs-4 fw-bold">{{ $totalSiswa }}</div>
                        <div class="fw-semibold">Siswa Jurusan</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- GURU JURUSAN --}}
        <div class="col-xl-3 col-md-6">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="bg-success text-white rounded-3 p-3 me-3">
                        <i class="bi bi-person-badge-fill fs-3"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Total</div>
                        <div class="fs-4 fw-bold">{{ $totalGuruPembimbing }}</div>
                        <div class="fw-semibold">Guru Pembimbing</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- MITRA PKL --}}
        <div class="col-xl-3 col-md-6">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="bg-warning text-dark rounded-3 p-3 me-3">
                        <i class="bi bi-buildings-fill fs-3"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Total</div>
                        <div class="fs-4 fw-bold">{{ $totalMitra }}</div>
                        <div class="fw-semibold">Mitra PKL</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- JURNAL --}}
        <div class="col-xl-3 col-md-6">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="bg-dark text-white rounded-3 p-3 me-3">
                        <i class="bi bi-journal-text fs-3"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Total</div>
                        <div class="fs-4 fw-bold">{{ $totalJurnal }}</div>
                        <div class="fw-semibold">Jurnal Siswa</div>
                    </div>
                </div>
            </div>
        </div>

       
    </div>
</div>
