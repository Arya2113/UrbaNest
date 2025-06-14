<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserProfileController extends Controller
{
    // Tampilkan profil
    public function show()
    {
        $user = Auth::user();
        return view('profileShow', compact('user'));
    }

    // Form edit profil
    public function edit()
    {
        $user = Auth::user();
        return view('profileEdit', compact('user'));
    }

    // Proses update profil
    public function update(Request $request)
    {
        $user = Auth::user();
    
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'bio' => 'nullable|string|max:1000',
            'address' => 'nullable|string|max:255',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        // Jika upload avatar
        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
        } else {
            $avatarPath = $user->avatar;
        }
    
        // Update data
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'bio' => $request->bio,
            'address' => $request->address,
            'avatar' => $avatarPath,
        ]);
    
        return redirect()->route('profile.show')->with('success', 'Profil berhasil diperbarui!');
    }
    

    // Form ganti password
    public function editPassword()
    {
        return view('profilePassword');
    }

    // Proses ganti password
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();

        // Cek apakah current password cocok
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password lama tidak cocok.']);
        }

        // Update password
        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return redirect()->route('profile.show')->with('success', 'Password berhasil diperbarui!');
    }
}
