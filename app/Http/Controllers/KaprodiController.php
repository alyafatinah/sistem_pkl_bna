<?php

namespace App\Http\Controllers;

use App\Models\Kaprod;
use App\Models\User;
use App\Models\Jurusan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class KaprodiController extends Controller
{
    public function index()
    {
        $kaprod = Kaprod::with(['user', 'jurusan'])->get();
        return view('kaprod.index', compact('kaprod'));
    }

    public function create()
    {
        $jurusan = Jurusan::all();
        return view('kaprod.create', compact('jurusan'));
    }

    /**
     * SIMPAN KAPRODI
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'nip' => [
                    'required',
                    'digits:18',
                    'unique:kaprod,nip',
                ],
                'nama_kaprod' => 'required|string|max:255',
                'email' => [
                    'required',
                    'email',
                    'regex:/^[a-zA-Z0-9._%+-]+@gmail\.com$/',
                    'unique:users,email',
                ],
                'alamat' => 'required|string',
                'telp' => 'required|digits_between:10,15',
                'jurusan_id' => 'required|exists:jurusan,id',
            ],
            [
                'nip.required' => 'NIP wajib diisi.',
                'nip.digits' => 'NIP harus terdiri dari 18 digit angka.',
                'nip.unique' => 'NIP sudah terdaftar.',

                'nama_kaprod.required' => 'Nama Kaprodi wajib diisi.',

                'email.required' => 'Email wajib diisi.',
                'email.regex' => 'Email harus menggunakan domain @gmail.com.',
                'email.unique' => 'Email sudah terdaftar.',

                'alamat.required' => 'Alamat wajib diisi.',
                'telp.required' => 'Nomor telepon wajib diisi.',
                'jurusan_id.required' => 'Jurusan wajib dipilih.',
            ]
        );

        // Buat user
        $user = User::create([
            'name' => $request->nama_kaprod,
            'username' => $request->nip,
            'email' => $request->email,
            'password' => Hash::make('kaprod123'),
            'role_id' => 1,
        ]);

        // Buat kaprod
        Kaprod::create([
            'user_id' => $user->id,
            'nip' => $request->nip,
            'nama_kaprod' => $request->nama_kaprod,
            'alamat' => $request->alamat,
            'telp' => $request->telp,
            'jurusan_id' => $request->jurusan_id,
        ]);

        return redirect()
            ->route('kaprod.index')
            ->with('success', 'Data Kepala Program berhasil ditambahkan');
    }

    public function edit($id)
    {
        $kaprod = Kaprod::with('user')->findOrFail($id);
        $jurusan = Jurusan::all();
        return view('kaprod.edit', compact('kaprod', 'jurusan'));
    }

    /**
     * UPDATE KAPRODI
     */
    public function update(Request $request, $id)
    {
        $kaprod = Kaprod::findOrFail($id);

        $request->validate(
            [
                'nama_kaprod' => 'required|string|max:255',
                'email' => [
                    'required',
                    'email',
                    'regex:/^[a-zA-Z0-9._%+-]+@gmail\.com$/',
                    Rule::unique('users', 'email')->ignore($kaprod->user_id),
                ],
                'alamat' => 'required|string',
                'telp' => 'required|digits_between:10,15',
                'jurusan_id' => 'required|exists:jurusan,id',
            ],
            [
                'email.regex' => 'Email harus menggunakan domain @gmail.com.',
            ]
        );

        // update user
        $kaprod->user->update([
            'name' => $request->nama_kaprod,
            'email' => $request->email,
        ]);

        // update kaprod
        $kaprod->update([
            'nama_kaprod' => $request->nama_kaprod,
            'alamat' => $request->alamat,
            'telp' => $request->telp,
            'jurusan_id' => $request->jurusan_id,
        ]);

        return redirect()
            ->route('kaprod.index')
            ->with('success', 'Data Kepala Program berhasil diperbarui');
    }

    public function destroy($id)
    {
        $kaprod = Kaprod::findOrFail($id);

        $kaprod->user()->delete();
        $kaprod->delete();

        return redirect()
            ->route('kaprod.index')
            ->with('success', 'Data Kepala Program berhasil dihapus');
    }
}
