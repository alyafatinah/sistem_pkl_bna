@extends('dashboard')

@section('content')
    <div class="container-fluid px-4">

        <h1 class="mt-4 mb-4 text-warning fw-bold">
            <i class="bi bi-pencil-square"></i> Edit Jurnal PKL
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

                <form action="{{ route('jurnal.update', $jurnal->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label>Tanggal</label>
                        <input type="date" name="tanggal" class="form-control" value="{{ $jurnal->tanggal }}" required>
                    </div>

                    <div class="mb-3">
                        <label>Deskripsi Kegiatan</label>
                        <textarea name="deskripsi" class="form-control" rows="4" required>{{ $jurnal->deskripsi }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label>Dokumentasi (Foto)</label>
                        <input type="file" name="dokumentasi" class="form-control">

                        @if ($jurnal->dokumentasi)
                            <div class="mt-2">
                                <small class="text-muted">Dokumentasi saat ini:</small><br>
                                <a href="{{ asset('storage/' . $jurnal->dokumentasi) }}" target="_blank">
                                    <img src="{{ asset('storage/' . $jurnal->dokumentasi) }}" width="150"
                                        class="img-thumbnail">
                                </a>
                            </div>
                        @endif
                    </div>

                    <button class="btn btn-warning">
                        <i class="bi bi-save"></i> Update
                    </button>

                    <a href="{{ route('jurnal.index') }}" class="btn btn-secondary">
                        Kembali
                    </a>
                </form>

            </div>
        </div>

    </div>
@endsection
