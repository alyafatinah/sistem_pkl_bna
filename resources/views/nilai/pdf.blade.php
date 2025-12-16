<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Laporan Nilai PKL</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 11px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 6px;
        }

        th {
            background: #f2f2f2;
        }

        h2 {
            text-align: center;
            margin-bottom: 15px;
        }
    </style>
</head>

<body>

    <h2>LAPORAN NILAI PRAKTIK KERJA LAPANGAN</h2>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>NIS</th>
                <th>Nama Siswa</th>
                <th>Jurusan</th>
                <th>Guru Pembimbing</th>
                <th>Nilai</th>
                <th>Komentar</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($nilai as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->siswa->nis }}</td>
                    <td>{{ $item->siswa->nama ?? '-' }}</td> 
                    <td>{{ $item->siswa->jurusan->nama_jurusan ?? '-' }}</td>
                    <td>{{ $item->siswa->guruPembimbing->nama_guru ?? '-' }}</td>
                    <td>{{ $item->nilai }}</td>
                    <td>{{ $item->komentar }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>
