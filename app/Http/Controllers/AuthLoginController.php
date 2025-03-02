<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthLoginController extends Controller
{
    public function showLogin()
    {
        return view('Login/Login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'login' => 'required',
            'password' => 'required',
        ]);

        $user = User::where('nis', $request->login)->orWhere('code_guru', $request->login)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user);
            if ($user->role === 'siswa') {
                return redirect()->route('siswa.dashboard');
            } elseif ($user->role === 'guru') {
                return redirect()->route('guru.dashboard');
            }
        }

        return back()->withErrors(['login' => 'NIS/Kode Guru atau password salah']);
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
