@extends('dashboard')

@section('content')
<div class="container-fluid px-4">

    <h1 class="mt-4 mb-4 text-warning fw-bold">
        <i class="bi bi-pencil-square"></i> Edit Nilai PKL
    </h1>

    <div class="card shadow-sm">
        <div class="card-header bg-warning text-dark">
            <i class="bi bi-award"></i> Form Edit Nilai
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

            <form action="{{ route('nilai.update', $nilai->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label fw-semibold">NIS</label>
                    <input type="text" class="form-control"
                           value="{{ $nilai->siswa->nis ?? '-' }}" readonly>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Nama Siswa</label>
                    <input type="text" class="form-control"
                           value="{{ $nilai->siswa->nama ?? '-' }}" readonly>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Guru Pembimbing</label>
                    <input type="text" class="form-control"
                           value="{{ $nilai->siswa->guruPembimbing->nama_guru ?? '-' }}" readonly>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Jurusan</label>
                    <input type="text" class="form-control"
                           value="{{ $nilai->siswa->jurusan->nama_jurusan ?? '-' }}" readonly>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Nilai PKL</label>
                    <input type="number" name="nilai" class="form-control"
                           value="{{ old('nilai', $nilai->nilai) }}"
                           min="0" max="100" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Komentar Guru</label>
                    <textarea name="komentar" class="form-control" rows="3" required>
{{ old('komentar', $nilai->komentar) }}</textarea>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('nilai.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                    <button type="submit" class="btn btn-warning fw-bold">
                        <i class="bi bi-save"></i> Update Nilai
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>
@endsection
