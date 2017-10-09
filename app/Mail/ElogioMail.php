<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ElogioMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $usuario;
    protected $email;
    protected $administrador;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($usuario = null, $email = null, $administrador  = 'msena.ifsp@gmail.com')
    {
        $this->usuario = $usuario;
        $this->email = $email;
        $this->administrador = $administrador;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.elogio')
            ->subject('Projeto Besouro | Elogios')
            ->from('postmaster@besouro.herokuapp.com', 'Projeto Besouro')
            ->with(['nome' => $this->usuario, 'email' => $this->email])
        ;
    }
}
