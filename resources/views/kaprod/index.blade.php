@extends('dashboard')

@section('content')
<div class="container-fluid px-4">

    <h1 class="mt-4 mb-4 text-primary fw-bold">
        <i class="bi bi-person-badge-fill"></i> Data Kepala Program Studi
    </h1>

    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white d-flex justify-content-between">
            <span><i class="bi bi-list"></i> Daftar Kaprodi</span>

            @if (in_array(auth()->user()->role_id, [2, 5]))
                <a href="{{ route('kaprod.create') }}" class="btn btn-light btn-sm fw-bold">
                    <i class="bi bi-plus-circle me-1"></i> Tambah Kaprodi
                </a>
            @endif
        </div>

        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <table class="table table-bordered table-striped align-middle">
                <thead class="table-dark text-center">
                    <tr>
                        <th>No</th>
                        <th>NIP</th>
                        <th>Nama Kaprodi</th>
                        <th>Email</th>
                        <th>Telp</th>
                        <th>Jurusan</th>
                        <th>Alamat</th>
                         @if (in_array(auth()->user()->role_id, [2, 5]))
                            <th width="120">Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach ($kaprod as $k)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $k->nip }}</td>
                            <td>{{ $k->nama_kaprod }}</td>
                            <td>{{ $k->user->email ?? '-' }}</td>
                            <td>{{ $k->telp }}</td>
                            <td>{{ $k->jurusan->nama_jurusan }}</td>
                            <td>{{ $k->alamat }}</td>

                            @if (in_array(auth()->user()->role_id, [2, 5]))
                                <td class="text-center">
                                    <a href="{{ route('kaprod.edit', $k->id) }}" class="btn btn-warning btn-sm">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>

                                    <form action="{{ route('kaprod.destroy', $k->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm"
                                                onclick="return confirm('Hapus data kaprodi?')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
