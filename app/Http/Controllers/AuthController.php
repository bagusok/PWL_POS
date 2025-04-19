<?php

namespace App\Http\Controllers;

use App\Models\LevelModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Monolog\Level;

class AuthController extends Controller
{
    public function login()
    {
        if (Auth::check()) {
            return redirect('/');
        }

        return view('auth.login');
    }

    public function postLogin(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $credentials = $request->only('username', 'password');

            if (Auth::attempt($credentials)) {
                return response()->json([
                    'status' => true,
                    'message' => 'Login berhasil',
                    'redirect' => url('/')
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Login gagal, username atau password salah'
                ]);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Request Bukan Ajax'
            ]);
        }
    }

    public function register()
    {
        if (Auth::check()) {
            return redirect('/');
        }

        $level = LevelModel::select('level_id', 'level_nama', 'level_kode')->whereNot('level_kode', 'ADM')->get();

        return view('auth.register', [
            'level' => $level
        ]);
    }

    public function postRegister(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $credentials = $request->only('level_id', 'username', 'nama', 'password');

            $user = UserModel::create([
                'level_id' => $credentials['level_id'],
                'username' => $credentials['username'],
                'nama' => $credentials['nama'],
                'password' => Hash::make($credentials['password'])
            ]);

            if ($user) {
                return response()->json([
                    'status' => true,
                    'message' => 'Registrasi berhasil, silahkan login',
                    'redirect' => url('/login')
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Registrasi gagal, username sudah digunakan'
                ]);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Request Bukan Ajax'
            ]);
        }
    }


    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect(url('/login'))->with('success', 'Logout berhasil');
    }
}
