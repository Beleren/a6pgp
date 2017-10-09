<?php

namespace App\Http\Controllers;

use App\Http\Requests\RecursoRequest;
use App\Projeto;
use App\Recurso;
use App\Sequencia;
use Illuminate\Http\Request;

class RecursosController extends Controller
{
    public function index(Projeto $projeto)
    {
        $this->authorize('view-projeto', $projeto);

        $recursos = $projeto->recursos;

        return view('recursos.index', [
            'projeto' => $projeto,
            'recursos' => $recursos,
        ]);
    }

    public function create(Projeto $projeto)
    {
        $this->authorize('view-projeto', $projeto);

        return view('recursos.create', [
            'projeto' => $projeto,
        ]);
    }

    public function show(Projeto $projeto, Recurso $recurso)
    {
        $this->authorize('view-projeto', $projeto);

        return view('recursos.show', [
            'projeto' => $projeto,
            'recurso' => $recurso,
        ]);
    }

    public function store(RecursoRequest $request, Projeto $projeto)
    {
        $this->authorize('view-projeto', $projeto);

        $recurso = Recurso::create([
            'nome' => $request->input('nome'),
            'custo' => $request->input('custo'),
            'tipo_recurso_id' => $request->input('tipo_recurso'),
        ]);

        $projeto->recursos()->save($recurso);

        return redirect(route('recursos.index', [
            'projeto' => $projeto,
            'recursos' => $projeto->recursos,
        ]));
    }

    public function edit(Projeto $projeto, Recurso $recurso)
    {
        $this->authorize('view-projeto', $projeto);

        return view('recursos.edit', [
            'recurso' => $recurso,
            'projeto' => $projeto,
        ]);
    }

    public function update(RecursoRequest $request, Projeto $projeto, Recurso $recurso)
    {
        $this->authorize('view-projeto', $projeto);

        $recurso->nome = $request->input('nome');
        $recurso->custo = $request->input('custo');
        $recurso->tipo_recurso_id = $request->input('tipo_recurso');
        $recurso->save();

        return redirect(route('recursos.index', [
            'projeto' => $projeto,
        ]));
    }

    public function destroy(Projeto $projeto, Recurso $recurso)
    {
        $this->authorize('view-projeto', $projeto);

        /* TODO: Pesquisar porque não exclui. */

        $sequencias = Sequencia::where('recurso_id', $recurso->id);
        $sequencias->delete();

        Recurso::destroy($recurso);

        return redirect(route('recursos.index', [
            'projeto' => $projeto,
        ]));
    }

    public function confirmDelete(Projeto $projeto, Recurso $recurso)
    {
        $this->authorize('view-projeto', $projeto);

        return view('recursos.confirm-delete', [
           'recurso' => $recurso,
           'projeto' => $projeto,
        ]);
    }
}
