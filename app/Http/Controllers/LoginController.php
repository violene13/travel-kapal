<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Penumpang;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | LOGIN FORM
    |--------------------------------------------------------------------------
    */
    public function showLoginForm()
    {
        return redirect()->route('sealine.homes.index');
    }

    /*
    |--------------------------------------------------------------------------
    | REGISTER FORM
    |--------------------------------------------------------------------------
    */
    public function showRegisterForm()
    {
        // hanya logout penumpang
        if (Auth::guard('penumpang')->check()) {
            Auth::guard('penumpang')->logout();
        }

        return view('sealine.register.index');
    }

    /*
    |--------------------------------------------------------------------------
    | REGISTER PENUMPANG
    |--------------------------------------------------------------------------
    */
    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|unique:penumpang,email',
            'password' => 'required|min:6|confirmed',
            'no_hp'    => 'required|string|max:20',
            'alamat'   => 'required|string|max:255',
            'no_ktp'   => 'required|string|max:20',
            'gender'   => 'required|in:L,P',
            'tahun'    => 'required|integer',
            'bulan'    => 'required|integer',
            'tanggal'  => 'required|integer',
        ]);

        $tanggal_lahir = sprintf(
            '%04d-%02d-%02d',
            $request->tahun,
            $request->bulan,
            $request->tanggal
        );

        Penumpang::create([
            'nama_penumpang' => $request->name,
            'email'          => $request->email,
            'password'       => Hash::make($request->password),
            'no_hp'          => $request->no_hp,
            'alamat'         => $request->alamat,
            'no_ktp'         => $request->no_ktp,
            'gender'         => $request->gender,
            'tanggal_lahir'  => $tanggal_lahir,
        ]);

        return redirect()->route('sealine.homes.index');
    }

    /*
    |--------------------------------------------------------------------------
    | LOGIN ADMIN & PENUMPANG
    |--------------------------------------------------------------------------
    */
public function login(Request $request)
{
    $request->validate([
        'username' => 'required',
        'password' => 'required',
    ]);

    /*
    |==================================================
    | LOGIN ADMIN (GUARD WEB)
    |==================================================
    */
     if (
        Auth::guard('web')->attempt(
            ['name' => $request->username, 'password' => $request->password]
        ) ||
        Auth::guard('web')->attempt(
            ['email' => $request->username, 'password' => $request->password]
        )
    ) {
        $request->session()->regenerate();

        $admin = Auth::guard('web')->user();

        // memastikan benar-benar admin
        if (!in_array($admin->role, ['admin_travel', 'admin_pelayaran'])) {
            Auth::guard('web')->logout();
            return back()->withErrors([
                'login_error' => 'Akses tidak valid'
            ]);
        }

        return match ($admin->role) {
            'admin_travel'    => redirect()->route('admin.travel.dashboard'),
            'admin_pelayaran' => redirect()->route('admin.pelayaran.dashboard'),
        };
    }

    /*
    |==================================================
    | LOGIN PENUMPANG (GUARD PENUMPANG)
    |==================================================
    */
    if (filter_var($request->username, FILTER_VALIDATE_EMAIL)) {
        if (
            Auth::guard('penumpang')->attempt([
                'email'    => $request->username,
                'password' => $request->password
            ])
        ) {
            $request->session()->regenerate();
            return redirect()->route('sealine.homes.index');
        }
    }

    return back()->withErrors([
        'login_error' => 'Username / Email atau Password salah'
    ]);
}

    /*
    |--------------------------------------------------------------------------
    | LOGOUT
    |--------------------------------------------------------------------------
    */
    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        Auth::guard('penumpang')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('sealine.homes.index');
    }
}
