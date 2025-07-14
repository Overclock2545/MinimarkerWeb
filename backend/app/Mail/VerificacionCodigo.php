<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerificacionCodigo extends Mailable
{
    use Queueable, SerializesModels;

    public $codigo;
    public $user;

    /**
     * Crear una nueva instancia.
     */
    public function __construct($codigo, $user)
    {
        $this->codigo = $codigo;
        $this->user = $user;
    }

    /**
     * Construir el mensaje.
     */
    public function build()
    {
        return $this->subject('Tu código de verificación - I LIKE YOU')
                    ->view('emails.codigo_verificacion'); // 👈 Aquí se indica el nombre de la vista
    }
}
