<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules;
use Illuminate\Support\Str;
use Illuminate\View\View;
use App\Mail\VerificacionCodigo;

class RegisteredUserController extends Controller
{
    /**
     * Mostrar el formulario de registro.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Procesar el registro del usuario.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Generar código de verificación
        $codigo = Str::upper(Str::random(6));

        // Crear usuario
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'email_verification_code' => $codigo,
            'email_verified' => false,
        ]);

        // Enviar correo con código usando la clase Mailable
        Mail::to($user->email)->send(new VerificacionCodigo($codigo, $user));

        // Guardar el ID en sesión para la verificación
        session(['pendiente_verificacion_id' => $user->id]);

        // Redirigir a la vista donde se ingresa el código
        return redirect()->route('verificar.codigo.view')
            ->with('success', 'Se ha enviado un código a tu correo. Ingresa el código para verificar tu cuenta.');
    }
}
