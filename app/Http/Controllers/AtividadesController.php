<?php

namespace App\Http\Controllers;

use App\Http\Requests\AtividadeRequest;
use App\Projeto;
use App\Atividade;
use App\Sequencia;
use Illuminate\Http\Request;

class AtividadesController extends Controller
{
    public function index(Projeto $projeto, Atividade $atividades)
    {
        $this->authorize('view-projeto', $projeto);

        return view('atividades.index', [
            'atividades' => $projeto->atividades,
            'projeto' => $projeto,
        ]);
    }

    public function create(Projeto $projeto)
    {
        $this->authorize('view-projeto', $projeto);

        return view('atividades.create', [
            'projeto' => $projeto,
        ]);
    }

    public function show(Projeto $projeto, Atividade $atividade)
    {
        $this->authorize('view-projeto', $projeto);

        return view('atividades.show', [
            'atividade' => $atividade,
            'projeto' => $projeto,
        ]);
    }

    public function store(AtividadeRequest $request, Projeto $projeto, Atividade $atividade)
    {
        $this->authorize('view-projeto', $projeto);

        $atividade = Atividade::create([
            'nome' => $request->input('nome'),
            'duracao' => $request->input('duracao'),
            'descricao' => $request->input('descricao'),
        ]);

        $projeto->atividades()->save($atividade);

        $sequencia = Sequencia::firstOrCreate([
            'cenario_id' => $projeto->cenarios->first()->id,
            'atividade_id' => $atividade->id,
        ]);

        $request->session()->flash('success', trans('paginas.atividades.atividade-criada-sucesso'));
        return redirect(route('atividades.index', [
            'projeto' => $projeto,
        ]));
    }

    public function edit(Projeto $projeto, Atividade $atividade)
    {
        $this->authorize('view-projeto', $projeto);

        return view('atividades.edit', [
            'atividade' => $atividade,
            'projeto' => $projeto,
        ]);
    }

    public function update(AtividadeRequest $request, Projeto $projeto, Atividade $atividade)
    {
        $this->authorize('view-projeto', $projeto);

        $atividade->nome = $request->input('nome');
        $atividade->duracao = $request->input('duracao');
        $atividade->descricao = $request->input('descricao');
        $atividade->save();

        $request->session()->flash('success', trans('paginas.atividades.atividade-alterada-sucesso'));

        return redirect(route('atividades.index', [
            'projeto' => $projeto,
        ]));
    }

    public function confirmDelete(Projeto $projeto, Atividade $atividade)
    {
        $this->authorize('view-projeto', $projeto);

        return view('atividades.confirm-delete', [
            'atividade' => $atividade,
            'projeto' => $projeto,
        ]);
    }

    public function destroy(Projeto $projeto, Atividade $atividade)
    {
        $this->authorize('view-projeto', $projeto);

        /* Excluir sequências relacionadas. */
        //se houver sequencia, deve haver um impedimento até o usuário retirar as sequencias
        $sequencias = Sequencia::where('atividade_id', $atividade->id)
            ->orWhere('atividade_predecessora_id', $atividade->id);
        $sequencias->delete();

        Atividade::destroy($atividade->id);

        session()->flash('info', trans('paginas.atividades.atividade-excluida-sucesso'));

        return redirect(route('atividades.index', [
            'projeto' => $projeto,
        ]));
    }
}