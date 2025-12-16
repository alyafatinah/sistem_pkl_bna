@extends('dashboard')

@section('content')
    <div class="container-fluid px-4">

        <h1 class="mt-4 mb-4 text-primary fw-bold">
            <i class="bi bi-buildings"></i> Data Mitra DUDI
        </h1>

        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <span><i class="bi bi-list"></i> Daftar Mitra DUDI</span>

                @if (in_array(auth()->user()->role_id, [2, 5]))
                    <a href="{{ route('mitra.create') }}" class="btn btn-light btn-sm fw-bold">
                        <i class="bi bi-plus-circle me-1"></i>
                        Tambah Mitra DUDI
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
                            <th>Nama Mitra</th>
                            <th>Bidang Usaha</th>
                            <th>Alamat</th>
                            <th>Pembimbing Lapangan</th>
                            <th>Telp</th>
                            @if (in_array(auth()->user()->role_id, [2, 5]))
                                <th width="120">Aksi</th>
                            @endif
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($mitra as $m)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $m->nama_mitra }}</td>
                                <td>{{ $m->bidang }}</td>
                                <td>{{ $m->alamat }}</td>
                                <td>{{ $m->pl }}</td>
                                <td>{{ $m->telp }}</td>

                                @if (in_array(auth()->user()->role_id, [2, 5]))
                                    <td class="text-center">
                                        <!-- Tombol Edit -->
                                        <a href="{{ route('mitra.edit', $m->id) }}" class="btn btn-warning btn-sm">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>

                                        <!-- Tombol Hapus -->
                                        <form action="{{ route('mitra.destroy', $m->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-sm"
                                                onclick="return confirm('Yakin hapus data?')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted">Data mitra belum tersedia</td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>
        </div>

    </div>
@endsection
