<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserProfileController extends Controller
{
     
    public function show()
    {
        $user = Auth::user();
        return view('profileShow', compact('user'));
    }

     
    public function edit()
    {
        $user = Auth::user();
        return view('profileEdit', compact('user'));
    }

     
    public function update(Request $request)
    {
        $user = Auth::user();
    
         
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
        ]);
    
        
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone, 
            'address' => $request->address,
        ]);
    
        return redirect()->route('profile.show')->with('success', 'Profil berhasil diperbarui!');
    }
    

     
    public function editPassword()
    {
        return view('profilePassword');
    }

     
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();

         
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password lama tidak cocok.']);
        }

         
        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return redirect()->route('profile.show')->with('success', 'Password berhasil diperbarui!');
    }
}
