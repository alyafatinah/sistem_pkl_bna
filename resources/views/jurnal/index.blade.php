@extends('dashboard')

@section('content')
    <div class="container-fluid px-4">

        <h1 class="mt-4 mb-4 text-primary fw-bold">
            <i class="bi bi-person-badge-fill"></i> Jurnal Harian PKL Siswa
        </h1>

        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white d-flex justify-content-between">
                <span><i class="bi bi-list"></i> Daftar Jurnal Siswa</span>

                @if (in_array(auth()->user()->role_id, [4, 5]))
                    <a href="{{ route('jurnal.create') }}" class="btn btn-light btn-sm fw-bold">
                        <i class="bi bi-plus-circle me-1"></i> Tambah Jurnal Siswa
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
                            <th>NIS</th>
                            <th>Nama Siswa</th>
                            <th>Jurusan</th>
                            <th>Tanggal</th>
                            <th>Deskripsi Kegiatan</th>
                            <th>Dokumentasi</th>
                            <th>Status</th>

                            {{-- VALIDASI (GURU) --}}
                            @if (in_array(auth()->user()->role_id, [3, 5]))
                                <th>Validasi</th>
                            @endif

                            {{-- AKSI (SISWA & ADMIN) --}}
                            @if (in_array(auth()->user()->role_id, [4, 5]))
                                <th width="120">Aksi</th>
                            @endif
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($jurnal as $j)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $j->siswa->nis }}</td>
                                <td>{{ $j->siswa->nama }}</td>
                                <td>{{ $j->siswa->jurusan->nama_jurusan ?? '-' }}</td>
                                <td>{{ $j->tanggal }}</td>
                                <td>{{ $j->deskripsi }}</td>

                                <td class="text-center">
                                        @if ($j->dokumentasi)
                                            <a href="{{ asset('storage/' . $j->dokumentasi) }}" target="_blank"
                                                class="btn btn-sm btn-primary">
                                                <i class="bi bi-image"></i> Lihat
                                            </a>
                                        @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>

                                {{-- STATUS --}}
                                <td class="text-center">
                                    @if ($j->status == 'menunggu')
                                        <span class="badge text-dark fst-italic">Menunggu</span>
                                    @elseif ($j->status == 'disetujui')
                                        <span class="badge bg-success">Disetujui</span>
                                    @else
                                        <span class="badge bg-secondary">-</span>
                                    @endif
                                </td>

                                {{-- VALIDASI GURU --}}

                                @if (in_array(auth()->user()->role_id, [3, 5]))
                                    <td class="text-center">
                                        @if ($j->status == 'menunggu')
                                            <form action="{{ route('jurnal.setujui', $j->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <button class="btn btn-success btn-sm"
                                                    onclick="return confirm('Setujui jurnal ini?')">
                                                    <i class="bi bi-check-circle"></i> Setujui
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                @endif

                                {{-- AKSI SISWA / ADMIN --}}
                                @if (in_array(auth()->user()->role_id, [4, 5]))
                                    <td class="text-center">
                                        <a href="{{ route('jurnal.edit', $j->id) }}" class="btn btn-warning btn-sm">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>

                                        <form action="{{ route('jurnal.destroy', $j->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-sm"
                                                onclick="return confirm('Hapus data jurnal?')">
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
