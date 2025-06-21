<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('admin-login');  
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $credentials['role'] = 'admin';  

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('admin.transactions.index');  
        }

        return back()->withErrors([
            'email' => 'Login gagal. Bukan admin atau data salah.',
        ]);
    }
}
