<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PasienController extends Controller
{
    public function index()
    {
        $pasien = DB::table('pasien')->get();
        return view('pasien.index', compact('pasien'));
    }

    public function create()
    {
        return view('pasien.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nik'                => 'required|string|max:20|unique:pasien,nik',
            'nama'               => 'required|string|max:255',
            'tempat_lahir'       => 'required|string|max:255',
            'tanggal_lahir'      => 'required|date',
            'alamat'             => 'required|string',
            'no_hp'              => 'required|string|max:15',
            'agama'              => 'required|string|max:50',
            'pendidikan_terakhir'=> 'required|string|max:50',
            'pekerjaan'          => 'required|string|max:100',
            'golongan_darah'     => 'required|string|max:5',
        ]);

        DB::table('pasien')->insert([
            'nik'                => $request->nik,
            'nama'               => $request->nama,
            'tempat_lahir'       => $request->tempat_lahir,
            'tanggal_lahir'      => $request->tanggal_lahir,
            'alamat'             => $request->alamat,
            'no_hp'              => $request->no_hp,
            'agama'              => $request->agama,
            'pendidikan_terakhir'=> $request->pendidikan_terakhir,
            'pekerjaan'          => $request->pekerjaan,
            'golongan_darah'     => $request->golongan_darah,
            'created_at'         => now(),
            'updated_at'         => now(),
        ]);

        return redirect()->route('pasien.index')->with('success', 'Data pasien berhasil ditambahkan!');
    }

    public function edit(string $id)
    {
        $pasien = DB::table('pasien')->where('nik', $id)->first();
        return view('pasien.edit', compact('pasien'));
    }

    public function update(Request $request, string $id)
    {
        DB::table('pasien')->where('nik', $id)->update([
            'nama'               => $request->nama,
            'tempat_lahir'       => $request->tempat_lahir,
            'tanggal_lahir'      => $request->tanggal_lahir,
            'alamat'             => $request->alamat,
            'no_hp'              => $request->no_hp,
            'agama'              => $request->agama,
            'pendidikan_terakhir'=> $request->pendidikan_terakhir,
            'pekerjaan'          => $request->pekerjaan,
            'golongan_darah'     => $request->golongan_darah,
            'updated_at'         => now(),
        ]);

        return redirect()->route('pasien.index')->with('success', 'Data pasien berhasil diupdate!');
    }

    public function destroy(string $id)
    {
        DB::table('pasien')->where('nik', $id)->delete();
        return redirect()->route('pasien.index')->with('success', 'Data pasien berhasil dihapus!');
    }
}