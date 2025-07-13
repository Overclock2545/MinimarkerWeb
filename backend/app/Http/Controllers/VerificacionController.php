<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class VerificacionController extends Controller
{
    public function mostrar()
    {
        return view('auth.verificar_codigo');
    }

    public function verificar(Request $request)
    {
        $request->validate([
            'codigo' => 'required|string',
        ]);

        $userId = session('pendiente_verificacion_id');
        $user = User::find($userId);

        if (!$user || $user->email_verification_code !== $request->codigo) {
            return redirect()->back()->with('error', 'Código incorrecto. Intenta de nuevo.');
        }

        $user->email_verified = true;
        $user->email_verification_code = null;
        $user->save();

        Auth::login($user);
        session()->forget('pendiente_verificacion_id');

        return redirect()->route('inicio')->with('success', 'Tu cuenta ha sido verificada exitosamente.');

    }
}
