<?php

namespace App\Http\Controllers;

use App\Cenario;
use App\Http\Requests\CenarioRequest;
use App\Projeto;
use App\Sequencia;
use Illuminate\Http\Request;

class CenariosController extends Controller
{
    public function index(Projeto $projeto)
    {
        $this->authorize('view-projeto', $projeto);

        $cenarios = $projeto->cenarios;

        return view('cenarios.index', [
            'cenarios' => $cenarios,
            'projeto' => $projeto,
        ]);
    }

    public function create(Projeto $projeto)
    {
        $this->authorize('view-projeto', $projeto);

        return view('cenarios.create', [
            'projeto' => $projeto
        ]);
    }

    public function show(Projeto $projeto, Cenario $cenario)
    {
        $this->authorize('view-projeto', $projeto);

        return view('cenarios.show', [
            'cenario' => $cenario,
            'projeto' => $projeto,
        ]);
    }

    public function store(CenarioRequest $request, Projeto $projeto)
    {
        $this->authorize('view-projeto', $projeto);

        $cenario = Cenario::create([
            'nome' => $request->input('nome'),
            'descricao' => $request->input('descricao'),
            'projeto_id' => $projeto->id,
            'data_inicio_projeto' => $request->input('data_inicio_projeto'),
        ]);

        $atividades = $projeto->atividades;

        //TODO: Verificar uma forma de evitar a duplicação de sequência se uma atividade já existe.
        foreach ($atividades as $atividade) {
            $sequencia = Sequencia::firstOrCreate([
               'atividade_id' => $atividade->id,
               'cenario_id' => $cenario->id,
            ]);
        }

        $request->session()->flash('success', trans('paginas.cenarios.cenario-criado-sucesso'));

        return redirect(route('cenarios.index', [
            'projeto' => $projeto
        ]));
    }

    public function edit(Projeto $projeto, Cenario $cenario)
    {
        $this->authorize('view-projeto', $projeto);

        return view('cenarios.edit', [
            'cenario' => $cenario,
            'projeto' => $projeto,
        ]);
    }


    public function update(CenarioRequest $request, Projeto $projeto, Cenario $cenario)
    {
        $this->authorize('view-projeto', $projeto);

        $cenario->nome = $request->input('nome');
        $cenario->descricao = $request->input('descricao');
        $cenario->data_inicio_projeto = $request->input('data_inicio_projeto');
        $cenario->save();

        $request->session()->flash('success', trans('paginas.cenarios.cenario-atualizado'));

        return redirect(route('cenarios.show', [
            'projeto' => $projeto,
            'cenario' => $cenario,
        ]));
    }

    public function destroy(Projeto $projeto, Cenario $cenario)
    {
        $this->authorize('view-projeto', $projeto);

        /* Verifica se existe mais de um cenário para exclusão. */
        if ($projeto->cenarios->count() <= 1) {
            abort(405);
        }

        /* Verifica as sequências que utilizam este cenário. */
        $sequencias = Sequencia::where('cenario_id', $cenario->id);

        $sequencias->delete();

        Cenario::destroy($cenario->id);

        session()->flash('info', trans('paginas.cenarios.cenario-excluido'));

        return redirect(route('cenarios.index', [
            'projeto' => $projeto,
        ]));
    }

    public function confirmDelete(Projeto $projeto, Cenario $cenario)
    {
        $this->authorize('view-projeto', $projeto);

        return view('cenarios.confirm-delete', [
            'cenario' => $cenario,
            'projeto' => $projeto,
        ]);
    }

    public function criarNovoCenario(Request $request, Projeto $projeto) {
        $this->authorize('view-projeto', $projeto);

        $cenario = Cenario::create([
            'nome' => 'Cenário ',
            'descricao' => $request->input('descricao'),
            'projeto_id' => $projeto->id,
        ]);

        $atividades = $projeto->atividades;

        //TODO: Verificar uma forma de evitar a duplicação de sequência se uma atividade já existe.
        foreach ($atividades as $atividade) {
            $sequencia = Sequencia::firstOrCreate([
                'atividade_id' => $atividade->id,
                'cenario_id' => $cenario->id,
            ]);
        }

        return $cenario;
    }
}
