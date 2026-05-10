<?php

namespace App\Http\Controllers;

use App\Models\Dokter;
use Illuminate\Http\Request;

class DokterController extends Controller
{
    public function index()
    {
        $dokter = Dokter::all();
        return view('admin.dokter.index', compact('dokter'));
    }

    public function create()
    {
        return view('admin.dokter.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'          => 'required',
            'spesialisasi'  => 'required',
            'hari_praktik'  => 'required',
            'jam_praktik'   => 'required',
            'kuota_per_hari'=> 'required|integer',
            'status'        => 'required',
        ]);

        Dokter::create($request->all());
        return redirect()->route('dokter.index')
            ->with('success', 'Data dokter berhasil ditambahkan!');
    }

    public function edit(Dokter $dokter)
    {
        return view('admin.dokter.edit', compact('dokter'));
    }

    public function update(Request $request, Dokter $dokter)
    {
        $request->validate([
            'nama'          => 'required',
            'spesialisasi'  => 'required',
            'hari_praktik'  => 'required',
            'jam_praktik'   => 'required',
            'kuota_per_hari'=> 'required|integer',
            'status'        => 'required',
        ]);

        $dokter->update($request->all());
        return redirect()->route('dokter.index')
            ->with('success', 'Data dokter berhasil diupdate!');
    }

    public function destroy(Dokter $dokter)
    {
        $dokter->delete();
        return redirect()->route('dokter.index')
            ->with('success', 'Data dokter berhasil dihapus!');
    }
}