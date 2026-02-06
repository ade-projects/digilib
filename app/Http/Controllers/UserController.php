<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function index() {
        try {
            // 1. Hitung data untuk small box
            $active = User::where('status', 'active')->count();
            $pending = User::where('status', 'pending')->count();
            $banned = User::where('status', 'banned')->count();
    
            // 2. Ambil semua data user
            $users = User::latest()->get();
    
            // 3. Kirim data ke view
            return view('users.index', compact('users', 'active', 'pending', 'banned'));

        } catch (\Exception $e) {
            Log::error("Error Index User: " . $e->getMessage());
            return redirect()->route('dashboard')->with('error', 'Gagal memuat data pengguna. Silakan coba lagi.');
        }
    }

    public function update(Request $request, $id) {
        
        // validasi 
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'role' => ['required', 'in:admin,staff'],
            'status' => ['required', 'in:active,pending,banned'],
            'password' => [
                'nullable', // value boleh kosong
                'confirmed',
                // jika diisi, harus ikut aturan ini
                \Illuminate\Validation\Rules\Password::min(8)->letters()->numbers()->symbols(),
                ],
                ], [
                    // custom error messages
                    'password.min' => 'Password minimal harus 8 karakter.',
                    'password.confirmed' => 'Konfirmasi password tidak cocok.',
                    'password' => 'Password harus mengandung huruf, angka, dan simbol.',
                 ]);

        try {
            // cari user
            $user = User::findOrFail($id);
            
            // update data
            $data = [
                'name' => $request->name,
                'role' => $request->role,
                'status' => $request->status,
            ];

            // cek jika password diisi (ganti password)
            if ($request->filled('password')) {
                $data['password'] = bcrypt($request->password);
            }

            $user->update($data);
    
            return redirect()->route('users.index')->with('success', 'Data pengguna berhasil diperbarui.');

        } catch (\Exception $e) {
            Log::error("Error Update User: " . $e->getMessage());
            return back()->with('error', 'Gagal memperbarui data. Silakan coba lagi.');
        }
    }

    public function store(Request $request) {
        // Validasi input
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'min:5', 'max:20', 'unique:users'],
            'role' => ['required', 'in:admin,staff'],
            'status' => ['required', 'in:active,pending,banned'],
            'password' => ['required', 'confirmed',
                \Illuminate\Validation\Rules\Password::min(8)
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
        
        try {
            // 2. simpan->database
            User::create([
                'name' => $request->name,
                'username' => strtolower($request->username),
                'role' => $request->role,
                'status' => $request->status,
                'password' => Hash::make($request->password),
            ]);

            // 3. Redirect kembali->login page
                return redirect()->route('users.index')->with('success', 'User baru berhasil ditambahkan.');
                
        } catch (\Exception $e) {
            Log::error("Error Store User: " . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan sistem. Data gagal disimpan.');
        }
    }

    public function destroy($id) {
        try {
            //destroy data
            $user = User::findOrFail($id);
            $user->delete();

            return redirect()->route('users.index')->with('success', 'Pengguna berhasil dihapus.');

        } catch (\Exception $e) {
            Log::error("Error Destroy User: " . $e->getMessage());
            return back()->with('error', 'Gagal menghapus data. Terjadi kesalahan sistem');
        }
    }
}


