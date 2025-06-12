<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserProfileController extends Controller
{
    // Menampilkan profil pengguna
    public function show()
    {
        return view('profileShow', ['user' => Auth::user()]);
    }

    // Menampilkan halaman edit profil
    public function edit()
    {
        return view('profileEdit', ['user' => Auth::user()]);
    }

    // Memproses pembaruan profil pengguna
    public function update(Request $request)
    {
        $user = Auth::user();
        $user->update($request->all());

        return redirect()->route('profileShow')->with('status', 'Profile updated!');
    }

    // Menampilkan halaman untuk mengubah password
    public function showPasswordForm()
    {
        return view('profilePassword');
    }

    // Memproses pembaruan password pengguna
    public function updatePassword(Request $request)
    {
        $user = Auth::user();
        $user->update(['password' => bcrypt($request->password)]);

        return redirect()->route('profileShow')->with('status', 'Password updated!');
    }
}
