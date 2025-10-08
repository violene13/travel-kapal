<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    // =============================
    // FORM LOGIN
    // =============================
    public function showLoginForm()
    {
        return view('login'); // resources/views/login.blade.php
    }

    // =============================
    // PROSES LOGIN
    // =============================
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        // =============================
        // LOGIN ADMIN TRAVEL
        // =============================
        if ($request->username === 'Adminskapal' && $request->password === 'Trvl0010') {
            $request->session()->put('role', 'travel');
            return redirect()->route('admin.travel.dashboard');
        }

        // =============================
        // LOGIN ADMIN PELAYARAN
        // =============================
        if ($request->username === 'PelayaranLaut' && $request->password === 'Pelkapal01') {
            $request->session()->put('role', 'pelayaran');
            return redirect()->route('admin.pelayaran.dashboard');
        }

        // =============================
        // LOGIN PENUMPANG
        // =============================
        if ($request->username === 'Penumpang' && $request->password === 'Penumpang01') {
            $request->session()->put('role', 'penumpang');
            return redirect()->route('penumpang.dashboard');
        }

        // =============================
        // LOGIN GAGAL
        // =============================
        return back()->withErrors([
            'login_error' => 'Username atau Password salah!'
        ])->withInput();
    }

    // =============================
    // LOGOUT
    // =============================
    public function logout(Request $request)
    {
        // Hapus semua session
        $request->session()->flush();

        // Regenerasi token CSRF
        $request->session()->regenerateToken();

        // Balik ke form login + pesan sukses
        return redirect()->route('login.form')->with('success', 'Anda berhasil logout!');
    }
}
