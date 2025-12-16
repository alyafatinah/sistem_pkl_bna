<div class="container-fluid px-4">

    <h1 class="mt-4 mb-4 text-primary fw-bold">
        <i class="bi bi-speedometer2"></i> Dashboard
    </h1>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row g-4">

        {{-- SISWA --}}
        <div class="col-xl-3 col-md-6">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="bg-primary text-white rounded-3 p-3 me-3">
                        <i class="bi bi-people-fill fs-3"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Total</div>
                        <div class="fs-4 fw-bold">{{ $totalSiswa ?? 0 }}</div>
                        <div class="fw-semibold">Data Siswa</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- GURU PEMBIMBING --}}
        <div class="col-xl-3 col-md-6">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="bg-success text-white rounded-3 p-3 me-3">
                        <i class="bi bi-person-badge-fill fs-3"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Total</div>
                        <div class="fs-4 fw-bold">{{ $totalGuruPembimbing ?? 0 }}</div>
                        <div class="fw-semibold">Guru Pembimbing</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- MITRA DUDI --}}
        <div class="col-xl-3 col-md-6">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="bg-warning text-dark rounded-3 p-3 me-3">
                        <i class="bi bi-buildings-fill fs-3"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Total</div>
                        <div class="fs-4 fw-bold">{{ $totalMitra ?? 0 }}</div>
                        <div class="fw-semibold">Mitra DUDI</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- KEPALA PRODI --}}
        <div class="col-xl-3 col-md-6">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="bg-info text-white rounded-3 p-3 me-3">
                        <i class="bi bi-person-lines-fill fs-3"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Total</div>
                        <div class="fs-4 fw-bold">{{ $totalKaprodi ?? 0 }}</div>
                        <div class="fw-semibold">Kepala Prodi</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- USER --}}
        <div class="col-xl-3 col-md-6">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="bg-dark text-white rounded-3 p-3 me-3">
                        <i class="bi bi-people fs-3"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Total</div>
                        <div class="fs-4 fw-bold">{{ $totalUser ?? 0 }}</div>
                        <div class="fw-semibold">Total User</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Jurusan --}}
        <div class="col-xl-3 col-md-6">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="bg-dark text-white rounded-3 p-3 me-3">
                        <i class="bi bi-diagram-3-fill fs-3"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Total</div>
                        <div class="fs-4 fw-bold">{{ $totalJurusan ?? 0 }}</div>
                        <div class="fw-semibold">Total Jurusan</div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>
