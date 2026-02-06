<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    // 1. Tampil login page
    public function showLoginForm() {
        if (Auth::check()) {
        return redirect()->route('dashboard');
        }
        return view('auth.login');
    }

    // 2. Proses Login
    public function login(Request $request) {
        // validasi form sudah diisi
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        try {
            // validasi username & password->dashboard
            if (Auth::attempt($credentials)) {
            // validasi status user
                if (Auth::user()->status != 'active') {
                    Auth::logout();
                    $request->session()->invalidate();
                    $request->session()->regenerateToken();
                    return back()->withErrors([
                        'username' => 'Akun Anda masih menunggu persetujuan Admin.',
                    ])->onlyInput('username');
                }
                $request->session()->regenerate();
                return to_route('dashboard');
        }

        // return user-> login page jika username/password salah
        return back()->withErrors([
            'username' => 'Maaf, username atau password Anda salah.',
        ])->onlyInput('username');
        } catch (\Exception $e) {
            Log::error("Error Auth User: " . $e->getMessage());
            return back()->with('error', 'Sistem sedang sibuk atau terjadi gangguan. Silakan coba lagi nanti.');
        }
    }

    // 3. Proses logout
    public function logout(Request $request) {
        try {
            // hapus sesi login user
            Auth::logout();

            // destroy data sesi
            $request->session()->invalidate();

            // regenerate csrf token
            $request->session()->regenerateToken();

            // redirect->login page
            return to_route('login');
        } catch (\Exception $e) {
            Log::error("Error Logout User: " . $e->getMessage());
            return to_route('login');
        }
    }
}
