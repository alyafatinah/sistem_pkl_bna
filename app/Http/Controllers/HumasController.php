<?php

namespace App\Http\Controllers;

use App\Models\Humas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class HumasController extends Controller
{
    /**
     * ADMIN & HUMAS
     * Menampilkan data humas
     */

    public function index()
    {
        // HANYA ADMIN
        if (Auth::user()->role_id !== 5) {
            abort(403);
        }

        $humas = Humas::with('user')->get();

        return view('humas.index', compact('humas'));
    }


    /**
     * ADMIN ONLY
     * Form tambah humas
     */
    public function create()
    {
        if (Auth::user()->role_id !== 5) {
            abort(403);
        }

        return view('humas.create');
    }

    /**
     * ADMIN ONLY
     * Simpan user + data humas
     */
    public function store(Request $request)
    {
        if (Auth::user()->role_id !== 5) {
            abort(403);
        }

        $request->validate([
            'nama_humas' => 'required|string|max:100',
            'username'   => 'required|string|max:50|unique:users,username',
            'email'      => 'required|email|max:100|unique:users,email',
            'nip'        => 'nullable|string|max:30',
            'alamat'     => 'required|string',
            'telp'       => 'required|string|max:20',
        ]);

        // 1️⃣ Buat user HUMAS
        $user = User::create([
            'name'     => $request->nama_humas,
            'username' => $request->username,
            'email'    => $request->email,
            'password' => Hash::make('humas123'),
            'role_id'  => 2, // HUMAS
        ]);

        // 2️⃣ Buat data HUMAS
        Humas::create([
            'user_id'    => $user->id,
            'nip'        => $request->nip,
            'nama_humas' => $request->nama_humas,
            'alamat'     => $request->alamat,
            'telp'       => $request->telp,
        ]);

        return redirect()
            ->route('humas.index')
            ->with('success', 'Data Humas berhasil ditambahkan');
    }

    /**
     * HUMAS ONLY
     * Edit data sendiri
     */
    public function edit($id)
    {
        if (Auth::user()->role_id !== 2) {
            abort(403);
        }

        $humas = Humas::with('user')
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('humas.edit', compact('humas'));
    }


    /**
     * HUMAS ONLY
     * Update data sendiri
     */
    public function update(Request $request, $id)
    {
        if (Auth::user()->role_id !== 2) {
            abort(403);
        }

        $humas = Humas::with('user')
            ->where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // VALIDASI
        $request->validate([
            'username'   => 'required|string|max:50|unique:users,username,' . $humas->user->id,
            'email'      => 'required|email|max:100|unique:users,email,' . $humas->user->id,
            'nip'        => 'nullable|string|max:30',
            'nama_humas' => 'required|string|max:100',
            'alamat'     => 'required|string',
            'telp'       => 'required|string|max:20',
        ]);

        // 1️⃣ UPDATE DATA USER
        $humas->user->update([
            'username' => $request->username,
            'email'    => $request->email,
            'name'     => $request->nama_humas, // sinkron
        ]);

        // 2️⃣ UPDATE DATA HUMAS
        $humas->update([
            'nip'        => $request->nip,
            'nama_humas' => $request->nama_humas,
            'alamat'     => $request->alamat,
            'telp'       => $request->telp,
        ]);

        if (Auth::user()->role_id == 5) {
            return redirect()
                ->route('humas.index')
                ->with('success', 'Profil humas & akun berhasil diperbarui');
        }
        if (Auth::user()->role_id == 2) {
            return redirect()
                ->route('humas.index-humas')
                ->with('success', 'Profil humas & akun berhasil diperbarui');
        }
    }

    public function indexHumas()
    {
        if (Auth::user()->role_id !== 2) {
            abort(403);
        }

        $humas = Humas::with('user')
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('humas.index-humas', compact('humas'));
    }
}
