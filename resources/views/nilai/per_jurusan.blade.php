@extends('dashboard')

@section('content')
    <div class="container-fluid px-4">

        <h1 class="mt-4 mb-4 text-primary fw-bold">
            <i class="bi bi-award-fill"></i>
            Nilai Siswa Jurusan {{ $jurusan->nama_jurusan }}
        </h1>

        @if (in_array(auth()->user()->role_id, [1, 5]))
            <a href="{{ route('nilai.export_jurusan', $jurusan->id) }}" class="btn btn-danger btn-sm fw-bold">
                <i class="bi bi-file-earmark-pdf-fill"></i> Unduh PDF
            </a>
        @endif


        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <span>
                    <i class="bi bi-list-ul"></i> Daftar Nilai Siswa
                </span>

                {{-- Guru Pembimbing & Admin --}}
                @if (in_array(auth()->user()->role_id, [3, 5]))
                    <a href="{{ route('nilai.create') }}" class="btn btn-light btn-sm fw-bold">
                        <i class="bi bi-plus-circle me-1"></i> Tambah Nilai
                    </a>
                @endif
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-sm text-nowrap align-middle">
                        <thead class="table-dark text-center">
                            <tr>
                                <th>No</th>
                                <th>NIS</th>
                                <th>Nama Siswa</th>
                                <th>Kelas</th>
                                <th>Guru Pembimbing</th>
                                <th>Nilai</th>
                                <th>Predikat</th>
                                <th>Komentar</th>
                                <th>Tempat PKL</th>
                                <th>Status</th>

                                @if (in_array(auth()->user()->role_id, [3, 5]))
                                    <th width="18%">Aksi</th>
                                @endif
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($nilai as $n)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $n->siswa->nis }}</td>
                                    <td>{{ $n->siswa->nama }}</td>
                                    <td>{{ $n->siswa->kelas }}</td>
                                    <td>{{ $n->siswa->guruPembimbing->nama_guru ?? '-' }}</td>

                                    <td class="text-center fw-bold">{{ $n->nilai }}</td>
                                    <td class="text-center fw-bold">{{ $n->predikat ?? '-' }}</td>

                                    <td style="min-width:220px">{{ $n->komentar ?? '-' }}</td>
                                    <td>{{ $n->siswa->mitra->nama_mitra ?? '-' }}</td>

                                    {{-- Status Validasi --}}
                                    <td class="text-center">
                                        @if ($n->validasi_kaprod)
                                            <span class="badge bg-success">
                                                <i class="bi bi-check-circle"></i> Valid
                                            </span>
                                        @else
                                            <span class="badge bg-warning text-dark">
                                                <i class="bi bi-hourglass-split"></i> menunggu
                                            </span>
                                        @endif
                                    </td>

                                    {{-- Aksi --}}
                                    @if (in_array(auth()->user()->role_id, [3, 5]))
                                        <td class="text-center">

                                            {{-- Edit & Delete (Guru / Admin) --}}
                                            @if (in_array(auth()->user()->role_id, [3, 5]))
                                                <a href="{{ route('nilai.edit', $n->id) }}"
                                                    class="btn btn-warning btn-sm mb-1">
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>

                                                <form action="{{ route('nilai.destroy', $n->id) }}" method="POST"
                                                    class="d-inline"
                                                    onsubmit="return confirm('Yakin ingin menghapus nilai ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-danger btn-sm mb-1">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            @endif

                                            {{-- Validasi Kaprodi --}}
                                            @if (auth()->user()->role_id == 1 && !$n->validasi_kaprod)
                                                <form action="{{ route('nilai.validasi', $n->id) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    <button class="btn btn-success btn-sm">
                                                        <i class="bi bi-check-circle"></i> Validasi
                                                    </button>
                                                </form>
                                            @endif

                                        </td>
                                    @endif
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="11" class="text-center text-muted">
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
