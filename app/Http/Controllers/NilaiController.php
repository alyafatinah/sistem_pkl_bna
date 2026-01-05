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
    /* =========================================================
     * INDEX (REDIRECT SESUAI ROLE)
     * ========================================================= */
    public function index()
    {
        $user = Auth::user();

        // ROLE 4 - SISWA (nilai milik sendiri)
        if ($user->role_id == 4 && $user->siswa) {
            return redirect()->route('nilai.per_siswa', $user->siswa->id);
        }

        // ROLE 3 - GURU PEMBIMBING
        // if ($user->role_id == 3 && $user->guruPembimbing) {
        //     return redirect()->route(
        //         'nilai.per_jurusan',
        //         $user->guruPembimbing->jurusan_id
        //     );
        // }

        // ======================
        // Jika guru pembimbing (role_id = 3)
        if ($user->role_id == 3 && $user->guruPembimbing) {

            $nilai = Nilai::with('siswa')
                ->whereHas('siswa', function ($q) use ($user) {
                    $q->where('gurupembimbing_id', $user->guruPembimbing->id);
                })
                ->latest()
                ->get();

            return view('nilai.index', compact('nilai'));
        }

        // ROLE 1 - KAPRODI
        if ($user->role_id == 1 && $user->kaprod) {
            return redirect()->route(
                'nilai.per_jurusan',
                $user->kaprod->jurusan_id
            );
        }

        // ROLE 2 (HUMAS) & 5 (ADMIN) → semua data
        if (in_array($user->role_id, [2, 5])) {
            $nilai = Nilai::with(['siswa.jurusan', 'siswa.guruPembimbing'])
                ->latest()
                ->get();

            return view('nilai.index', compact('nilai'));
        }

        abort(403, 'Anda tidak memiliki akses');
    }

    /* =========================================================
     * CREATE
     * ========================================================= */
    public function create()
    {
        return view('nilai.create');
    }

    /* =========================================================
     * STORE
     * ========================================================= */
    public function store(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswa,id|unique:nilai,siswa_id',
            'nilai'    => 'required|integer|min:0|max:100',
            'komentar' => 'required|string',
        ]);

        $nilaiAngka = $request->nilai;

        // HITUNG PREDIKAT OTOMATIS
        $predikat = match (true) {
            $nilaiAngka >= 90 => 'A',
            $nilaiAngka >= 80 => 'B',
            $nilaiAngka >= 70 => 'C',
            default           => 'D',
        };

        Nilai::create([
            'siswa_id'        => $request->siswa_id,
            'nilai'           => $nilaiAngka,
            'predikat'        => $predikat,
            'komentar'        => $request->komentar,
            'validasi_kaprod' => false,
        ]);

        return redirect()
            ->route('nilai.index')
            ->with('success', 'Nilai berhasil disimpan');
    }

    /* =========================================================
     * EDIT
     * ========================================================= */
    public function edit(Nilai $nilai)
    {
        $nilai->load(['siswa.jurusan', 'siswa.guruPembimbing']);
        return view('nilai.edit', compact('nilai'));
    }

    /* =========================================================
     * UPDATE
     * ========================================================= */
    public function update(Request $request, Nilai $nilai)
    {
        $request->validate([
            'nilai'    => 'required|integer|min:0|max:100',
            'komentar' => 'required|string',
        ]);

        $nilaiAngka = $request->nilai;

        $predikat = match (true) {
            $nilaiAngka >= 90 => 'A',
            $nilaiAngka >= 80 => 'B',
            $nilaiAngka >= 70 => 'C',
            default           => 'D',
        };

        $nilai->update([
            'nilai'    => $nilaiAngka,
            'predikat' => $predikat,
            'komentar' => $request->komentar,
        ]);

        return redirect()
            ->route('nilai.index')
            ->with('success', 'Nilai berhasil diperbarui');
    }

    /* =========================================================
     * DELETE
     * ========================================================= */
    public function destroy(Nilai $nilai)
    {
        $nilai->delete();

        return redirect()
            ->route('nilai.index')
            ->with('success', 'Nilai berhasil dihapus');
    }

    /* =========================================================
     * NILAI PER JURUSAN (KAPRODI / GURU)
     * ========================================================= */
    public function nilaiPerJurusan($jurusan_id)
    {
        $user = Auth::user();

        // KAPRODI
        if ($user->role_id == 1) {
            if (!$user->kaprod) {
                abort(403, 'Data kaprodi tidak ditemukan');
            }
            $jurusan_id = $user->kaprod->jurusan_id;
        }

        // GURU PEMBIMBING
        elseif ($user->role_id == 3) {
            if (!$user->guruPembimbing) {
                abort(403, 'Data guru pembimbing tidak ditemukan');
            }
            $jurusan_id = $user->guruPembimbing->jurusan_id;
        }

        // ADMIN
        elseif ($user->role_id == 5) {
            // pakai jurusan dari URL
        } else {
            abort(403, 'Anda tidak memiliki akses');
        }

        $jurusan = Jurusan::findOrFail($jurusan_id);

        $nilai = Nilai::with(['siswa.jurusan', 'siswa.mitra'])
            ->whereHas('siswa', function ($q) use ($jurusan_id) {
                $q->where('jurusan_id', $jurusan_id);
            })
            ->latest()
            ->get();

        return view('nilai.per_jurusan', compact('nilai', 'jurusan'));
    }

    /* =========================================================
     * NILAI PER SISWA
     * ========================================================= */
    public function nilaiPerSiswa($id)
    {
        $user = Auth::user();

        if (!$user->siswa) {
            abort(403, 'Akses ditolak');
        }

        if ((int) $id !== (int) $user->siswa->id) {
            abort(403, 'Anda tidak berhak mengakses nilai ini');
        }

        $siswa = $user->siswa;

        $nilai = Nilai::where('siswa_id', $siswa->id)
            ->latest()
            ->get();

        return view('nilai.per_siswa', compact('nilai', 'siswa'));
    }

    /* =========================================================
     * VALIDASI KAPRODI
     * ========================================================= */
    public function validasi($id)
    {
        $user = Auth::user();

        if ($user->role_id != 1) {
            abort(403, 'Hanya Kaprodi yang dapat memvalidasi');
        }

        $nilai = Nilai::findOrFail($id);

        $nilai->update([
            'validasi_kaprod' => true,
        ]);

        return back()->with('success', 'Nilai berhasil divalidasi Kaprodi');
    }

    /* =========================================================
     * EXPORT PDF
     * ========================================================= */
    public function exportPdf()
    {
        if (!in_array(Auth::user()->role_id, [1, 2, 5])) {
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

    /* =========================================================
     * AJAX NIS BY JURUSAN (GURU PEMBIMBING)
     * ========================================================= */
    public function nisByJurusan(Request $request)
    {
        $user = Auth::user();

        if ($user->role_id != 3 || !$user->guruPembimbing) {
            return response()->json([]);
        }

        $jurusanId = $user->guruPembimbing->jurusan_id;
        $keyword   = $request->get('q');

        $siswa = Siswa::where('jurusan_id', $jurusanId)
            ->where('nis', 'like', "%{$keyword}%")
            ->limit(10)
            ->get(['id', 'nis']);

        return response()->json($siswa);
    }

    public function exportPdfPerJurusan($jurusan_id)
    {
        $user = Auth::user();

        // ==========================
        // VALIDASI AKSES JURUSAN
        // ==========================

        // KAPRODI
        if ($user->role_id == 1) {
            if (!$user->kaprod) {
                abort(403, 'Data kaprodi tidak ditemukan');
            }
            $jurusan_id = $user->kaprod->jurusan_id;
        }

        // GURU PEMBIMBING
        elseif ($user->role_id == 3) {
            if (!$user->guruPembimbing) {
                abort(403, 'Data guru pembimbing tidak ditemukan');
            }
            $jurusan_id = $user->guruPembimbing->jurusan_id;
        }

        // ADMIN
        elseif ($user->role_id == 5) {
            // pakai jurusan dari URL
        } else {
            abort(403, 'Anda tidak memiliki akses');
        }

        // ==========================
        // AMBIL DATA
        // ==========================

        $jurusan = Jurusan::findOrFail($jurusan_id);

        $nilai = Nilai::with([
            'siswa.jurusan',
            'siswa.guruPembimbing',
            'siswa.mitra'
        ])
            ->whereHas('siswa', function ($q) use ($jurusan_id) {
                $q->where('jurusan_id', $jurusan_id);
            })
            ->orderBy('nilai', 'desc')
            ->get();

        // ==========================
        // GENERATE PDF
        // ==========================

        $pdf = Pdf::loadView(
            'nilai.pdf_per_jurusan',
            compact('nilai', 'jurusan')
        )->setPaper('A4', 'landscape');

        return $pdf->download(
            'nilai-jurusan-' . strtolower($jurusan->nama_jurusan) . '.pdf'
        );
    }
}
