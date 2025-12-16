@extends('dashboard')

@section('content')
    <div class="container-fluid px-4">

        <h1 class="mt-4 mb-4 text-primary fw-bold">
            <i class="bi bi-award-fill"></i> Data Nilai PKL
        </h1>

        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <span>
                    <i class="bi bi-list-ul"></i> Daftar Nilai Siswa
                </span>

                @if (in_array(auth()->user()->role_id, [3, 5]))
                    <a href="{{ route('nilai.create') }}" class="btn btn-light btn-sm fw-bold">
                        <i class="bi bi-plus-circle me-1"></i> Tambah Nilai
                    </a>
                @endif
            </div>

            <div class="card-body">

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-bordered table-striped align-middle">
                        <thead class="table-dark text-center">
                            <tr>
                                <th width="5%">No</th>
                                <th>NIS</th>
                                <th>Nama Siswa</th>
                                <th>Guru Pembimbing</th>
                                <th>Jurusan</th>
                                <th width="10%">Nilai</th>
                                <th>Komentar</th>
                                @if (in_array(auth()->user()->role_id, [3, 5]))
                                    <th width="15%">Aksi</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($nilai as $item)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $item->siswa->nis }}</td>
                                    <td>{{ $item->siswa->nama }}</td>
                                    <td>{{ $item->siswa->guruPembimbing->nama_guru ?? '-' }}</td>
                                    <td>{{ $item->siswa->jurusan->nama_jurusan ?? '-' }}</td>

                                    <td class="text-center">
                                        <span class="badge bg-light text-dark fs-6">
                                            {{ $item->nilai ?? '-' }}
                                        </span>
                                    </td>

                                    <td>{{ $item->komentar ?? '-' }}</td>


                                    @if (in_array(auth()->user()->role_id, [3, 5]))
                                        <td class="text-center">
                                            <a href="{{ route('nilai.edit', $item->id) }}" class="btn btn-warning btn-sm">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>

                                            <form action="{{ route('nilai.destroy', $item->id) }}" method="POST"
                                                class="d-inline"
                                                onsubmit="return confirm('Yakin ingin menghapus nilai ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger btn-sm">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-muted">-</span>
                                        </td>
                                    @endif

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted">
                                        Data nilai belum tersedia
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

    </div>
@endsection
