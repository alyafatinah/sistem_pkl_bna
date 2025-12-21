<?php

namespace App\Http\Controllers;

use App\Models\GuruPembimbing;
use App\Models\User;
use App\Models\Jurusan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class GuruPembimbingController extends Controller
{
    public function index()
    {
        $guruPembimbing = GuruPembimbing::with('jurusan')->get();
        return view('guruPembimbing.index', compact('guruPembimbing'));
    }

    public function create()
    {
        $jurusan = Jurusan::all();
        return view('guruPembimbing.create', compact('jurusan'));
    }

    public function store(Request $request)
    {
        // ✅ VALIDASI BENAR
        $request->validate(
            [
                'nip' => [
                    'required',
                    'digits:18',
                    'unique:gurupembimbing,nip',
                ],
                'nama_guru' => 'required|string|max:255',
                'bidang' => 'required|string|max:100',
                'email' => [
                    'required',
                    'email',
                    'regex:/^[a-zA-Z0-9._%+-]+@gmail\.com$/',
                    'unique:users,email',
                ],
                'jurusan_id' => 'required|exists:jurusan,id',
                'telp' => 'required|digits_between:10,15',
            ],
            [
                'nip.required' => 'NIP wajib diisi.',
                'nip.digits' => 'NIP harus terdiri dari 18 digit angka.',
                'nip.unique' => 'NIP sudah terdaftar.',

                'nama_guru.required' => 'Nama guru wajib diisi.',
                'bidang.required' => 'Bidang keahlian wajib diisi.',

                'email.required' => 'Email wajib diisi.',
                'email.regex' => 'Email harus menggunakan domain @gmail.com.',
                'email.unique' => 'Email sudah terdaftar.',

                'jurusan_id.required' => 'Jurusan wajib dipilih.',
                'telp.required' => 'Nomor telepon wajib diisi.',
            ]
        );

        // ✅ BUAT USER
        $user = User::create([
            'name' => $request->nama_guru,
            'username' => $request->nip,
            'email' => $request->email,
            'password' => Hash::make('guru123'),
            'role_id' => 3, // guru pembimbing
        ]);

        // ✅ BUAT GURU PEMBIMBING
        GuruPembimbing::create([
            'user_id' => $user->id,
            'nip' => $request->nip,
            'nama_guru' => $request->nama_guru,
            'bidang' => $request->bidang,
            'jurusan_id' => $request->jurusan_id,
            'telp' => $request->telp,
        ]);

        return redirect()
            ->route('guruPembimbing.index')
            ->with('success', 'Guru Pembimbing berhasil ditambahkan');
    }

    public function edit(GuruPembimbing $guruPembimbing)
    {
        $jurusan = Jurusan::all();
        return view('guruPembimbing.edit', compact('guruPembimbing', 'jurusan'));
    }

    public function update(Request $request, GuruPembimbing $guruPembimbing)
    {
        $request->validate([
            'nama_guru' => 'required|string|max:255',
            'bidang' => 'required|string|max:100',
            'jurusan_id' => 'required|exists:jurusan,id',
            'telp' => 'required|digits_between:10,15',
        ]);

        $guruPembimbing->update([
            'nama_guru' => $request->nama_guru,
            'bidang' => $request->bidang,
            'jurusan_id' => $request->jurusan_id,
            'telp' => $request->telp,
        ]);

        // update nama di tabel users
        $guruPembimbing->user->update([
            'name' => $request->nama_guru,
        ]);

        return redirect()
            ->route('guruPembimbing.index')
            ->with('success', 'Data guru berhasil diperbarui');
    }

    public function destroy(GuruPembimbing $guruPembimbing)
    {
        // hapus user → guru ikut terhapus via FK / logika aplikasi
        $guruPembimbing->user->delete();

        return back()->with('success', 'Guru Pembimbing berhasil dihapus');
    }

    public function guruPerJurusan($id)
    {
        $user = Auth::user();

        if (!$user || !$user->kaprod) {
            abort(403, 'Akses ditolak');
        }

        $jurusanId = $user->kaprod->jurusan_id;

        if ((int) $id !== (int) $jurusanId) {
            abort(403, 'Anda tidak berhak mengakses jurusan ini');
        }

        $jurusan = Jurusan::findOrFail($id);

        $guruPembimbing = GuruPembimbing::with('jurusan')
            ->where('jurusan_id', $id)
            ->get();

        return view('guruPembimbing.per_jurusan', compact('guruPembimbing', 'jurusan'));
    }
}
