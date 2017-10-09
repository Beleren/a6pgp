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

        switch($topico) {
            case 'sugestao':
                Mail::to($request->input('email'))
                    ->send(new SugestaoMail($nome, $email)); 
                break;
            case 'elogio':
                Mail::to($request->input('email'))
                    ->send(new ElogioMail($nome, $email)); 
                break;
            case 'critica':
                Mail::to($request->input('email'))
                    ->send(new CriticaMail($nome, $email)); 
                break;
            case 'erro':
                Mail::to($request->input('email'))
                    ->send(new ErroMail($nome, $email)); 
                break;
            case 'outro':
                Mail::to($request->input('email'))
                    ->send(new OutroMail($nome, $email)); 
                break;
            default:
                Mail::to($request->input('email'))
                    ->send(new OutroMail($nome, $email)); 
        }

        if (auth()->guest()) {
            return redirect(url('/'));
        } else {
            return redirect(route('projetos.index'));
        }
    }
}
