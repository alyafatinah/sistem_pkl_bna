@extends('dashboard')

@section('content')
    <div class="container-fluid px-4">

        <h1 class="mt-4 mb-4 text-primary fw-bold">
            <i class="bi bi-pencil-square"></i> Edit Data Siswa
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

                <form action="{{ route('siswa.update', $siswa->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row g-4">

                        {{-- NIS --}}
                        <div class="col-md-6">
                            <label class="form-label small text-muted">NIS</label>
                            <input type="text" class="form-control" value="{{ $siswa->nis }}" readonly>
                        </div>

                        {{-- Nama --}}
                        <div class="col-md-6">
                            <label class="form-label small text-muted">Nama Siswa</label>
                            <input type="text" name="nama" class="form-control"
                                value="{{ old('nama', $siswa->nama) }}" required>
                        </div>

                        {{-- Kelas --}}
                        <div class="col-md-6">
                            <label class="form-label small text-muted">Kelas</label>
                            <input type="text" name="kelas" class="form-control"
                                value="{{ old('kelas', $siswa->kelas) }}" required>
                        </div>

                        {{-- Email --}}
                        <div class="col-md-6">
                            <label class="form-label small text-muted">Email (Akun Login)</label>
                            <input type="email" name="email" class="form-control"
                                value="{{ old('email', $siswa->user->email ?? '') }}" required>
                        </div>

                        {{-- Telp --}}
                        <div class="col-md-6">
                            <label class="form-label small text-muted">No Telp</label>
                            <input type="text" name="telp" class="form-control"
                                value="{{ old('telp', $siswa->telp) }}" required>
                        </div>

                        {{-- Jurusan --}}
                        <div class="col-md-6">
                            <label class="form-label small text-muted">Jurusan</label>
                            <select name="jurusan_id" class="form-select" required>
                                <option value="">-- Pilih Jurusan --</option>
                                @foreach ($jurusan as $j)
                                    <option value="{{ $j->id }}"
                                        {{ old('jurusan_id', $siswa->jurusan_id) == $j->id ? 'selected' : '' }}>
                                        {{ $j->nama_jurusan }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Guru Pembimbing --}}
                        <div class="col-md-6">
                            <label class="form-label small text-muted">Guru Pembimbing</label>
                            <select name="gurupembimbing_id" class="form-select" required>
                                <option value="">-- Pilih Guru Pembimbing --</option>
                                @foreach ($gurupembimbing as $g)
                                    <option value="{{ $g->id }}"
                                        {{ old('gurupembimbing_id', $siswa->gurupembimbing_id) == $g->id ? 'selected' : '' }}>
                                        {{ $g->nama_guru }} ({{ $g->jurusan->nama_jurusan ?? '-' }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Alamat --}}
                        <div class="col-md-12">
                            <label class="form-label small text-muted">Alamat Siswa</label>
                            <textarea name="alamat" class="form-control" rows="2" required>{{ old('alamat', $siswa->alamat) }}</textarea>
                        </div>

                        {{-- Mitra PKL --}}
                        <div class="col-md-12">
                            <label class="form-label small text-muted">Tempat PKL (Mitra DUDI)</label>
                            <select name="mitra_id" class="form-select" required>
                                <option value="">-- Pilih Mitra PKL --</option>
                                @foreach ($mitra as $m)
                                    <option value="{{ $m->id }}"
                                        {{ old('mitra_id', $siswa->mitra_id) == $m->id ? 'selected' : '' }}>
                                        {{ $m->nama_mitra }} – {{ $m->bidang }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                    </div>

                    {{-- ACTION --}}
                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="{{ route('siswa.index') }}" class="btn btn-secondary">
                            Kembali
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Update
                        </button>
                    </div>

                </form>
            </div>
        </div>

    </div>
@endsection
