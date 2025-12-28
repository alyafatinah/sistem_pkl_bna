@extends('dashboard')

@section('content')
<div class="container-fluid px-4">

    {{-- JUDUL HALAMAN --}}
    <div class="d-flex align-items-center gap-2 mb-3">
        <i class="bi bi-calendar-week-fill fs-3 text-primary"></i>
        <h3 class="mb-0 fw-bold text-primary"> Jadwal PKL</h3>
    </div>

    {{-- CARD UTAMA --}}
    <div class="card shadow-sm border-0">

        {{-- HEADER CARD BIRU --}}
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <div class="fw-semibold">
                <i class="bi bi-list-ul me-1"></i>
                Daftar Jadwal PKL
            </div>

            @if(in_array(auth()->user()->role_id, [2,5]))
                <a href="{{ route('jadwal.create') }}" class="btn btn-light btn-sm fw-semibold">
                    <i class="bi bi-plus-circle me-1"></i>
                    Tambah Jadwal
                </a>
            @endif
        </div>

        {{-- BODY CARD --}}
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-bordered table-hover mb-0 align-middle">

                    {{-- HEADER TABEL --}}
                    <thead class="table-dark text-center">
                        <tr>

                            <th width="80">Tahun Ajaran</th>
                            <th>Periode</th>
                            <th>Jurusan</th>
                            <th>Pembekalan</th>
                            <th>Pengantaran</th>
                            <th>Monitoring</th>
                            <th>Penjemputan</th>
                            @if(in_array(auth()->user()->role_id, [2,5]))
                                <th width="120">Aksi</th>
                            @endif
                        </tr>
                    </thead>

                    {{-- BODY TABEL --}}
                    <tbody>
                        @forelse ($jadwal as $j)
                            <tr>
                                <td class="text-center fw-semibold">{{ $j->angkatan }}</td>
                                <td>{{$j->periode}}</td>
                                <td>{{ $j->jurusan->nama_jurusan }}</td>
                                <td class="text-center">{{ \Carbon\Carbon::parse($j->pembekalan)->format('d-m-Y') }}</td>
                                <td class="text-center">{{ \Carbon\Carbon::parse($j->pengantaran)->format('d-m-Y') }}</td>
                                <td class="text-center">{{ \Carbon\Carbon::parse($j->monitoring)->format('d-m-Y') }}</td>
                                <td class="text-center">{{ \Carbon\Carbon::parse($j->penjemputan)->format('d-m-Y') }}</td>

                                @if(in_array(auth()->user()->role_id, [2,5]))
                                    <td class="text-center">
                                        <a href="{{ route('jadwal.edit', $j->id) }}"
                                           class="btn btn-warning btn-sm">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>

                                        <form action="{{ route('jadwal.destroy', $j->id) }}"
                                              method="POST"
                                              class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Hapus jadwal ini?')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                @endif
                            </tr>
                        @empty
                            {{-- EMPTY STATE (SAMA SEPERTI DATA MITRA) --}}
                            <tr>
                                <td colspan="{{ in_array(auth()->user()->role_id, [2,5]) ? 7 : 6 }}"
                                    class="text-center text-muted py-4">
                                    Data jadwal PKL belum tersedia
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
