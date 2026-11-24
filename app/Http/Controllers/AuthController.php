<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login', ['isAdmin' => false]);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required' => 'Email kampus wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Kata sandi wajib diisi.',
        ]);

        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            $request->session()->forget('url.intended');

            // Jika yang login adalah akun admin, arahkan langsung ke ringkasan admin
            if ($this->isAdminUser(Auth::user())) {
                return redirect()->route('admin.ringkasan');
            }

            return redirect()->route('dashboard');
        }

        return back()->withErrors([
            'email' => 'Email atau kata sandi yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    public function showAdminLoginForm()
    {
        return view('auth.login', ['isAdmin' => true]);
    }

    public function adminLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required' => 'Email admin wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Kata sandi wajib diisi.',
        ]);

        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            $request->session()->forget('url.intended');

            // Aktifkan blok ini jika kamu ingin membatasi login /admin/login hanya untuk akun admin:
            // if (! $this->isAdminUser(Auth::user())) {
            //     Auth::logout();
            //     $request->session()->invalidate();
            //     $request->session()->regenerateToken();
            //
            //     return back()->withErrors([
            //         'email' => 'Akun ini bukan akun admin.',
            //     ])->onlyInput('email');
            // }

            return redirect()->route('admin.ringkasan');
        }

        return back()->withErrors([
            'email' => 'Akun admin tidak ditemukan atau kata sandi salah.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    protected function isAdminUser($user): bool
    {
        if (! $user) {
            return false;
        }

        if (isset($user->role) && strtolower((string) $user->role) === 'admin') {
            return true;
        }

        return strtolower((string) $user->email) === 'admin@kampus.ac.id';
    }
}