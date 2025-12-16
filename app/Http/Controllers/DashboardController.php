<?php

namespace App\Http\Controllers;

use App\Models\GuruPembimbing;
use App\Models\Jurnal;
use App\Models\Siswa;
use App\Models\Mitra;
use App\Models\User;
use App\Models\Kaprod;
use App\Models\Jurusan;
use Illuminate\Support\Facades\Auth;


use function Laravel\Prompts\clear;

class DashboardController extends Controller
{
    // ADMIN / HUMAS
    public function index()
    {
        return view('dashboard_home', [
            'totalSiswa'          => Siswa::count(),
            'totalGuruPembimbing' => GuruPembimbing::count(),
            'totalMitra'          => Mitra::count(),
            'totalKaprodi'        => Kaprod::count(),
            'totalUser'           => User::count(),
            'totalJurnal'         => Jurnal::count(),
            'totalJurusan'        => Jurusan::count(),
        ]);
    }

    // GURU
    public function guru()
    {
        $guru = Auth::user()->guruPembimbing;
        if (!$guru) abort(403);

        $jurusan = $guru->jurusan;

        return view('dashboard_home', [
            'totalSiswa' => Siswa::where('jurusan_id', $jurusan->id)->count(),
            'totalGuruPembimbing' => GuruPembimbing::where('jurusan_id', $jurusan->id)->count(),
            'totalMitra' => Mitra::whereHas('siswa', fn ($q) =>
                $q->where('jurusan_id', $jurusan->id)
            )->distinct()->count(),
            'totalJurnal' => Jurnal::whereHas('siswa', fn ($q) =>
                $q->where('jurusan_id', $jurusan->id)
            )->count(),
            'namaJurusan' => $jurusan->nama_jurusan,
        ]);
    }

    // KAPRODI
    public function kaprodi()
    {
        $kaprodi = Auth::user()->kaprod;
        if (!$kaprodi) abort(403);

        $jurusan = $kaprodi->jurusan;

        return view('dashboard_home', [
            'totalSiswa' => Siswa::where('jurusan_id', $jurusan->id)->count(),
            'totalGuruPembimbing' => GuruPembimbing::where('jurusan_id', $jurusan->id)->count(),
            'namaJurusan' => $jurusan->nama_jurusan,
        ]);
    }

    // SISWA
    public function siswa()
    {
        $siswa = Auth::user()->siswa;
        if (!$siswa) abort(403);

        return view('dashboard_home', [
            'totalJurnal' => Jurnal::where('siswa_id', $siswa->id)->count(),
        ]);
    }
}
