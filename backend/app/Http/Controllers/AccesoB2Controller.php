<?php

namespace App\Http\Controllers;

use App\Models\B2Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class AccesoB2Controller extends Controller
{
    public function formulario() { return view('acceso.ingresar'); }
    public function registro() { return view('acceso.registro'); }

    public function ingresar(Request $request)
    {
        $datos = $request->validate(['email' => ['required', 'email'], 'password' => ['required', 'string']]);
        $datos['email'] = mb_strtolower(trim($datos['email']));
        if (!Auth::guard('b2')->attempt($datos)) {
            return back()->withErrors(['email' => 'Correo o contraseña incorrectos.'])->onlyInput('email');
        }
        $request->session()->regenerate();
        return redirect()->intended(Auth::guard('b2')->user()->rol === 'admin' ? route('continuidad.metricas') : route('inicio'));
    }

    public function crear(Request $request)
    {
        $request->merge(['email' => mb_strtolower(trim((string) $request->input('email')))]);
        $datos = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:255', 'unique:b2_usuarios,email'],
            'password' => ['required', 'confirmed', Password::min(10)],
        ]);
        $usuario = B2Usuario::create($datos + ['rol' => 'usuario']);
        Auth::guard('b2')->login($usuario);
        $request->session()->regenerate();
        return redirect()->route('inicio');
    }

    public function salir(Request $request)
    {
        Auth::guard('b2')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('inicio');
    }
}
