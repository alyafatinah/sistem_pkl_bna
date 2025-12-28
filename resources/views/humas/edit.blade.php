@extends('dashboard')

@section('content')
    <div class="container-fluid px-4">

        <h1 class="mt-4 mb-4 text-primary fw-bold">
            <i class="bi bi-person-gear"></i> Edit Profil Humas
        </h1>

        <div class="card shadow-sm">
            <div class="card-header bg-warning text-dark">
                <i class="bi bi-pencil-square"></i> Form Edit Profil
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

                <form action="{{ route('humas.update', $humas->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    {{-- DATA USER --}}
                    <h6 class="fw-bold text-secondary mb-3">Akun Pengguna</h6>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Username</label>
                        <input type="text" name="username" class="form-control"
                            value="{{ old('username', $humas->user->username) }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Email</label>
                        <input type="email" name="email" class="form-control"
                            value="{{ old('email', $humas->user->email) }}" required>
                    </div>

                    <hr>

                    {{-- DATA HUMAS --}}
                    <h6 class="fw-bold text-secondary mb-3">Profil Humas</h6>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">NIP</label>
                        <input type="text" name="nip" class="form-control" value="{{ old('nip', $humas->nip) }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nama Humas</label>
                        <input type="text" name="nama_humas" class="form-control"
                            value="{{ old('nama_humas', $humas->nama_humas) }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Alamat</label>
                        <textarea name="alamat" class="form-control" rows="3" required>{{ old('alamat', $humas->alamat) }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Telepon</label>
                        <input type="text" name="telp" class="form-control" value="{{ old('telp', $humas->telp) }}"
                            required>
                    </div>

                    <div class="text-end">
                        @if (auth()->user()->role_id == 2)
                            <a href="{{ route('humas.index-humas') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Kembali
                            </a>
                        @endif
                        @if (auth()->user()->role_id == 5)
                            <a href="{{ route('humas.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Kembali
                            </a>
                        @endif
                        <button type="submit" class="btn btn-warning">
                            <i class="bi bi-save"></i> Simpan Perubahan
                        </button>
                    </div>

                </form>
            </div>
        </div>

    </div>
@endsection
