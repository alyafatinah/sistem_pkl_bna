<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\User;
use App\Models\Jurusan;
use App\Models\Mitra;
use App\Models\GuruPembimbing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class SiswaController extends Controller
{
    /**
     * Menampilkan data siswa
     */
    public function index()
    {
        $siswa = Siswa::with([
            'user',
            'jurusan',
            'mitra',
            'gurupembimbing'
        ])->get();

        return view('siswa.index', compact('siswa'));
    }

    /**
     * Form tambah siswa
     */
    public function create()
    {
        $jurusan = Jurusan::all();
        $mitra   = Mitra::all();
        $gurupembimbing   = GuruPembimbing::all();

        return view('siswa.create', compact('jurusan', 'mitra', 'gurupembimbing'));
    }

    /**
     * Simpan data siswa + user
     */
    public function store(Request $request)
    {
        $request->validate([
            'nis'        => 'required|unique:siswa,nis',
            'nama'       => 'required',
            'kelas'      => 'required',
            'alamat'     => 'required',
            'email'      => 'required|email|unique:users,email',
            'telp'       => 'required',
            'jurusan_id' => 'required',
            'mitra_id'   => 'required',
            'gurupembimbing_id' => 'required',
        ]);

        // 1️⃣ Buat user (login)
        $user = User::create([
            'name'     => $request->nama,
            'username' => $request->nis,
            'email'    => $request->email,
            'password' => Hash::make('siswa123'),
            'role_id'  => 4, // role siswa
        ]);

        // 2️⃣ Buat siswa
        Siswa::create([
            'user_id'   => $user->id,
            'nis'       => $request->nis,
            'nama'      => $request->nama,
            'kelas'     => $request->kelas,
            'alamat'    => $request->alamat,
            'telp'      => $request->telp,
            'jurusan_id' => $request->jurusan_id,
            'mitra_id'  => $request->mitra_id,
            'gurupembimbing_id' => $request->gurupembimbing_id
        ]);

        return redirect()->route('siswa.index')
            ->with('success', 'Data siswa berhasil ditambahkan');
    }

    /**
     * Form edit siswa
     */
    public function edit($id)
    {
        $siswa   = Siswa::with('user')->findOrFail($id);
        $jurusan = Jurusan::all();
        $mitra   = Mitra::all();
        $gurupembimbing = GuruPembimbing::all();

        return view('siswa.edit', compact('siswa', 'jurusan', 'mitra', 'gurupembimbing'));
    }

    /**
     * Update data siswa + email user
     */
    public function update(Request $request, $id)
    {
        $siswa = Siswa::findOrFail($id);

        $request->validate([
            'nama'  => 'required',
            'kelas' => 'required',
            'alamat' => 'required',
            'email' => 'required|email|unique:users,email,' . $siswa->user_id,
        ]);

        // update user
        $siswa->user->update([
            'name'  => $request->nama,
            'email' => $request->email,
        ]);

        // update siswa
        $siswa->update([
            'nama'       => $request->nama,
            'kelas'      => $request->kelas,
            'alamat'     => $request->alamat,
            'telp'       => $request->telp,
            'jurusan_id' => $request->jurusan_id,
            'mitra_id'   => $request->mitra_id,
            'gurupembimbing_id'   => $request->gurupembimbing_id,
        ]);

        return redirect()->route('siswa.index')
            ->with('success', 'Data siswa berhasil diperbarui');
    }

    /**
     * Hapus siswa + user
     */
    public function destroy($id)
    {
        $siswa = Siswa::findOrFail($id);

        // hapus user otomatis jika relasi cascade
        $siswa->user()->delete();
        $siswa->delete();

        return redirect()->route('siswa.index')
            ->with('success', 'Data siswa berhasil dihapus');
    }


    public function siswaPerJurusan($id)
    {
        $user = Auth::user();

        // ================================
        // CEK ROLE & JURUSAN USER
        // ================================
        if ($user->role_id == 3) {
            // GURU PEMBIMBING
            if (!$user->guruPembimbing) {
                abort(403, 'Akses ditolak');
            }

            $jurusanUserId = $user->guruPembimbing->jurusan_id;
        } elseif ($user->role_id == 1) {
            // KAPRODI
            if (!$user->kaprod) {
                abort(403, 'Akses ditolak');
            }

            $jurusanUserId = $user->kaprod->jurusan_id;
        } else {
            abort(403, 'Akses ditolak');
        }

        // ================================
        // CEK URL ID vs JURUSAN USER
        // ================================
        if ((int) $id !== (int) $jurusanUserId) {
            abort(403, 'Anda tidak berhak mengakses jurusan ini');
        }

        // ================================
        // AMBIL DATA
        // ================================
        $jurusan = Jurusan::findOrFail($id);

        $siswa = Siswa::with(['jurusan', 'mitra', 'gurupembimbing', 'user'])
            ->where('jurusan_id', $id)
            ->get();

        return view('siswa.per_jurusan', compact('siswa', 'jurusan'));
    }
}
