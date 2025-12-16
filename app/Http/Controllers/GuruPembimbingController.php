<?php

namespace App\Http\Controllers;

use App\Models\GuruPembimbing;
use App\Models\User;
use App\Models\Jurusan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
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
        $request->validate([
            'nip'        => 'required|unique:guruPembimbing,nip',
            'nama_guru'  => 'required',
            'bidang'     => 'required',
            'email'      => 'required|email|unique:users,email',
            'jurusan_id' => 'required',
            'telp'       => 'required',
        ]);

        $user = User::create([
            'name'     => $request->nama_guru,
            'username' => $request->nip,
            'email'    => $request->email,
            'password' => Hash::make('guru123'),
            'role_id'  => 3,
        ]);

        GuruPembimbing::create([
            'user_id'    => $user->id,
            'nip'        => $request->nip,
            'nama_guru'  => $request->nama_guru,
            'bidang'     => $request->bidang,
            'jurusan_id' => $request->jurusan_id,
            'telp'       => $request->telp,
        ]);

        return redirect()->route('guruPembimbing.index')->with('success', 'Guru Pembimbing berhasil ditambahkan');
    }

    public function edit(GuruPembimbing $guruPembimbing)
    {
        $jurusan = Jurusan::all();
        return view('guruPembimbing.edit', compact('guruPembimbing', 'jurusan'));
    }

    public function update(Request $request, GuruPembimbing $guruPembimbing)
    {
        $request->validate([
            'nama_guru'  => 'required',
            'bidang'    => 'required',
            'jurusan_id' => 'required',
            'telp'       => 'required',
        ]);

        $guruPembimbing->update($request->only('nama_guru', 'bidang', 'jurusan_id', 'telp'));
        $guruPembimbing->user->update(['name' => $request->nama_guru]);

        return redirect()->route('guruPembimbing.index')->with('success', 'Data guru diperbarui');
    }

    public function destroy(GuruPembimbing $guruPembimbing)
    {
        $guruPembimbing->user->delete(); // otomatis hapus guru juga
        return back()->with('success', 'Guru Pembimbing dihapus');
    }




    public function guruPerJurusan($id)
    {
        $user = Auth::user();

        // pastikan kaprodi
        if (!$user || !$user->kaprod) {
            abort(403, 'Akses ditolak');
        }

        // ambil jurusan kaprodi
        $jurusanId = $user->kaprod->jurusan_id;

        // cegah akses jurusan lain via URL
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
