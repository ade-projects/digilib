<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index() {
        $members = Member::latest()->get();
        return view('members.index', compact('members'));
    }

    public function store(Request $request) {
        $request->validate([
            'nim' => 'required|numeric|unique:members,nim', 
            'name' => 'required|string|max:255',
            'phone' => 'nullable|numeric',
            'address' => 'nullable|string',
        ], [
            'nim.unique' => 'NIM ini sudah terdaftar!',
            'nim.numeric' => 'NIM harus berupa angka!',
        ]);

        Member::create($request->all());

        return back()->with('success', 'Anggota berhasil ditambahkan.');
    }

    public function update(Request $request, Member $member) {
        $request->validate([
            'nim' => 'required|numeric|unique:members,nim,' . $member->id,
            'name' => 'required|string|max:255',
            'phone' => 'nullable|numeric',
            'address' => 'nullable|string',
        ]);

        $member->update($request->all());

        return back()->with('success', 'Data anggota berhasil diperbarui.');
    }

    public function destroy(Member $member) {
        try {
            $member->delete();
            return back()->with('success', 'Anggota berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus data.');
        }
    }
}
