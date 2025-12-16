@extends('dashboard')

@section('content')
<div class="container mt-4">

    <h3 class="mb-3">Edit Jadwal PKL</h3>

    <form action="{{ route('jadwal.update', $jadwal->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Angkatan</label>
            <input type="text" name="angkatan" class="form-control"
                   value="{{ $jadwal->angkatan }}" required>
        </div>

        <div class="mb-3">
            <label>Jurusan</label>
            <select name="jurusan_id" class="form-control" required>
                @foreach($jurusan as $j)
                    <option value="{{ $j->id }}"
                        {{ $jadwal->jurusan_id == $j->id ? 'selected' : '' }}>
                        {{ $j->nama_jurusan }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Pembekalan</label>
            <input type="date" name="pembekalan" class="form-control"
                   value="{{ $jadwal->pembekalan }}" required>
        </div>

        <div class="mb-3">
            <label>Pengantaran</label>
            <input type="date" name="pengantaran" class="form-control"
                   value="{{ $jadwal->pengantaran }}" required>
        </div>

        <div class="mb-3">
            <label>Monitoring</label>
            <input type="date" name="monitoring" class="form-control"
                   value="{{ $jadwal->monitoring }}" required>
        </div>

        <div class="mb-3">
            <label>Penjemputan</label>
            <input type="date" name="penjemputan" class="form-control"
                   value="{{ $jadwal->penjemputan }}" required>
        </div>

        <button class="btn btn-primary">Update</button>
        <a href="{{ route('jadwal.index') }}" class="btn btn-secondary">Kembali</a>
    </form>

</div>
@endsection
