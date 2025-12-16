@extends('dashboard')

@section('content')
<div class="container-fluid px-4">

    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white d-flex align-items-center">
            <i class="bi bi-person-badge-fill me-2"></i>
            <span>Jurnal Milik : {{ $siswa->nama_siswa }}</span>
        </div>

        <div class="card-body">

            {{-- tampilkan error validasi --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('jurnal.store_per_siswa') }}"
                  method="POST"
                  enctype="multipart/form-data">
                @csrf

                {{-- Tanggal --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Tanggal</label>
                    <input type="date"
                           name="tanggal"
                           class="form-control text-secondary"
                           value="{{ old('tanggal') }}"
                           required>
                </div>


                {{-- Deskripsi --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Deskripsi Kegiatan</label>
                    <textarea name="deskripsi"
                              class="form-control"
                              rows="4"
                              placeholder="Tuliskan deskripsi kegiatan hari ini...">{{ old('deskripsi') }}</textarea>
                </div>

                {{-- Dokumentasi --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Dokumentasi (Foto)</label>
                    <input type="file"
                           name="dokumentasi"
                           class="form-control text-secondary">
                    <small class="text-muted">
                        maksimal gambar 5MB (jpg, jpeg, png)
                    </small>
                </div>

                {{-- Tombol --}}
                <div class="d-flex justify-content-end">
                    <a href="{{ route('jurnal.per_siswa', $siswa->id) }}"
                       class="btn btn-secondary me-2">
                        Kembali
                    </a>
                    <button type="submit" class="btn btn-primary">
                        Simpan
                    </button>
                </div>

            </form>
        </div>
    </div>

</div>
@endsection
