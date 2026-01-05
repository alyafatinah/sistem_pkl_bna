@extends('dashboard')

@section('content')
    <div class="container-fluid px-4">

        <h1 class="mt-4 mb-4 text-primary fw-bold">
            <i class="bi bi-person-badge-fill"></i>
            Guru Pembimbing Jurusan {{ $jurusan->nama_jurusan }}
        </h1>

        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white d-flex justify-content-between">
                <span><i class="bi bi-list"></i> Daftar Guru Pembimbing</span>
            </div>
            <div class="card-body">

                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-sm">
                        <thead class="table-dark text-center">
                            <tr>
                                <th>No</th>
                                <th>NIP</th>
                                <th>Nama</th>
                                <th>Bidang Keahlian</th>
                                <th>Email</th>
                                <th>Telp</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($guruPembimbing as $g)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $g->nip }}</td>
                                    <td>{{ $g->nama_guru }}</td>
                                    <td>{{ $g->bidang }}</td>
                                    <td>{{ $g->user->email ?? '-' }}</td>
                                    <td>{{ $g->telp }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

    </div>
@endsection
