<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerificacionCodigo;

class RegisteredUserController extends Controller
{
    /**
     * Mostrar la vista de registro.
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Procesar el registro.
     */
    public function store(Request $request): RedirectResponse
    {
        // Validar campos
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Generar código de verificación (6 caracteres alfanuméricos en mayúsculas)
        $codigo = Str::upper(Str::random(6));

        // Crear usuario
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'email_verification_code' => $codigo,
            'email_verified' => false,
        ]);

        // Enviar el correo de verificación
        Mail::to($user->email)->send(new VerificacionCodigo($codigo));

        // Guardar el ID del usuario en sesión para verificar luego
        session(['pendiente_verificacion_id' => $user->id]);

        // Redirigir a la vista de verificación con un mensaje
        return redirect()->route('verificar.codigo.view')
            ->with('success', 'Se ha enviado un código a tu correo. Por favor, verifica tu cuenta.');
    }
}
