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
        $projeto = Projeto::create([
            'nome' => $request->input('nome'),
            'medida_tempo' => $request->input('medida_tempo'),
            'descricao' => $request->input('descricao'),
        ]);

        User::find(auth()->id())->projetos()->save($projeto);

        $projeto
            ->users()
            ->updateExistingPivot(auth()->id(), ['proprietario' => true]);

        Cenario::firstOrCreate([
            'nome' => trans('paginas.cenario_padrao'),
            'projeto_id' => $projeto->id,
        ]);

        $request->session()->flash('success', trans('paginas.projetos.index.flash-messages.projeto-criado-sucesso'));
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

        $request->session()->flash('success', trans('paginas.projetos.index.flash-messages.projeto-alterado-sucesso'));

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

        $request->session()->flash('info', trans('paginas.projetos.index.flash-messages.projeto-excluido-sucesso'));
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
        $this->authorize('view-projeto', $projeto);

        $dados = $request->input('projeto-usuarios');
        $erros = false;
        $info = false;

        if (! $dados) {
            $erros = true;
            $request->session()->flash('danger', trans('paginas.projetos.index.flash-messages.compartilhar-emails-ausentes'));
        } else {
            try {
                $vetor = explode(';', $dados);

                if (count($vetor)) {
                    $usuarios_nao_cadastrados = '';
                    $usuarios_ja_cadastrados = '';

                    foreach ($vetor as $chave => $valor) {
                        $usuario = User::where('email', trim($valor))->first();

                        if ($usuario) {

                            if (ProjetoUsuario::where([
                                'user_id' => $usuario->id,
                                'projeto_id' => $projeto->id,
                            ])->first()) {
                                $usuarios_ja_cadastrados = $usuarios_ja_cadastrados . $valor . '; ';
                            } else {
                                $usuario->projetos()->save($projeto);
                            }
                        } else {
                            $usuarios_nao_cadastrados = $usuarios_nao_cadastrados . $valor . '; ';
                        }

                        if ($usuarios_nao_cadastrados) {
                            $erros = true;
                            $usuarios_nao_cadastrados = str_replace_last(';', '', trim($usuarios_nao_cadastrados));

                            if (stripos($usuarios_nao_cadastrados, ';') > 0) {
                                $request->session()->flash('warning', trans('paginas.projetos.index.flash-messages.compartilhar-usuario-inexistente') . '['
                                    . $usuarios_nao_cadastrados . '].' . trans('paginas.projetos.index.flash-messages.compartilhar-verificar-email'));
                            } else {
                                $request->session()->flash('warning', trans('paginas.projetos.index.flash-messages.compartilhar-usuario-inexistente') . '['
                                    . $usuarios_nao_cadastrados . '].' . trans('paginas.projetos.index.flash-messages.compartilhar-verificar-email'));
                            }
                        }

                        if ($usuarios_ja_cadastrados) {
                            $info = true;
                            $usuarios_ja_cadastrados = str_replace_last(';', '', trim($usuarios_ja_cadastrados));

                            if (stripos($usuarios_ja_cadastrados, ';') > 0) {
                                $request->session()->flash('info', trans('paginas.projetos.index.flash-messages.compartilhar-usuarios-com-acesso') .
                                    ' ' . $usuarios_ja_cadastrados . '.');
                            } else {
                                $request->session()->flash('info', trans('paginas.projetos.index.flash-messages.compartilhar-usuarios-com-acesso') .
                                    ' ' . $usuarios_ja_cadastrados . '.');
                            }
                        }
                    }
                }

            } catch (Exception $e) {
                $request->session()->flash('danger', trans('paginas.projetos.index.flash-messages.compartilhar-erro'));
                $e->getMessage();
            }

        }

        if (! $erros && ! $info) {
            $request->session()->flash('success', trans('paginas.projetos.index.flash-messages.compartilhar-sucesso'));
        }

        return redirect(route('projetos.index'));
    }
}
