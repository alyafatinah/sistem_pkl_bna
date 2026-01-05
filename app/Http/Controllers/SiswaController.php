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
        $user = Auth::user();

        // ======================
        // GURU PEMBIMBING (ROLE 3)
        // ======================
        if ($user->role_id == 3 && $user->guruPembimbing) {

            $siswa = Siswa::with(['jurusan', 'mitra', 'guruPembimbing', 'user'])
                ->where('gurupembimbing_id', $user->guruPembimbing->id)
                ->orderBy('nama')
                ->get();

            return view('siswa.index', compact('siswa'));
        }

        // ======================
        // KAPRODI (ROLE 1)
        // ======================
        if ($user->role_id == 1 && $user->kaprodi) {

            $siswa = Siswa::with(['jurusan', 'mitra', 'guruPembimbing', 'user'])
                ->where('jurusan_id', $user->kaprodi->jurusan_id)
                ->orderBy('nama')
                ->get();

            return view('siswa.index', compact('siswa'));
        }

        // ======================
        // ADMIN & HUMAS
        // ======================
        if (in_array($user->role_id, [2, 5])) {

            $siswa = Siswa::with(['jurusan', 'mitra', 'guruPembimbing', 'user'])
                ->orderBy('nama')
                ->get();

            return view('siswa.index', compact('siswa'));
        }

        abort(403, 'Anda tidak memiliki akses ke data siswa');
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
        $request->validate(
            [
                'nis' => [
                    'required',
                    'digits:10',
                    'unique:siswa,nis',
                ],
                'nama' => 'required|string|max:255',
                'kelas' => 'required|string|max:50',
                'email' => [
                    'required',
                    'email',
                    'regex:/^[a-zA-Z0-9._%+-]+@gmail\.com$/',
                    'unique:users,email',
                ],
                'telp' => 'required|digits_between:10,15',
                'jurusan_id' => 'required|exists:jurusan,id',
                'gurupembimbing_id' => 'required|exists:gurupembimbing,id',
                'mitra_id' => 'required|exists:mitra,id',
                'alamat' => 'required|string',
            ],
            [
                'nis.required' => 'NIS wajib diisi.',
                'nis.digits' => 'NIS harus terdiri dari 10 digit angka.',
                'nis.unique' => 'NIS sudah terdaftar.',

                'email.regex' => 'Email harus menggunakan domain @gmail.com.',
                'email.unique' => 'Email sudah terdaftar.',

                'jurusan_id.required' => 'Jurusan wajib dipilih.',
                'gurupembimbing_id.required' => 'Guru pembimbing wajib dipilih.',
                'mitra_id.required' => 'Mitra PKL wajib dipilih.',
            ]
        );

        // 1️⃣ Buat user
        $user = User::create([
            'name' => $request->nama,
            'username' => $request->nis,
            'email' => $request->email,
            'password' => Hash::make('siswa123'),
            'role_id' => 4,
        ]);

        // 2️⃣ Buat siswa
        Siswa::create([
            'user_id' => $user->id,
            'nis' => $request->nis,
            'nama' => $request->nama,
            'kelas' => $request->kelas,
            'alamat' => $request->alamat,
            'telp' => $request->telp,
            'jurusan_id' => $request->jurusan_id,
            'mitra_id' => $request->mitra_id,
            'gurupembimbing_id' => $request->gurupembimbing_id,
        ]);

        return redirect()
            ->route('siswa.index')
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


    public function siswaPerJurusan($jurusan_id)
    {
        $user = Auth::user();
        //dd($user->id, $user->email, $user->role_id);

        // ================================
        // CEK AKSES ROLE
        // ================================

        // KAPRODI
        if ($user->role_id == 1) {
            if (!$user->kaprod) {
                abort(403, 'Data kaprodi tidak ditemukan');
            }

            // Paksa pakai jurusan milik kaprodi
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
            // admin bebas, pakai jurusan dari URL
        } else {
            abort(403, 'Anda tidak memiliki akses');
        }

        // ================================
        // AMBIL DATA
        // ================================

        $jurusan = Jurusan::findOrFail($jurusan_id);

        $siswa = Siswa::with(['jurusan', 'mitra', 'guruPembimbing', 'user'])
            ->where('jurusan_id', $jurusan_id)
            ->get();

        return view('siswa.per_jurusan', compact('siswa', 'jurusan'));
    }
}
