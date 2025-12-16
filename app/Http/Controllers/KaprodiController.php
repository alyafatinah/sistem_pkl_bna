<?php

namespace App\Http\Controllers;

use App\Models\Kaprod;
use App\Models\User;
use App\Models\Jurusan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class KaprodiController extends Controller
{
    /**
     * Menampilkan data Kepala Program Studi
     */
    public function index()
    {
        $kaprod = Kaprod::with(['user', 'jurusan'])->get();

        return view('kaprod.index', compact('kaprod'));
    }

    /**
     * Form tambah Kaprod
     * (hanya humas)
     */
    public function create()
    {
        $jurusan = Jurusan::all();

        return view('kaprod.create', compact('jurusan'));
    }

    /**
     * Simpan data Kaprod + akun user
     */
    public function store(Request $request)
    {
        $request->validate([
            'nip'        => 'required|unique:kaprod,nip',
            'nama_kaprod' => 'required',
            'email'      => 'required|email|unique:users,email',
            'alamat'     => 'required',
            'telp'       => 'required',
            'jurusan_id' => 'required',
        ]);

        // 1️⃣ Buat akun user Kaprod
        $user = User::create([
            'name'     => $request->nama_kaprod,
            'username' => $request->nip,
            'email'    => $request->email,
            'password' => Hash::make('kaprod123'),
            'role_id'  => 1, // role Kaprod
        ]);

        // 2️⃣ Simpan data Kaprod
        Kaprod::create([
            'user_id'    => $user->id,
            'nip'        => $request->nip,
            'nama_kaprod' => $request->nama_kaprod,
            'alamat'     => $request->alamat,
            'telp'       => $request->telp,
            'jurusan_id' => $request->jurusan_id,
        ]);

        return redirect()->route('kaprod.index')
            ->with('success', 'Data Kepala Program berhasil ditambahkan');
    }

    /**
     * Form edit Kaprod
     */
    public function edit($id)
    {
        $kaprod  = Kaprod::with('user')->findOrFail($id);
        $jurusan = Jurusan::all();

        return view('kaprod.edit', compact('kaprod', 'jurusan'));
    }

    /**
     * Update data Kaprod + email user
     */
    public function update(Request $request, $id)
    {
        $kaprod = Kaprod::findOrFail($id);

        $request->validate([
            'nama_kaprod' => 'required',
            'email'      => 'required|email|unique:users,email,' . $kaprod->user_id,
            'alamat'     => 'required',
            'telp'       => 'required',
            'jurusan_id' => 'required',
        ]);

        // update akun user
        $kaprod->user->update([
            'name'  => $request->nama_kaprod,
            'email' => $request->email,
        ]);

        // update data kaprod
        $kaprod->update([
            'nama_kaprod' => $request->nama_kaprod,
            'alamat'     => $request->alamat,
            'telp'       => $request->telp,
            'jurusan_id' => $request->jurusan_id,
        ]);

        return redirect()->route('kaprod.index')
            ->with('success', 'Data Kepala Program berhasil diperbarui');
    }

    /**
     * Hapus Kaprod + akun user
     */
    public function destroy($id)
    {
        $kaprod = Kaprod::findOrFail($id);

        // hapus user login
        $kaprod->user()->delete();
        $kaprod->delete();

        return redirect()->route('kaprod.index')
            ->with('success', 'Data Kepala Program berhasil dihapus');
    }
}
