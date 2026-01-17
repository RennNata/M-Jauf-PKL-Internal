<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        // Mengambil semua user, diurutkan dari yang terbaru
        // Kita gunakan paginate agar jika user sudah ribuan, web tidak berat
        $users = User::latest()->paginate(10);
        
        return view('admin.users.index', compact('users'));
    }

    public function destroy(User $user)
    {
        // Proteksi: Admin tidak boleh menghapus dirinya sendiri
        if (auth()->id() === $user->id) {
            return back()->with('error', 'Anda tidak bisa menghapus akun sendiri!');
        }

        $user->delete();
        return back()->with('success', 'Pengguna berhasil dihapus.');
    }
}