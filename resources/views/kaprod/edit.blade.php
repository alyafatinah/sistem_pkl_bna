@extends('dashboard')

@section('content')
    <div class="container-fluid px-4">

        <h1 class="mt-4 mb-4 text-warning fw-bold">
            <i class="bi bi-pencil-square"></i> Edit Kaprodi
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

                <form action="{{ route('kaprod.update', $kaprod->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>NIP</label>
                            <input type="text" class="form-control" value="{{ $kaprod->nip }}" readonly>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Nama Kaprodi</label>
                            <input type="text" name="nama_kaprod" class="form-control" value="{{ $kaprod->nama_kaprod }}"
                                required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" value="{{ $kaprod->user->email }}"
                                required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>No Telp</label>
                            <input type="text" name="telp" class="form-control" value="{{ $kaprod->telp }}" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Jurusan</label>
                            <select name="jurusan_id" class="form-control" required>
                                @foreach ($jurusan as $j)
                                    <option value="{{ $j->id }}"
                                        {{ $kaprod->jurusan_id == $j->id ? 'selected' : '' }}>
                                        {{ $j->nama_jurusan }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label>Alamat</label>
                            <textarea name="alamat" class="form-control" rows="2" required>{{ $kaprod->alamat }}</textarea>
                        </div>
                    </div>

                    <div class="mt-3">
                        <button class="btn btn-warning">
                            <i class="bi bi-save"></i> Update
                        </button>
                        <a href="{{ route('kaprod.index') }}" class="btn btn-secondary">
                            Kembali
                        </a>
                    </div>

                </form>
            </div>
        </div>

    </div>
@endsection
