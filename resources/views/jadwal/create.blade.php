@extends('dashboard')

@section('content')
    <div class="container-fluid px-4">

        {{-- PAGE HEADER --}}
        <div class="mb-4">
            <div class="d-flex align-items-start gap-3">
                <div class="bg-primary rounded-circle p-2 text-white">
                    <i class="bi bi-calendar-plus"></i>
                </div>
                <div>
                    <h5 class="fw-medium mb-1">
                        Tambah Jadwal PKL
                    </h5>
                    <p class="text-muted small mb-0">
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

                    {{-- SECTION : INFORMASI UMUM --}}
                    <div class="mb-4">
                        <div class="d-flex align-items-center mb-3">
                            <span class="badge bg-light text-primary fw-medium me-2">1</span>
                            <h6 class="fw-medium text-dark mb-0">
                                Informasi Umum
                            </h6>
                        </div>

                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label small text-muted">
                                    Angkatan
                                </label>
                                <select name="angkatan" class="form-select rounded-3" required>
                                    <option value="">Pilih Tahun Angkatan</option>
                                    @for ($year = date('Y') + 2; $year >= 2000; $year--)
                                        <option value="{{ $year }}">{{ $year }}</option>
                                    @endfor
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small text-muted">
                                    Jurusan
                                </label>
                                <select name="jurusan_id" class="form-select rounded-3" required>
                                    <option value="">Pilih Jurusan</option>
                                    @foreach ($jurusan as $j)
                                        <option value="{{ $j->id }}">{{ $j->nama_jurusan }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    {{-- DIVIDER --}}
                    <div class="my-4 border-top"></div>

                    {{-- SECTION : WAKTU --}}
                    <div class="mb-4">
                        <div class="d-flex align-items-center mb-3">
                            <span class="badge bg-light text-primary fw-medium me-2">2</span>
                            <h6 class="fw-medium text-dark mb-0">
                                Waktu Pelaksanaan
                            </h6>
                        </div>

                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label small text-muted">
                                    Tanggal Pembekalan
                                </label>
                                <input type="date" name="pembekalan" class="form-control rounded-3" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small text-muted">
                                    Tanggal Pengantaran
                                </label>
                                <input type="date" name="pengantaran" class="form-control rounded-3" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small text-muted">
                                    Tanggal Monitoring
                                </label>
                                <input type="date" name="monitoring" class="form-control rounded-3" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small text-muted">
                                    Tanggal Penjemputan
                                </label>
                                <input type="date" name="penjemputan" class="form-control rounded-3" required>
                            </div>
                        </div>
                    </div>

                    {{-- ACTION BUTTON --}}
                    <div class="d-flex justify-content-end gap-3 pt-3 border-top">
                        <a href="{{ route('jadwal.index') }}" class="btn btn-light px-4 rounded-3">
                            Kembali
                        </a>

                        <button type="submit" class="btn btn-primary px-4 rounded-3">
                            Simpan Jadwal
                        </button>
                    </div>

                </form>

            </div>
        </div>

    </div>
@endsection
