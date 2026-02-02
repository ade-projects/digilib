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
}
