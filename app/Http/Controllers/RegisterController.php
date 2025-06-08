<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    //
    public function index ()
    {
        return view('auth.register');
    }

    public function store (Request $request)
    {
        //dd($request);
        //dd($request->get('name'));
        // Validacion del formulario

        // Modificando el request para evitar el error de validación unica en el campo username
        $request->merge([
            'username' => Str::slug($request->username)
        ]);

        // Validación del formulario
        $request->validate([
            'name' => 'required|min:3|max:30',
            'username' => 'required|unique:users|min:3|max:30',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required|min:6',
        ]);


        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => $request->password
        ]);

        /* auth()->attempt([
            'email' => $request->email,
            'password' => $request->password
        ]); */

        auth()->attempt($request->only('email', 'password'));

        // Redireccionar al usuario
        return redirect()->route('post.index');
    }
}
