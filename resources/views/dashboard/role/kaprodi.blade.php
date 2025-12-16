<h1 class="mt-4 mb-4 text-primary fw-bold">
    <i class="bi bi-speedometer2"></i> Dashboard Kaprodi
</h1>

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
                    <div class="fs-4 fw-bold">{{ $totalSiswa }}</div>
                    <div class="fw-semibold">Siswa Jurusan</div>
                </div>
            </div>
        </div>
    </div>

    {{-- GURU --}}
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

    {{-- JURUSAN --}}
    <div class="col-xl-3 col-md-6">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body d-flex align-items-center">
                <div class="bg-secondary text-white rounded-3 p-3 me-3">
                    <i class="bi bi-diagram-3-fill fs-3"></i>
                </div>
                <div>
                    <div class="fs-5 fw-bold">{{ $namaJurusan ?? '-' }}</div>
                    <div class="fw-semibold">Jurusan Anda</div>
                </div>
            </div>
        </div>
    </div>

</div>
