<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ArchitectAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('architect-login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials['role'] = 'architect';

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('architect.dashboard');
        }

        return back()->withErrors(['email' => 'Login gagal. Bukan architect atau data salah.']);
    }
}
