@extends('dashboard')

@section('content')
    <div class="container-fluid px-4">


        <h1 class="mt-4 mb-4 text-primary fw-bold">
            <i class="bi bi-journal-text"></i>
            Jurnal Siswa Jurusan {{ $jurusan->nama_jurusan }}
        </h1>


        <div class="card shadow-sm">
            <div class="card-body">

                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-sm text-nowrap">
                        <thead class="table-dark text-center">
                            <tr>
                                <th>No</th>
                                <th>NIS</th>
                                <th>Nama Siswa</th>
                                <th>Kelas</th>
                                <th>Tanggal</th>
                                <th>Kegiatan</th>
                                <th>Tempat PKL</th>
                                <th>Dokumentasi</th>
                                <th>Status</th>

                                {{-- VALIDASI (GURU) --}}
                                @if (in_array(auth()->user()->role_id, [3, 5]))
                                    <th>Validasi</th>
                                @endif
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($jurnal as $j)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $j->siswa->nis }}</td>
                                    <td>{{ $j->siswa->nama }}</td>
                                    <td>{{ $j->siswa->kelas }}</td>
                                    <td>{{ \Carbon\Carbon::parse($j->tanggal)->format('d-m-Y') }}</td>
                                    <td style="min-width:250px">{{ $j->deskripsi }}</td>
                                    <td>{{ $j->siswa->mitra->nama_mitra ?? '-' }}</td>

                                    <td class="text-center">
                                        @if ($j->dokumentasi)
                                            <a href="{{ asset('storage/' . $j->dokumentasi) }}" target="_blank"
                                                class="btn btn-sm btn-primary">
                                                <i class="bi bi-image"></i> Lihat
                                            </a>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif

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

                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center text-muted">
                                        Belum ada jurnal siswa
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
