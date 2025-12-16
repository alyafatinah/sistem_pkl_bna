<?php

namespace App\Http\Controllers;

use App\Models\Nilai;
use App\Models\Siswa;
use App\Models\Jurusan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class NilaiController extends Controller
{

    public function index()
    {
        $user = Auth::user();

        // ROLE 4 - SISWA (nilai milik sendiri)
        if ($user->role_id == 4) {
            return redirect()->route('nilai.per_siswa', $user->siswa->id);
        }

        // ROLE 1 (Kaprodi) & 3 (Guru Pembimbing)
        if (in_array($user->role_id, [1, 3])) {
            $jurusan_id = null;

            // Guru Pembimbing
            if ($user->role_id == 3) {
                $jurusan_id = $user->guruPembimbing->jurusan_id;
            }

            // Kaprodi
            if ($user->role_id == 1) {
                $jurusan_id = $user->jurusan_id; // atau relasi kaprodi
            }

            return redirect()->route('nilai.per_jurusan', $jurusan_id);
        }

        // ROLE 2 (Humas) & 5 (Admin) → semua data
        if (in_array($user->role_id, [2, 5])) {
            $nilai = Nilai::with(['siswa.jurusan', 'siswa.guruPembimbing'])->get();
            return view('nilai.index', compact('nilai'));
        }

        abort(403, 'Anda tidak memiliki akses');
    }


    public function create()
    {
        return view('nilai.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswa,id|unique:nilai,siswa_id',
            'nilai'    => 'required|integer|min:0|max:100',
            'komentar' => 'required',
        ]);

        Nilai::create([
            'siswa_id' => $request->siswa_id,
            'nilai'    => $request->nilai,
            'komentar' => $request->komentar,
        ]);

        return redirect()->route('nilai.index')
            ->with('success', 'Nilai berhasil disimpan');
    }

    public function edit(Nilai $nilai)
    {
        $nilai->load(['siswa.jurusan', 'siswa.guruPembimbing']);
        return view('nilai.edit', compact('nilai'));
    }

    public function update(Request $request, Nilai $nilai)
    {
        $request->validate([
            'nilai'    => 'required|integer|min:0|max:100',
            'komentar' => 'required',
        ]);

        $nilai->update([
            'nilai'    => $request->nilai,
            'komentar' => $request->komentar,
        ]);

        return redirect()->route('nilai.index')
            ->with('success', 'Nilai berhasil diperbarui');
    }

    public function destroy(Nilai $nilai)
    {
        $nilai->delete();
        return redirect()->route('nilai.index')
            ->with('success', 'Nilai berhasil dihapus');
    }



    public function nilaiPerJurusan($id)
    {
        $user = Auth::user();

        // ===============================
        // CEK ROLE & AMBIL JURUSAN USER
        // ===============================
        if ($user->role_id == 1) {
            // KAPRODI
            if (!$user->kaprod) {
                abort(403, 'Akses ditolak');
            }
            $jurusanUserId = $user->kaprod->jurusan_id;
        } elseif ($user->role_id == 3) {
            // GURU PEMBIMBING
            if (!$user->guruPembimbing) {
                abort(403, 'Akses ditolak');
            }
            $jurusanUserId = $user->guruPembimbing->jurusan_id;
        } else {
            abort(403, 'Akses ditolak');
        }

        // ===============================
        // CEK URL vs JURUSAN USER
        // ===============================
        if ((int) $id !== (int) $jurusanUserId) {
            abort(403, 'Anda tidak berhak mengakses jurusan ini');
        }

        // ===============================
        // AMBIL DATA NILAI
        // ===============================
        $jurusan = Jurusan::findOrFail($id);

        $nilai = Nilai::with(['siswa.jurusan', 'siswa.mitra'])
            ->whereHas('siswa', function ($q) use ($id) {
                $q->where('jurusan_id', $id);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('nilai.per_jurusan', compact('nilai', 'jurusan'));
    }


    public function nilaiPerSiswa($id)
    {
        $user = Auth::user();

        // pastikan user adalah siswa
        if (!$user->siswa) {
            abort(403, 'Akses ditolak');
        }

        $siswa = $user->siswa;

        // =========================
        // CEK KEPEMILIKAN DATA
        // =========================
        if ((int) $id !== (int) $siswa->id) {
            abort(403, 'Anda tidak berhak mengakses nilai ini');
        }

        // =========================
        // AMBIL NILAI MILIK SISWA
        // =========================
        $nilai = Nilai::where('siswa_id', $siswa->id)
            ->latest()
            ->get();

        return view('nilai.per_siswa', compact('nilai', 'siswa'));
    }



    public function exportPdf()
    {
        // hak akses (opsional, sesuaikan)
        if (!in_array(Auth::user()->role_id, [2])) {
            abort(403, 'Tidak memiliki akses');
        }


        $nilai = Nilai::with([
            'siswa.jurusan',
            'siswa.guruPembimbing'
        ])->get();

        $pdf = Pdf::loadView('nilai.pdf', compact('nilai'))
            ->setPaper('A4', 'landscape');

        return $pdf->download('nilai-pkl.pdf');
    }
}
