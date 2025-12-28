@extends('dashboard')

@section('content')
<div class="container-fluid px-4">

    <h1 class="mt-4 mb-4 text-primary fw-bold">
        <i class="bi bi-person-lines-fill"></i> Profil Humas
    </h1>

    <div class="card shadow-sm">
        <div class="card-body px-4 py-4">

            {{-- AKUN USER --}}
            <h6 class="fw-bold text-secondary mb-3">Akun Pengguna</h6>

            <div class="row mb-2">
                <div class="col-md-4 fw-semibold">Username</div>
                <div class="col-md-1 text-center">:</div>
                <div class="col-md-7">{{ $humas->user->username }}</div>
            </div>

            <div class="row mb-2">
                <div class="col-md-4 fw-semibold">Email</div>
                <div class="col-md-1 text-center">:</div>
                <div class="col-md-7">{{ $humas->user->email }}</div>
            </div>

            <hr>

            {{-- DATA HUMAS --}}
            <h6 class="fw-bold text-secondary mb-3">Data Humas</h6>

            <div class="row mb-2">
                <div class="col-md-4 fw-semibold">NIP</div>
                <div class="col-md-1 text-center">:</div>
                <div class="col-md-7">{{ $humas->nip ?? '-' }}</div>
            </div>

            <div class="row mb-2">
                <div class="col-md-4 fw-semibold">Nama Humas</div>
                <div class="col-md-1 text-center">:</div>
                <div class="col-md-7">{{ $humas->nama_humas }}</div>
            </div>

            <div class="row mb-2">
                <div class="col-md-4 fw-semibold">Alamat</div>
                <div class="col-md-1 text-center">:</div>
                <div class="col-md-7">{{ $humas->alamat }}</div>
            </div>

            <div class="row mb-4">
                <div class="col-md-4 fw-semibold">Telepon</div>
                <div class="col-md-1 text-center">:</div>
                <div class="col-md-7">{{ $humas->telp }}</div>
            </div>

            <div class="text-end">
                <a href="{{ route('humas.edit', $humas->id) }}" class="btn btn-warning">
                    <i class="bi bi-pencil-square"></i> Edit Profil
                </a>
            </div>

        </div>
    </div>

</div>
@endsection
