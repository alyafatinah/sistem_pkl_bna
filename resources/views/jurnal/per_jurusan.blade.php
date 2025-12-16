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
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted">
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
