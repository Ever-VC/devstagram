<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $credentials = $request->only('email', 'password');

        if (auth()->attempt($credentials, $request->remember))
        {
            return redirect()->route('post.index');
        }

        return back()->withErrors([
            'mensaje' => 'Correo o contraseña incorrectos.'
        ]);
    }
}
