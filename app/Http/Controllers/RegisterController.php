<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    //1. Tampil form register
    public function showRegistrationForm() {
        return view('auth.register');
    }

    // 2. Proses data register
    public function register(Request $request) {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'min:5', 'max:20', 'unique:users'],
            'password' => [
                'required',
                'confirmed',
                Password::min(8)
                    ->letters()
                    ->numbers()
                    ->symbols(),
            ],
        ], [
            // custom error messages
            'username.min' => 'Username minimal harus 5 karakter.',
            'username.unique' => 'Username ini sudah digunakan.',
            'password.min' => 'Password minimal harus 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password' => 'Password harus mengandung huruf, angka, dan simbol.',
        ]);

        // Buat user baru
        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => 'staff',
            'status' => 'pending',
        ]);

        // redirect user->login page
        return redirect()->route('login')->with('success', 'Registrasi berhasil! Mohon tunggu persetujuan Admin untuk login.');
    }
}
