<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    // 1. Tampilkan Form Ubah Password
    public function editPassword()
    {
        return view('auth.passwords.change');
    }

    // 2. Proses Simpan Password Baru
    public function updatePassword(Request $request)
    {
        // Validasi Input
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed', // 'confirmed' artinya harus sama dengan password_confirmation
        ]);

        // Cek apakah Password Lama benar?
        if (!Hash::check($request->current_password, Auth::user()->password)) {
            return back()->withErrors(['current_password' => 'Password lama tidak sesuai!']);
        }

        // Update Password
        $user = Auth::user(); // Dapatkan user yg sedang login
        // Update password di database (langsung di-hash)
        // Note: Di Laravel modern, $user->update(...) otomatis menghash jika di model ada cast, 
        // tapi cara manual ini lebih aman untuk pemula.
        $user->password = Hash::make($request->password);
        $user->save();

        return back()->with('success', 'Password berhasil diperbarui!');
    }
}