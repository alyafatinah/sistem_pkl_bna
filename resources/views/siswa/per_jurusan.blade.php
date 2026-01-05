@extends('dashboard')

@section('content')
    <div class="container-fluid px-4">

        <h1 class="mt-4 mb-4 text-primary fw-bold">
            <i class="bi bi-people-fill"></i>
            Data Siswa Jurusan {{ $jurusan->nama_jurusan }}
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
                                <th>NIS</th>
                                <th>Nama</th>
                                <th>Kelas</th>
                                <th>Alamat Siswa</th>
                                <th>Email</th>
                                <th>Telp</th>
                                <th>Guru Pembimbing</th>
                                <th>Tempat PKL</th>
                                <th>Bidang</th>
                                <th>Alamat PKL</th>
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
                                    <td>{{ $s->gurupembimbing->nama_guru }}</td>
                                    <td>{{ $s->mitra->nama_mitra }}</td>
                                    <td>{{ $s->mitra->bidang }}</td>
                                    <td style="min-width:180px">{{ $s->mitra->alamat }}</td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

    </div>
@endsection
