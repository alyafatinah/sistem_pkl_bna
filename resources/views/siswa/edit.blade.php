@extends('dashboard')

@section('content')
    <div class="container-fluid px-4">

        <h1 class="mt-4 mb-4 text-warning fw-bold">
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

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>NIS</label>
                            <input type="text" class="form-control" value="{{ $siswa->nis }}" readonly>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Nama Siswa</label>
                            <input type="text" name="nama" class="form-control" value="{{ $siswa->nama }}" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Kelas</label>
                            <input type="text" name="kelas" class="form-control" value="{{ $siswa->kelas }}" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" value="{{ $siswa->user->email }}"
                                required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>No Telp</label>
                            <input type="text" name="telp" class="form-control" value="{{ $siswa->telp }}" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Jurusan</label>
                            <select name="jurusan_id" class="form-control" required>
                                @foreach ($jurusan as $j)
                                    <option value="{{ $j->id }}"
                                        {{ $siswa->jurusan_id == $j->id ? 'selected' : '' }}>
                                        {{ $j->nama_jurusan }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label>Alamat Siswa</label>
                            <textarea name="alamat" class="form-control" rows="2" required>{{ $siswa->alamat }}</textarea>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label>Tempat PKL (Mitra)</label>
                            <select name="mitra_id" class="form-control" required>
                                @foreach ($mitra as $m)
                                    <option value="{{ $m->id }}"
                                        {{ $siswa->mitra_id == $m->id ? 'selected' : '' }}>
                                        {{ $m->nama_mitra }} - {{ $m->bidang }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mt-3">
                        <button class="btn btn-warning">
                            <i class="bi bi-save"></i> Update
                        </button>
                        <a href="{{ route('siswa.index') }}" class="btn btn-secondary">
                            Kembali
                        </a>
                    </div>

                </form>
            </div>
        </div>

    </div>
@endsection
