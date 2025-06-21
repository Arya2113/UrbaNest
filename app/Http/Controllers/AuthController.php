<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showSignupForm()
    {
        if (Auth::check()) {
            return redirect('/');
        }
        return view('signup');
    }

    public function signup(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:20|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ]);

        // Optional: Log the user in after registration
        // Auth::login($user);

        return redirect('/login')->with('success', 'Registration successful! Please login.');
    }

    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect('/');
        }
        return view('login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        // Tambahkan role: hanya 'user' yang boleh login via form ini
        $credentials['role'] = 'user';

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->route('home'); // karena ini form user
        }

        // if (Auth::attempt($credentials)) {
        //     $request->session()->regenerate();

        //     return redirect()->intended('/'); // Redirect to the intended page or home
        // }
        

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }
}
