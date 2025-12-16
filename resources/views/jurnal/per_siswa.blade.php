@extends('dashboard')

@section('content')
    <div class="container-fluid px-4">

        <h1 class="mt-4 mb-4 text-primary fw-bold">
            <i class="bi bi-journal-text"></i>
            Jurnal {{ $siswa->nama }}
        </h1>

        {{-- <a href="{{ route('jurnal.create') }}" class="btn btn-primary mb-3">
            <i class="bi bi-plus-circle"></i> Tambah Jurnal
        </a> --}}

        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white d-flex justify-content-between">
                <span><i class="bi bi-list"></i> Daftar Jurnal Siswa</span>


                <a class="btn btn-light btn-sm fw-bold" href="{{ route('jurnal.create_per_siswa') }}">
                    <i class="bi bi-plus-circle me-1"></i>
                    <span>Tambah Jurnal</span>
                </a>



            </div>
            <div class="card-body">

                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-sm text-nowrap">
                        <thead class="table-dark text-center">
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Deskripsi Kegiatan</th>
                                <th>Dokumentasi</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($jurnal as $j)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ \Carbon\Carbon::parse($j->tanggal)->format('d-m-Y') }}</td>
                                    <td style="min-width:250px">{{ $j->deskripsi }}</td>
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

                                    <td class="text-center">
                                        <a href="{{ route('jurnal.edit', $j->id) }}" class="btn btn-warning btn-sm">
                                            <i class="bi bi-pencil"></i>
                                        </a>

                                        <form action="{{ route('jurnal.destroy', $j->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-danger btn-sm" onclick="return confirm('Hapus jurnal?')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">
                                        Belum ada jurnal
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
