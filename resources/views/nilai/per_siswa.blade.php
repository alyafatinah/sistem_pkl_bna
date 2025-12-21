@extends('dashboard')

@section('content')
    <div class="container-fluid px-4">

        <h1 class="mt-4 mb-4 text-primary fw-bold">
            <i class="bi bi-file-earmark-text-fill"></i>
            Nilai PKL {{ $siswa->nama }}
        </h1>

        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <div class="fw-semibold">
                    <i class="bi bi-list-ul me-1"></i>
                    Daftar Siswa
                </div>
            </div>
            
            <div class="card-body">

                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-sm text-nowrap">

                        <thead class="table-dark text-center">
                            <tr>
                                <th>No</th>
                                <th>Nilai</th>
                                <th>Komentar Guru</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($nilai as $n)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td class="text-center fw-bold fs-5">{{ $n->nilai }}</td>
                                    <td style="min-width:300px">
                                        {{ $n->komentar ?? '-' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted">
                                        Nilai PKL belum tersedia
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
