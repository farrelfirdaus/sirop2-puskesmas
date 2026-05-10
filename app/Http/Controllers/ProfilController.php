<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfilController extends Controller
{
    public function show()
    {
        return view('pasien.lengkapi-profil');
    }

    public function simpan(Request $request)
    {
        $request->validate([
            'nik'                 => 'required|string|max:20|unique:users,nik',
            'tempat_lahir'        => 'required|string',
            'tanggal_lahir'       => 'required|date',
            'alamat'              => 'required|string',
            'no_hp'               => 'required|string|max:15',
            'agama'               => 'required|string',
            'pendidikan_terakhir' => 'required|string',
            'pekerjaan'           => 'required|string',
            'golongan_darah'      => 'required|string',
        ]);

        Auth::user()->update([
            'nik'                 => $request->nik,
            'tempat_lahir'        => $request->tempat_lahir,
            'tanggal_lahir'       => $request->tanggal_lahir,
            'alamat'              => $request->alamat,
            'no_hp'               => $request->no_hp,
            'agama'               => $request->agama,
            'pendidikan_terakhir' => $request->pendidikan_terakhir,
            'pekerjaan'           => $request->pekerjaan,
            'golongan_darah'      => $request->golongan_darah,
            'profil_lengkap'      => true,
        ]);

        return redirect()->route('pasien.dashboard')
            ->with('success', 'Profil berhasil dilengkapi!');
    }

    public function edit()
    {
        $user = Auth::user();
        return view('pasien.edit-profil', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'nik'                 => 'required|string|max:20|unique:users,nik,'.$user->id,
            'tempat_lahir'        => 'required|string',
            'tanggal_lahir'       => 'required|date',
            'alamat'              => 'required|string',
            'no_hp'               => 'required|string|max:15',
            'agama'               => 'required|string',
            'pendidikan_terakhir' => 'required|string',
            'pekerjaan'           => 'required|string',
            'golongan_darah'      => 'required|string',
        ]);

        $user->update($request->only([
            'nik', 'tempat_lahir', 'tanggal_lahir', 'alamat',
            'no_hp', 'agama', 'pendidikan_terakhir', 'pekerjaan', 'golongan_darah'
        ]));

        return redirect()->route('profil.edit')
            ->with('success', 'Profil berhasil diupdate!');
    }
}