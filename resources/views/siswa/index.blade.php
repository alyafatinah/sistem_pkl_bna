@extends('dashboard')

@section('content')
    <div class="container-fluid px-4">
        
        @if (in_array(auth()->user()->role_id, [1, 2, 4, 5]))
            <h1 class="mt-4 mb-4 text-primary fw-bold">
                <i class="bi bi-person-badge-fill"></i> Data Siswa
            </h1>
        @endif

        @if (auth()->user()->role_id == 3)
            <h1 class="mt-4 mb-4 text-primary fw-bold">
                <i class="bi bi-person-badge-fill"></i> Data Siswa Bimbingan
            </h1>
        @endif

        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white d-flex justify-content-between">
                <span><i class="bi bi-list"></i> Daftar Siswa</span>

                @if (in_array(auth()->user()->role_id, [2, 5]))
                    <a href="{{ route('siswa.create') }}" class="btn btn-light btn-sm fw-bold">
                        <i class="bi bi-plus-circle me-1"></i> Tambah Data Siswa
                    </a>
                @endif
            </div>

            <div class="card-body">

                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                {{-- RESPONSIVE TABLE --}}
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-sm text-nowrap">
                        <thead class="table-dark text-center">
                            <tr>
                                <th>No</th>
                                <th>NIS</th>
                                <th>Nama</th>
                                <th>Kelas</th>
                                <th>Alamat Siswa</th>
                                <th>Email</th>
                                <th>Telp</th>
                                <th>Jurusan</th>
                                <th>Guru Pembimbing</th>
                                <th>Tempat PKL</th>
                                <th>Bidang</th>
                                <th>Alamat PKL</th>
                                @if (in_array(auth()->user()->role_id, [2, 5]))
                                    <th width="120">Aksi</th>
                                @endif
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($siswa as $s)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $s->nis }}</td>
                                    <td>{{ $s->nama }}</td>
                                    <td>{{ $s->kelas }}</td>
                                    <td style="min-width:180px">{{ $s->alamat }}</td>
                                    <td>{{ $s->user->email ?? '-' }}</td>
                                    <td>{{ $s->telp }}</td>
                                    <td>{{ $s->jurusan->nama_jurusan }}</td>
                                    <td>{{ $s->gurupembimbing->nama_guru }}</td>
                                    <td>{{ $s->mitra->nama_mitra }}</td>
                                    <td>{{ $s->mitra->bidang }}</td>
                                    <td style="min-width:180px">{{ $s->mitra->alamat }}</td>

                                    @if (in_array(auth()->user()->role_id, [2, 5]))
                                        <td class="text-center">
                                            <a href="{{ route('siswa.edit', $s->id) }}"
                                                class="btn btn-warning btn-sm mb-1">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>

                                            <form action="{{ route('siswa.destroy', $s->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button onclick="return confirm('Hapus siswa?')"
                                                    class="btn btn-danger btn-sm">
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
                {{-- END RESPONSIVE TABLE --}}

            </div>
        </div>
    </div>
@endsection
