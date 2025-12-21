<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: DejaVu Sans; font-size: 12px; }
        table { width:100%; border-collapse: collapse; }
        th, td { border:1px solid black; padding:6px; }
        th { background:#f2f2f2; }
    </style>
</head>
<body>

<h3 style="text-align:center">DATA SEMUA PENGGUNA</h3>

<table>
<thead>
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
    <td align="center">{{ $loop->iteration }}</td>
    <td>{{ $u->name }}</td>
    <td>{{ $u->username }}</td>
    <td>{{ $u->email }}</td>
    <td>{{ $u->role->nama ?? '-' }}</td>
</tr>
@endforeach
</tbody>
</table>

</body>
</html>
