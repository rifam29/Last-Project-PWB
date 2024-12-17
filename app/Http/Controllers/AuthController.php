<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{
    Role,
    User,
};
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function viewlogin(Request $request)
    {
        return view('auth.login');
    }

    // Handle user registration
    public function register(Request $request)
    {
        // Cek apakah user yang login memiliki role admin
        if (!Auth::user() || Auth::user()->role->name !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'role' => 'required|in:admin,petugas',
        ]);

        // Tentukan role_id berdasarkan pilihan role
        $roleId = $request->role === 'admin' ? 1 : 2;

        // Buat user baru dengan role_id yang sesuai
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $roleId, // Simpan role_id
        ]);

        // Login otomatis ke akun yang baru dibuat
        Auth::login($user);

        // Redirect ke dashboard atau halaman lain
        return redirect()->route('dashboard')->with('success', 'Registration successful and logged in as the new user!');
    }

    // Handle user login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            $request->session()->regenerate();

            return redirect()->route('dashboard')->with([
                'success' => 'Login successful. Welcome to your dashboard!',
            ]);
        }

        return back()->withErrors([
            'email' => 'Invalid email or password.',
        ])->withInput();
    }

    // Handle logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate(); // Hancurkan sesi
        $request->session()->regenerateToken(); // Regenerasi token CSRF

        return redirect()->route('auth.login')->with('success', 'You have been logged out successfully.');
    }
}
