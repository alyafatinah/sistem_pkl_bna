@extends('dashboard')

@section('content')
    <div class="container-fluid px-4">

        <h1 class="mt-4 mb-4 text-primary fw-bold">
            <i class="bi bi-people-fill"></i> Data Semua Pengguna
        </h1>

        {{-- <a href="{{ route('users.export') }}" class="btn btn-success mb-3">
            <i class="bi bi-download"></i> Unduh Data User
        </a> --}}
        <a href="{{ route('users.export.pdf') }}" class="btn btn-danger mb-3">
            <i class="bi bi-file-earmark-pdf-fill"></i> Unduh PDF
        </a>


        <table class="table table-striped table-bordered align-middle">
            <thead class="table-dark text-center">
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Role</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($users as $u)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ $u->name }}</td>
                        <td>{{ $u->username }}</td>
                        <td>{{ $u->email }}</td>
                        <td>{{ $u->role->nama }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>


    </div>
@endsection
