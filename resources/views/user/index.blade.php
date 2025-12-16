@extends('dashboard')

@section('content')
<div class="container-fluid px-4">

    <h1 class="mt-4 mb-4 text-primary fw-bold">
        <i class="bi bi-people-fill"></i> Data Semua Pengguna
    </h1>

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
