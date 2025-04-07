<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\RedirectResponse;

class AuthController extends Controller
{
    public function show()
    {
        return view('sistema.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'cpf' => ['required'],
            'senha' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

           // return redirect()->intended('dashboard');

        }

        return back()->withErrors([
            'cpf' => 'CPF ou senha incorreta.',
        ])->onlyInput('cpf');
    }

    public function criarConta()
    {
        return view('sistema.registrar');
    }

    public function sair(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('login.show');
    }
}
