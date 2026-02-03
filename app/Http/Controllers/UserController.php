<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index() {
        // 1. Hitung data untuk small box
        $active = User::where('status', 'active')->count();
        $pending = User::where('status', 'pending')->count();
        $banned = User::where('status', 'banned')->count();

        // 2. Ambil semua data user
        $users = User::latest()->get();

        // 3. Kirim data ke view
        return view('users.index', compact('users', 'active', 'pending', 'banned'));
    }

    public function update(Request $request, $id) {
        // cari user
        $user = User::findOrFail($id);
        
        // validasi simpel
        $request->validate([
            'name' => 'required',
            'role' => 'required',
            'status' => 'required',
        ]);

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
    }

    //destroy data
    public function destroy($id) {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index')->with('success', 'Pengguna berhasil dihapus.');
    }
}
