@extends('dashboard')

@section('content')
<div class="container-fluid px-4">

    <h1 class="mt-4 mb-4 text-primary fw-bold">
        <i class="bi bi-journal-plus"></i> Tambah Jurnal PKL
    </h1>

    <div class="card shadow-sm">
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

            <form action="{{ route('jurnal.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label class="form-label fw-semibold">NIS</label>
                    <input type="text" id="nis" class="form-control" placeholder="Masukkan NIS" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Nama Siswa</label>
                    <input type="text" id="nama_siswa" class="form-control" readonly>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Jurusan</label>
                    <input type="text" id="nama_jurusan" class="form-control" readonly>
                </div>

                {{-- disimpan ke tabel jurnal --}}
                <input type="hidden" name="siswa_id" id="siswa_id">

                <div class="mb-3">
                    <label>Tanggal</label>
                    <input type="date" name="tanggal" class="text-secondary form-control" required>
                </div>

                <div class="mb-3">
                    <label>Deskripsi Kegiatan</label>
                    <textarea name="deskripsi" class=" form-control" rows="4" required></textarea>
                </div>

                <div class="mb-3">
                    <label>Dokumentasi (Foto)</label>
                    <input type="file" name="dokumentasi" class="text-secondary form-control">
                    <p class=" text-secondary">maksimal gambar 500mb</p>
                </div>

                <button class="btn btn-primary">
                    <i class="bi bi-save"></i> Simpan
                </button>
                <a href="{{ route('jurnal.index') }}" class="btn btn-secondary">Kembali</a>
            </form>

        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    const nisInput = document.getElementById('nis');

    nisInput.addEventListener('change', function () {
        const nis = this.value;

        if (!nis) return;

        fetch(`/api/siswa-by-nis/${nis}`)
            .then(res => {
                if (!res.ok) throw new Error();
                return res.json();
            })
            .then(data => {
                document.getElementById('nama_siswa').value  = data.nama;
                document.getElementById('nama_jurusan').value = data.jurusan;
                document.getElementById('siswa_id').value = data.id;
            })
            .catch(() => {
                alert('NIS tidak ditemukan');

                document.getElementById('nama_siswa').value = '';
                document.getElementById('nama_jurusan').value = '';
                document.getElementById('siswa_id').value = '';
            });
    });

});
</script>
@endpush
