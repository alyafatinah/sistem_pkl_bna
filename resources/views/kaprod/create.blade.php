@extends('dashboard')

@section('content')
    <div class="container-fluid px-4">

        <h1 class="mt-4 mb-4 text-primary fw-bold">
            <i class="bi bi-person-plus-fill"></i> Tambah Data Kepala Program Studi
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

                <form action="{{ route('kaprod.store') }}" method="POST">
                    @csrf

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>NIP</label>
                            <input type="text" name="nip" class="form-control" required minlength="18" maxlength="18"
                                pattern="[0-9]{18}" inputmode="numeric" placeholder="Masukkan 18 digit NIP"
                                title="NIP harus terdiri dari tepat 18 digit angka">
                        </div>


                        <div class="col-md-6 mb-3">
                            <label>Nama Kaprodi</label>
                            <input type="text" name="nama_kaprod" class="form-control" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" required
                                pattern="^[a-zA-Z0-9._%+-]+@gmail\.com$" placeholder="contoh@gmail.com"
                                title="Email harus menggunakan domain @gmail.com">
                        </div>


                        <div class="col-md-6 mb-3">
                            <label>No Telp</label>
                            <input type="text" name="telp" class="form-control" placeholder="08xxxxxxxxxx" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Jurusan</label>
                            <select name="jurusan_id" class="form-control" required>
                                <option value="">-- Pilih Jurusan --</option>
                                @foreach ($jurusan as $j)
                                    <option value="{{ $j->id }}">{{ $j->nama_jurusan }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label>Alamat</label>
                            <textarea name="alamat" class="form-control" rows="2" placeholder="contoh : Jl.Mardiuana No.20 Bandung" required></textarea>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="{{ route('kaprod.index') }}" class="btn btn-secondary">
                            Kembali
                        </a>
                        <button class="btn btn-primary">
                            <i class="bi bi-save"></i> Simpan
                        </button>

                    </div>

                </form>
            </div>
        </div>

    </div>
@endsection
