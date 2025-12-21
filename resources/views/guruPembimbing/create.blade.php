@extends('dashboard')

@section('content')
    <div class="container-fluid px-4">

        {{-- JUDUL HALAMAN --}}
        <h1 class="mt-4 mb-4 text-primary fw-bold">
            <i class="bi bi-person-badge-fill"></i> Tambah Data Guru Pembimbing
        </h1>

        {{-- CARD FORM --}}
        <div class="card shadow-sm">


            {{-- BODY --}}
            <div class="card-body">

                {{-- ERROR VALIDASI --}}
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
                <form action="{{ route('guruPembimbing.store') }}" method="POST">
                    @csrf

                    <div class="row g-3">
                        {{-- NIP --}}
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">NIP</label>
                            <input type="text" name="nip" class="form-control" value="{{ old('nip') }}" required
                                maxlength="18" minlength="18" pattern="[0-9]{18}" inputmode="numeric"
                                placeholder="Masukkan 18 digit NIP" title="NIP harus terdiri dari tepat 18 angka">
                        </div>


                        {{-- NAMA GURU --}}
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Nama Guru Pembimbing</label>
                            <input type="text" name="nama_guru" placeholder= "Masukan Nama Lengkap" class="form-control" value="{{ old('nama_guru') }}"
                                required>
                        </div>

                        {{-- Bidang Keahlian --}}
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Bidang Keahlian</label>
                            <input type="text" name="bidang" placeholder="contoh : Multimedia" class="form-control" value="{{ old('bidang') }}" required>
                        </div>

                        {{-- EMAIL LOGIN --}}
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required
                                pattern="^[a-zA-Z0-9._%+-]+@gmail\.com$" placeholder="contoh@gmail.com"
                                title="Email harus menggunakan domain @gmail.com">
                        </div>


                        {{-- JURUSAN --}}
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Jurusan</label>
                            <select name="jurusan_id" class="form-select" required>
                                <option value="">-- Pilih Jurusan --</option>
                                @foreach ($jurusan as $j)
                                    <option value="{{ $j->id }}" {{ old('jurusan_id') == $j->id ? 'selected' : '' }}>
                                        {{ $j->nama_jurusan }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- TELEPON --}}
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">No. Telepon</label>
                            <input type="text" name="telp" placeholder="08xxxxxxxxxx" class="form-control" value="{{ old('telp') }}" required>
                        </div>

                    </div>

                    {{-- AKSI --}}
                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="{{ route('guruPembimbing.index') }}" class="btn btn-secondary">
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
