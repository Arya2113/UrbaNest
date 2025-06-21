<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('admin-login'); // blade khusus admin
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $credentials['role'] = 'admin'; // 🧠 Cegah user biasa login dari sini

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('admin.transactions.index'); // ganti sesuai dashboard admin lu
        }

        return back()->withErrors([
            'email' => 'Login gagal. Bukan admin atau data salah.',
        ]);
    }
}
