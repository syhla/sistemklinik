<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate(); 
            $user = Auth::user();

            switch ($user->role) {
                case 'resepsionis':
                    return redirect()->route('resepsionis.dashboard');
                case 'dokter_umum':
                    return redirect()->route('dokter.dokterumum');
                case 'dokter_gigi':
                    return redirect()->route('dokter.doktergigi');
                case 'bidan':
                    return redirect()->route('dokter.bidan');
                case 'apoteker':
                    return redirect()->route('apoteker.dashboard');
                default: 
                    Auth::logout();
                    return redirect('/login')->withErrors([
                        'role' => 'Role tidak dikenali!',
                    ]);
            }
        }

        return back()->withErrors([
            'email' => 'Email atau password salah!',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
