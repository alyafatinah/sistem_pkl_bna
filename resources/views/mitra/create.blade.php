@extends('dashboard')

@section('content')
    <div class="container-fluid px-4">

        {{-- JUDUL HALAMAN --}}
        <h1 class="mt-4 mb-4 text-primary fw-bold">
            <i class="bi bi-buildings"></i> Tambah Data Mitra DUDI
        </h1>

        {{-- CARD FORM --}}
        <div class="card shadow-sm">


            {{-- BODY CARD --}}
            <div class="card-body">

                {{-- VALIDASI ERROR --}}
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- FORM --}}
                <form action="{{ route('mitra.store') }}" method="POST">
                    @csrf

                    <div class="row g-3">

                        {{-- NAMA MITRA --}}
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Nama Mitra</label>
                            <input type="text" name="nama_mitra" class="form-control"
                                placeholder="Nama perusahaan / instansi" value="{{ old('nama_mitra') }}" required>
                        </div>

                        {{-- BIDANG USAHA --}}
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Bidang Usaha</label>
                            <input type="text" name="bidang" class="form-control"
                                placeholder="Contoh: Teknologi Informasi" value="{{ old('bidang') }}" required>
                        </div>

                        {{-- ALAMAT --}}
                        <div class="col-md-12">
                            <label class="form-label fw-semibold">Alamat</label>
                            <textarea name="alamat" class="form-control" rows="3" placeholder="Alamat lengkap mitra" required>{{ old('alamat') }}</textarea>
                        </div>

                        {{-- PEMBIMBING LAPANGAN --}}
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Pembimbing Lapangan</label>
                            <input type="text" name="pl" class="form-control" placeholder="Nama pembimbing lapangan"
                                value="{{ old('pl') }}" required>
                        </div>

                        {{-- TELEPON --}}
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">No. Telepon</label>
                            <input type="text" name="telp" class="form-control" placeholder="08xxxxxxxxxx"
                                value="{{ old('telp') }}" required>
                        </div>

                    </div>

                    {{-- TOMBOL AKSI --}}
                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="{{ route('mitra.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i>
                            Kembali
                        </a>

                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i>
                            Simpan
                        </button>
                    </div>

                </form>

            </div>
        </div>

    </div>
@endsection
