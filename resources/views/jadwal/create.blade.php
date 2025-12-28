@extends('dashboard')

@section('content')
<div class="container-fluid px-4">

    {{-- PAGE HEADER --}}
    <div class="mb-4">
        <div class="d-flex align-items-center gap-3">
            <div class="bg-primary rounded-circle p-3 text-white">
                <i class="bi bi-calendar-plus fs-5"></i>
            </div>
            <div>
                <h4 class="fw-bold text-primary mb-1">
                    Tambah Data Jadwal PKL
                </h4>
                <p class="text-muted mb-0">
                    Lengkapi data penjadwalan kegiatan Praktik Kerja Lapangan
                </p>
            </div>
        </div>
    </div>

    {{-- FORM CARD --}}
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">

            <form action="{{ route('jadwal.store') }}" method="POST">
                @csrf

                {{-- INFORMASI UMUM --}}
                <div class="mb-4">
                    <h6 class="fw-semibold text-secondary mb-3">
                        Informasi Umum
                    </h6>

                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label small text-muted">Tahun Ajaran</label>
                            <input type="text"
                                   name="angkatan"
                                   class="form-control rounded-3"
                                   placeholder="Contoh: 2024/2025"
                                   pattern="\d{4}/\d{4}"
                                   required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small text-muted">Periode</label>
                            <select name="periode" class="form-select rounded-3" required>
                                <option value="">-- Pilih Periode --</option>
                                <option value="Ganjil">Ganjil</option>
                                <option value="Genap">Genap</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small text-muted">Jurusan</label>
                            <select name="jurusan_id" class="form-select rounded-3" required>
                                <option value="">-- Pilih Jurusan --</option>
                                @foreach ($jurusan as $j)
                                    <option value="{{ $j->id }}">{{ $j->nama_jurusan }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <hr class="my-4">

                {{-- WAKTU PELAKSANAAN --}}
                <div class="mb-4">
                    <h6 class="fw-semibold text-secondary mb-3">
                        Waktu Pelaksanaan
                    </h6>

                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label small text-muted">Tanggal Pembekalan</label>
                            <input type="date" name="pembekalan"
                                   class="form-control rounded-3" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small text-muted">Tanggal Pengantaran</label>
                            <input type="date" name="pengantaran"
                                   class="form-control rounded-3" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small text-muted">Tanggal Monitoring</label>
                            <input type="date" name="monitoring"
                                   class="form-control rounded-3" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small text-muted">Tanggal Penjemputan</label>
                            <input type="date" name="penjemputan"
                                   class="form-control rounded-3" required>
                        </div>
                    </div>
                </div>

                {{-- ACTION BUTTON --}}
                <div class="d-flex justify-content-end gap-3 pt-4 border-top">
                    <a href="{{ route('jadwal.index') }}"
                       class="btn btn-light px-4 rounded-3">
                        Kembali
                    </a>

                    <button type="submit"
                            class="btn btn-primary px-4 rounded-3">
                        Simpan Jadwal
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>
@endsection
