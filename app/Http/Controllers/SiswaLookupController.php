<?php

namespace App\Http\Controllers;

use App\Models\Siswa;

class SiswaLookupController extends Controller
{
    public function byNisNilai($nis)
    {
        $siswa = Siswa::with(['jurusan', 'guruPembimbing'])
            ->where('nis', $nis)
            ->first();

        if (!$siswa) {
            return response()->json([
                'message' => 'NIS tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'id' => $siswa->id,
            'nama' => $siswa->nama,
            'jurusan' => $siswa->jurusan->nama_jurusan ?? '-',
            'gurupembimbing' => $siswa->guruPembimbing->nama_guru ?? '-',
        ]);
    }
}
