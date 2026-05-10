<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();

            if ($user->role === 'admin') {
                return redirect()->route('dashboard');
            }

            // Cek apakah profil pasien sudah lengkap
            if (!$user->profil_lengkap) {
                return redirect()->route('profil.lengkapi');
            }

            return redirect()->route('pasien.dashboard');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah!',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('login');
    }
}