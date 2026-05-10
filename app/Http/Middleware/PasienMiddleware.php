<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class PasienMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && auth()->user()->role === 'pasien') {
            return $next($request);
        }
        return redirect()->route('dashboard')
            ->with('error', 'Anda tidak punya akses ke halaman ini!');
    }
}