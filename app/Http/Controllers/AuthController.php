<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    
    // Mostrar formulario
    public function showLogin()
    {
        return view('auth.login');
    }

    // Procesar login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {

    $request->session()->regenerate();

    $user = auth()->user();

    dd($user, $user->cliente);

    if ($user->rol_id == 2 && $user->cliente) {
        return redirect('/cliente');
    }

    if ($user->rol_id == 1) {
        return redirect('/');
    }
}

        return back()->withErrors([
            'email' => 'Credenciales incorrectas',
        ]);
    }

    // Cerrar sesión
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}