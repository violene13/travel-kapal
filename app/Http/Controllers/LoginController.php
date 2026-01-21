<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Penumpang;

class LoginController extends Controller
{
    /* ================= LOGIN FORM ================= */
    public function showLoginForm()
    {
        //  Kalau sudah login, jangan balik ke login
        if (Auth::check()) {
            return match (Auth::user()->role) {
                'admin_travel'    => redirect()->route('admin.travel.dashboard'),
                'admin_pelayaran' => redirect()->route('admin.pelayaran.dashboard'),
                'penumpang'       => redirect()->route('sealine.homes.index'),
                default           => abort(403),
            };
        }

        //  Pakai halaman home , modal login 
        return redirect()->route('sealine.homes.index', ['login' => 1]);
    }

    /* ================= LOGIN MODAL ================= */
public function loginModal(Request $request)
{
    return $this->login($request);
}

    /* ================= LOGIN PROCESS ================= */
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        if (Auth::attempt([
            filter_var($request->username, FILTER_VALIDATE_EMAIL)
                ? 'email'
                : 'name' => $request->username,
            'password' => $request->password
        ])) {

            $request->session()->regenerate();
            $user = Auth::user();

            return match ($user->role) {
                'admin_travel'    => redirect()->route('admin.travel.dashboard'),
                'admin_pelayaran' => redirect()->route('admin.pelayaran.dashboard'),
                'penumpang'       => redirect()->route('sealine.homes.index'),
                default           => abort(403),
            };
        }

        return back()->withErrors([
            'login_error' => 'Username / Email atau Password salah'
        ]);
    }

    /* ================= REGISTER PENUMPANG ================= */
    public function showRegisterForm()
    {
        return view('sealine.register.index');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|unique:users,email',
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

        DB::beginTransaction();

        try {
            // USER LOGIN
            $user = User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => Hash::make($request->password),
                'role'     => 'penumpang',
            ]);

            // DATA PENUMPANG
            Penumpang::create([
                'id_user'        => $user->id,
                'nama_penumpang' => $request->name,
                'email'          => $request->email,
                'no_hp'          => $request->no_hp,
                'alamat'         => $request->alamat,
                'no_ktp'         => $request->no_ktp,
                'gender'         => $request->gender,
                'tanggal_lahir'  => $tanggal_lahir,
            ]);

            DB::commit();

            return redirect()
                ->route('sealine.homes.index')
                ->with('success', 'Registrasi berhasil, silakan login');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Registrasi gagal');
        }
    }

    /* ================= LOGOUT ================= */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('sealine.homes.index');
    }
}
