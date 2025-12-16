<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\Jurusan;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    public function index()
    {
        $jadwal = Jadwal::with('jurusan')->get();
        return view('jadwal.index', compact('jadwal'));
    }

    public function create()
    {
        $jurusan = Jurusan::all();
        return view('jadwal.create', compact('jurusan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'angkatan'    => 'required',
            'jurusan_id'  => 'required|exists:jurusan,id',
            'pembekalan'  => 'required|date',
            'pengantaran' => 'required|date',
            'monitoring'  => 'required|date',
            'penjemputan' => 'required|date',
        ]);

        Jadwal::create($request->all());

        return redirect()->route('jadwal.index')
            ->with('success', 'Data berhasil disimpan');
    }

    public function edit($id)
    {
        $jadwal  = Jadwal::findOrFail($id);
        $jurusan = Jurusan::all();

        return view('jadwal.edit', compact('jadwal', 'jurusan'));
    }

    public function update(Request $request, $id)
    {
        $jadwal = Jadwal::findOrFail($id);

        $request->validate([
            'angkatan'    => 'required',
            'jurusan_id'  => 'required|exists:jurusan,id',
            'pembekalan'  => 'required|date',
            'pengantaran' => 'required|date',
            'monitoring'  => 'required|date',
            'penjemputan' => 'required|date',
        ]);

        $jadwal->update($request->all());

        return redirect()->route('jadwal.index')
            ->with('success', 'Data berhasil diperbarui');
    }

    public function destroy($id)
    {
        Jadwal::findOrFail($id)->delete();

        return redirect()->route('jadwal.index')
            ->with('success', 'Data berhasil dihapus');
    }
}
