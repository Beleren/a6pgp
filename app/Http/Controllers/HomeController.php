<?php

namespace App\Http\Controllers;

use App\Http\Requests\MensagemContatoRequest;
use App\Mail\CriticaMail;
use App\Mail\ElogioMail;
use App\Mail\ErroMail;
use App\Mail\OutroMail;
use App\Mail\SugestaoMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', [
            'except' => [
                'sobre',
                'contato',
            ]
        ]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return redirect(route('projetos.index'));
    }

    public function sobre()
    {
        return view('home.sobre');
    }

    public function contato() {
        return view('home.contato');
    }

    public function salvarMensagemContato(MensagemContatoRequest $request) {
        $usuario = \App\User::find(auth()->id());

        if ($usuario) {
            $nome = $usuario->name;
        } else {
            $nome = '';
        }

        $email = $request->input('email');
        $assunto = $request->input('assunto');
        $topico = $request->input('topico');
        $mensagem = $request->input('mensagem');

        switch($topico) {
            case 'sugestao':
                Mail::to(env('MAIL_USERNAME', 'your@email.com'))
                    ->send(new SugestaoMail($nome, $email, $mensagem));
                break;
            case 'elogio':
                Mail::to(env('MAIL_USERNAME', 'your@email.com'))
                    ->send(new ElogioMail($nome, $email, $mensagem));
                break;
            case 'critica':
                Mail::to(env('MAIL_USERNAME', 'your@email.com'))
                    ->send(new CriticaMail($nome, $email, $mensagem));
                break;
            case 'erro':
                Mail::to(env('MAIL_USERNAME', 'your@email.com'))
                    ->send(new ErroMail($nome, $email, $mensagem));
                break;
            case 'outro':
                Mail::to(env('MAIL_USERNAME', 'your@email.com'))
                    ->send(new OutroMail($nome, $email, $mensagem));
                break;
            default:
                Mail::to(env('MAIL_USERNAME', 'your@email.com'))
                    ->send(new OutroMail($nome, $email, $mensagem));
        }

        $request->session()->flash('success', 'E-mail enviado com sucesso!');

        if (auth()->guest()) {
            return redirect(url('/'));
        } else {
            return redirect(route('projetos.index'));
        }
    }
}
