@extends('dashboard')

@section('content')
    <div class="container mt-4">

        <h3 class="mb-3">Edit Jadwal PKL</h3>

        <form action="{{ route('jadwal.update', $jadwal->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row g-4">
                <div class="col-md-6">
                    <label class="form-label small text-muted">Tahun Ajaran</label>
                    <input type="text" name="angkatan" class="form-control rounded-3" placeholder="Contoh: 2024/2025"
                        pattern="\d{4}/\d{4}" value="{{ old('angkatan', $jadwal->angkatan) }}" required>
                </div>
            </div>


            <div class="mb-3">
                <label class="form-label small text-muted">Periode</label>
                <select name="periode" class="form-control" required>
                    <option value="">-- Pilih Periode --</option>

                    <option value="Ganjil" {{ old('periode', $jadwal->periode) == 'Ganjil' ? 'selected' : '' }}>
                        Ganjil
                    </option>

                    <option value="Genap" {{ old('periode', $jadwal->periode) == 'Genap' ? 'selected' : '' }}>
                        Genap
                    </option>
                </select>
            </div>


            <div class="mb-3">
                <label>Jurusan</label>
                <select name="jurusan_id" class="form-control" required>
                    @foreach ($jurusan as $j)
                        <option value="{{ $j->id }}" {{ $jadwal->jurusan_id == $j->id ? 'selected' : '' }}>
                            {{ $j->nama_jurusan }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label>Pembekalan</label>
                <input type="date" name="pembekalan" class="form-control" value="{{ $jadwal->pembekalan }}" required>
            </div>

            <div class="mb-3">
                <label>Pengantaran</label>
                <input type="date" name="pengantaran" class="form-control" value="{{ $jadwal->pengantaran }}" required>
            </div>

            <div class="mb-3">
                <label>Monitoring</label>
                <input type="date" name="monitoring" class="form-control" value="{{ $jadwal->monitoring }}" required>
            </div>

            <div class="mb-3">
                <label>Penjemputan</label>
                <input type="date" name="penjemputan" class="form-control" value="{{ $jadwal->penjemputan }}" required>
            </div>

            <button class="btn btn-primary">Update</button>
            <a href="{{ route('jadwal.index') }}" class="btn btn-secondary">Kembali</a>
        </form>

    </div>
@endsection
