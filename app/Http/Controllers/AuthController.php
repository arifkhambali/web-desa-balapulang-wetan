<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->role === 'warga') {
                return redirect()->intended('/warga');
            }
            if (in_array($user->role, ['admin', 'kades'])) {
                return redirect()->intended('/admin');
            }
            return redirect()->intended('/');
        }

        // Data Social Proof
        $totalPenduduk = \App\Models\Penduduk::count();
        $latestWarga = \App\Models\Penduduk::inRandomOrder()->limit(3)->get();

        return view('auth.login', compact('totalPenduduk', 'latestWarga'));
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();

            if (in_array($user->role, ['admin', 'kades'])) {
                return redirect()->intended('/admin');
            }

            if ($user->role === 'warga') {
                return redirect()->intended('/warga');
            }

            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
