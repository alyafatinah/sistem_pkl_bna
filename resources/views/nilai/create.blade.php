@extends('dashboard')

@section('content')
<div class="container-fluid px-4">

    <h1 class="mt-4 mb-4 text-primary fw-bold">
        <i class="bi bi-plus-circle-fill"></i> Tambah Nilai PKL
    </h1>

    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <i class="bi bi-award"></i> Form Input Nilai
        </div>

        <div class="card-body">

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('nilai.store') }}" method="POST">
                @csrf

                {{-- NIS --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">NIS</label>
                    <input type="text"
                           name="nis"
                           id="nis"
                           class="form-control"
                           placeholder="Masukkan NIS"
                           value="{{ old('nis') }}"
                           required>
                    <small class="text-muted">Ketik NIS lalu tekan Enter atau pindah fokus.</small>
                </div>

                {{-- Nama --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Nama Siswa</label>
                    <input type="text" id="nama_siswa" class="form-control" readonly>
                </div>

                {{-- Guru Pembimbing --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Guru Pembimbing</label>
                    <input type="text" id="nama_guru" class="form-control" readonly>
                </div>

                {{-- Jurusan --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Jurusan</label>
                    <input type="text" id="nama_jurusan" class="form-control" readonly>
                </div>

                {{-- siswa_id --}}
                <input type="hidden" name="siswa_id" id="siswa_id" value="{{ old('siswa_id') }}">

                {{-- Nilai --}}
                <div class="mb-3">
                    <label class="form-label fw-bold">Nilai PKL</label>
                    <input type="number"
                           name="nilai"
                           class="form-control"
                           value="{{ old('nilai') }}"
                           min="0"
                           max="100"
                           placeholder="0 - 100"
                           required>
                </div>

                {{-- Komentar --}}
                <div class="mb-3">
                    <label class="form-label fw-bold">Komentar Guru</label>
                    <textarea name="komentar"
                              class="form-control"
                              rows="3"
                              placeholder="Catatan atau evaluasi siswa...">{{ old('komentar') }}</textarea>
                </div>

                {{-- tombol --}}
                <div class="d-flex justify-content-between">
                    <a href="{{ route('nilai.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>

                    <button type="submit" id="btnSubmit" class="btn btn-primary fw-bold" disabled>
                        <i class="bi bi-save"></i> Simpan Nilai
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    const nisInput   = document.getElementById('nis');
    const btnSubmit  = document.getElementById('btnSubmit');

    const resetField = () => {
        document.getElementById('nama_siswa').value = '';
        document.getElementById('nama_jurusan').value = '';
        document.getElementById('nama_guru').value = '';
        document.getElementById('siswa_id').value = '';
        btnSubmit.disabled = true;
    };

    const fetchSiswa = (nis) => {
        fetch(`/siswa-by-nis-nilai/${encodeURIComponent(nis)}`)
            .then(res => {
                if (!res.ok) throw new Error();
                return res.json();
            })
            .then(data => {
                document.getElementById('nama_siswa').value = data.nama ?? '';
                document.getElementById('nama_jurusan').value = data.jurusan ?? '';
                document.getElementById('nama_guru').value = data.gurupembimbing ?? '';
                document.getElementById('siswa_id').value = data.id ?? '';
                btnSubmit.disabled = false;
            })
            .catch(() => {
                alert('NIS tidak ditemukan');
                resetField();
            });
    };

    nisInput.addEventListener('change', function () {
        const nis = this.value.trim();
        if (!nis) return resetField();
        fetchSiswa(nis);
    });

    nisInput.addEventListener('blur', function () {
        const nis = this.value.trim();
        if (!nis) return resetField();
        fetchSiswa(nis);
    });

});
</script>
@endpush
