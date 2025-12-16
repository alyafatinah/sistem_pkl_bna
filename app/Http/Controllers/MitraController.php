<?php

namespace App\Http\Controllers;

use App\Models\Mitra;
use Illuminate\Http\Request;

class MitraController extends Controller
{
    public function index()
    {
        $mitra = Mitra::all();
        return view('mitra.index', compact('mitra'));
    }

    public function create()
    {
        return view('mitra.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_mitra' => 'required',
            'bidang' => 'required',
            'alamat' => 'required',
            'pl' => 'required',
            'telp' => 'required'
        ]);

        Mitra::create($request->all());

        return redirect()->route('mitra.index')
            ->with('success', 'Data Mitra berhasil ditambahkan');
    }

    public function edit($id)
    {
        $mitra = Mitra::findOrFail($id);
        return view('mitra.edit', compact('mitra'));
    }

    public function update(Request $request, $id)
    {
        $mitra = Mitra::findOrFail($id);

        $request->validate([
            'nama_mitra' => 'required',
            'bidang' => 'required',
            'alamat' => 'required',
            'pl' => 'required',
            'telp' => 'required'
        ]);

        $mitra->update($request->all());

        return redirect()->route('mitra.index')
            ->with('success', 'Data Mitra berhasil diperbarui');
    }

    public function destroy($id)
    {
        $mitra = Mitra::findOrFail($id);
        $mitra->delete();

        return redirect()->route('mitra.index')
            ->with('success', 'Data Mitra berhasil dihapus');
    }
}
