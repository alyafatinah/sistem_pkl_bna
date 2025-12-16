<?php

namespace App\Http\Controllers;

use App\Models\Jurnal;
use Illuminate\Http\Request;
use App\Models\Jurusan;
use Illuminate\Support\Facades\Auth;

class JurnalController extends Controller
{
    /**
     * Menampilkan daftar jurnal
     */
    public function index()
    {
        $jurnal = Jurnal::with('siswa')->get();
        return view('jurnal.index', compact('jurnal'));
    }

    /**
     * Form tambah jurnal
     */
    public function create()
    {
        return view('jurnal.create');
    }

    /**
     * Simpan jurnal (SISWA)
     * status default = menunggu
     */
    public function store(Request $request)
    {
        $request->validate([
            'siswa_id'    => 'required|exists:siswa,id',
            'tanggal'     => 'required|date',
            'deskripsi'   => 'required',
            'dokumentasi' => 'nullable|image|mimes:jpg,jpeg,png|max:512000',
        ]);

        $dokumentasiPath = null;
        if ($request->hasFile('dokumentasi')) {
            $dokumentasiPath = $request->file('dokumentasi')
                ->store('dokumentasi_jurnal', 'public');
        }

        $jurnal = new Jurnal();
        $jurnal->siswa_id    = $request->siswa_id;
        $jurnal->tanggal     = $request->tanggal;
        $jurnal->deskripsi   = $request->deskripsi;
        $jurnal->dokumentasi = $dokumentasiPath;
        $jurnal->status      = 'menunggu';
        $jurnal->save();

        return redirect()->route('jurnal.index')
            ->with('success', 'Jurnal berhasil ditambahkan');
    }

    // create dan store per-siswa
    public function createPerSiswa()
    {
        $siswa = auth::user()->siswa;

        if (!$siswa) {
            abort(403, 'Akun ini bukan akun siswa');
        }

        return view('jurnal.create_per_siswa', compact('siswa'));
    }



    /**
     * Simpan jurnal siswa (otomatis milik sendiri)
     */
    public function storePerSiswa(Request $request)
    {
        $request->validate([
            'tanggal'     => 'required|date',
            'deskripsi'   => 'nullable|string',
            'dokumentasi' => 'nullable|image|mimes:jpg,jpeg,png|max:5120', // 5MB
        ]);

        $siswa = auth::user()->siswa;

        if (!$siswa) {
            abort(403, 'Akun ini bukan akun siswa');
        }

        $data = [
            'siswa_id'  => $siswa->id,
            'tanggal'   => $request->tanggal,
            'deskripsi' => $request->deskripsi,
            'status'    => 'menunggu',
        ];

        // upload foto jika ada
        if ($request->hasFile('dokumentasi')) {
            $data['dokumentasi'] = $request->file('dokumentasi')
                ->store('jurnal', 'public');
        }

        Jurnal::create($data);

        return redirect()
            ->route('jurnal.per_siswa', $siswa->id)
            ->with('success', 'Jurnal berhasil ditambahkan');
    }
    /**
     * Form edit jurnal
     */
    public function edit($id)
    {
        $jurnal = Jurnal::with('siswa')->findOrFail($id);
        return view('jurnal.edit', compact('jurnal'));
    }

    /**
     * Update jurnal (TANPA MENGUBAH STATUS)
     */
    public function update(Request $request, $id)
    {
        $jurnal = Jurnal::findOrFail($id);

        $request->validate([
            'tanggal'     => 'required|date',
            'deskripsi'   => 'required',
            'dokumentasi' => 'nullable|image|mimes:jpg,jpeg,png|max:512000',
        ]);

        if ($request->hasFile('dokumentasi')) {
            $jurnal->dokumentasi = $request->file('dokumentasi')
                ->store('dokumentasi_jurnal', 'public');
        }

        $jurnal->tanggal   = $request->tanggal;
        $jurnal->deskripsi = $request->deskripsi;
        $jurnal->save();

        return redirect()->route('jurnal.index')
            ->with('success', 'Jurnal berhasil diperbarui');
    }

    /**
     * Hapus jurnal
     */
    public function destroy($id)
    {
        Jurnal::findOrFail($id)->delete();

        return redirect()->route('jurnal.index')
            ->with('success', 'Jurnal berhasil dihapus');
    }

    /**
     * Validasi jurnal (GURU PEMBIMBING & ADMIN)
     */
    public function setujui($id)
    {
        $jurnal = Jurnal::findOrFail($id);

        if (!in_array(Auth::user()->role_id, [3, 5])) {
            abort(403, 'Anda tidak memiliki akses.');
        }

        // PAKSA SIMPAN (PALING AMAN)
        $jurnal->status = 'disetujui';
        $jurnal->save();

        return redirect()->route('jurnal.index')
            ->with('success', 'Jurnal berhasil disetujui');
    }


    public function jurnalPerJurusan($id)
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
        // AMBIL DATA JURNAL
        // ===============================
        $jurusan = Jurusan::findOrFail($id);

        $jurnal = Jurnal::with(['siswa.jurusan', 'siswa.mitra'])
            ->whereHas('siswa', function ($q) use ($id) {
                $q->where('jurusan_id', $id);
            })
            ->orderBy('tanggal', 'desc')
            ->get();

        return view('jurnal.per_jurusan', compact('jurnal', 'jurusan'));
    }

    public function jurnalPerSiswa($id)
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
            abort(403, 'Anda tidak berhak mengakses jurnal ini');
        }

        // =========================
        // AMBIL JURNAL MILIK SISWA
        // =========================
        $jurnal = Jurnal::where('siswa_id', $siswa->id)
            ->orderBy('tanggal', 'desc')
            ->get();

        return view('jurnal.per_siswa', compact('jurnal', 'siswa'));
    }
}
