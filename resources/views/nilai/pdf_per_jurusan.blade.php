<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Nilai PKL</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
        }

        h2,
        h4 {
            text-align: center;
            margin: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        table th,
        table td {
            border: 1px solid #000;
            padding: 6px;
            text-align: center;
        }

        table th {
            background-color: #f0f0f0;
        }
    </style>
</head>

<body>

    <h2>LAPORAN NILAI PKL SISWA</h2>
    <h4>Jurusan {{ $jurusan->nama_jurusan }}</h4>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>NIS</th>
                <th>Nama Siswa</th>
                <th>Kelas</th>
                <th>Guru Pembimbing</th>
                <th>Nilai</th>
                <th>Predikat</th>
                <th>Tempat PKL</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($nilai as $n)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $n->siswa->nis }}</td>
                    <td>{{ $n->siswa->nama }}</td>
                    <td>{{ $n->siswa->kelas }}</td>
                    <td>{{ $n->siswa->guruPembimbing->nama_guru ?? '-' }}</td>
                    <td>{{ $n->nilai }}</td>
                    <td>{{ $n->predikat ?? '-' }}</td>
                    <td>{{ $n->siswa->mitra->nama_mitra ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <br><br>

    <table width="100%" style="border:none">
        <tr>
            <td style="border:none; text-align:left">
                Dicetak pada: {{ now()->format('d-m-Y') }}
            </td>
            <td style="border:none; text-align:right">
                Kaprodi
                <br><br><br>
                ( _____________________ )
            </td>
        </tr>
    </table>

</body>

</html>
