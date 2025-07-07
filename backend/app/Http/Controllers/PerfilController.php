<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PerfilController extends Controller
{
    public function actualizar(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'celular' => 'nullable|string|max:20',
            'documento_identidad' => 'nullable|string|max:20',
        ]);

        // Actualizar datos manualmente
        $user->name = $request->name;
        $user->email = $request->email;
        $user->celular = $request->celular;
        $user->documento_identidad = $request->documento_identidad;
        $user->save();

        return redirect()->route('perfil')->with('success', '✅ Perfil actualizado correctamente.');
    }
}
