<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Penumpang;

class LoginPenggunaController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | FORM LOGIN PENUMPANG
    |--------------------------------------------------------------------------
    */
    public function showLoginForm()
    {
        return view('sealine.login.index');
    }

    /*
    |--------------------------------------------------------------------------
    | LOGIN PENUMPANG
    |--------------------------------------------------------------------------
    */
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('penumpang')->attempt([
            'email'    => $request->email,
            'password' => $request->password
        ])) {
            $request->session()->regenerate();
            return redirect()->route('sealine.homes.index');
        }

        return back()->withErrors([
            'login_error' => 'Email / Password salah'
        ]);
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

        return redirect()->route('login.pengguna');
    }

    /*
    |--------------------------------------------------------------------------
    | LOGOUT PENUMPANG
    |--------------------------------------------------------------------------
    */
    public function logout(Request $request)
    {
        Auth::guard('penumpang')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('sealine.homes.index');
    }
}
