<?php

namespace App\Http\Controllers;

use App\Cenario;
use App\Http\Requests\ProjetoRequest;
use App\Projeto;
use App\ProjetoUsuario;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ProjetosController extends Controller
{

    /**
     * O construtor do controller projetos está configurado com middleware para evitar acesso ao projeto por
     * usuário não autenticado.
     *
     * Validações de autorização serão realizadas nas actions.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $usuario = User::find(auth()->id());
        $projetos = $usuario->projetos;

        return view('projetos.index', ['projetos' => $projetos]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('projetos.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProjetoRequest $request)
    {
        $projeto = new Projeto;

        $projeto = Projeto::create([
            'nome' => $request->input('nome'),
            'medida_tempo' => $request->input('medida_tempo'),
            'descricao' => $request->input('descricao'),
        ]);

        User::find(auth()->id())->projetos()->save($projeto);

        $projeto
            ->users()
            ->updateExistingPivot(auth()->id(), ['proprietario' => true]);

        $cenario = Cenario::firstOrCreate([
            'nome' => 'Cenário Padrão',
            'projeto_id' => $projeto->id,
        ]);

        return redirect(route('projetos.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Projeto  $projeto
     * @return \Illuminate\Http\Response
     */
    public function show(Projeto $projeto)
    {
        $this->authorize('view-projeto', $projeto);

        $cenarios = Cenario::where('projeto_id', $projeto->id)->get();

        return view('projetos.show', [
            'projeto' => $projeto,
            'cenarios' => $cenarios,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Projeto  $projeto
     * @return \Illuminate\Http\Response
     */
    public function edit(Projeto $projeto)
    {
        $this->authorize('view-projeto', $projeto);

        return view('projetos.edit', compact('projeto'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Projeto  $projeto
     * @return \Illuminate\Http\Response
     */
    public function update(ProjetoRequest $request, Projeto $projeto)
    {
        $this->authorize('view-projeto', $projeto);

        $projeto->nome = $request->input('nome');
        $projeto->descricao = $request->input('descricao');

        $projeto->save();

        return redirect(route('projetos.show', ['projeto' => $projeto]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Projeto  $projeto
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Projeto $projeto)
    {
        $this->authorize('view-projeto', $projeto);

        Projeto::destroy($projeto->id);

        return redirect(route('projetos.index'));
    }

    public function confirmDelete(Projeto $projeto)
    {
        $this->authorize('view-projeto', $projeto);

        return view('projetos.confirm-delete', ['projeto' => $projeto]);
    }

    public function compartilharProjeto(Projeto $projeto) {
        return view('projetos.compartilhar', [
            'projeto' => $projeto,
        ]);
    }

    public function salvarCompartilhamento(Request $request, Projeto $projeto) {
        /*
         * TODO: Implementar tratamento de outros cenários, tais como:
         * Usuário não cadastrou outros usuários para compartilhar projeto e
         * clicou em enviar.
         *
         * Usuário informou um e-mail inválido.
         */

        $this->authorize('view-projeto', $projeto);

        $dados = $request->input('projeto-usuarios');

        if (! $dados) {

        } else {
            try {
                $vetor = explode(';', $dados);

                if (count($vetor)) {
                    foreach ($vetor as $chave => $valor) {
                        $usuario = User::where('email', $valor)->first();

                        if ($usuario) {
                            $projeto->users()->save($usuario);
                        }
                    }
                }

            } catch (Exception $e) {
                $e->getMessage();
            }

        }

        return redirect(route('projetos.index'));
    }
}
