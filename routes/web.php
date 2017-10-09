<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('home.index');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/sobre', 'HomeController@sobre')->name('home.sobre');
Route::get('/contato', 'HomeController@contato')->name('home.contato');
Route::post('/contato', 'HomeController@salvarMensagemContato')
    ->name('home.salvar-contato');

/* Projetos */

Route::middleware(['web', 'auth'])->group(function (){

    Route::get('/projetos', 'ProjetosController@index')
        ->name('projetos.index');

    Route::get('/projetos/create', 'ProjetosController@create')
        ->name('projetos.create');

    Route::post('/projetos', 'ProjetosController@store')
        ->name('projetos.store');

    Route::get('/projetos/{projeto}', 'ProjetosController@show')
        ->name('projetos.show');

    Route::get('/projetos/{projeto}/edit', 'ProjetosController@edit')
        ->name('projetos.edit');

    Route::match(['patch', 'put'], '/projetos/{projeto}', 'ProjetosController@update')
        ->name('projetos.update');

    Route::delete('/projetos/{projeto}', 'ProjetosController@destroy')
        ->name('projetos.destroy');

    Route::get('/projetos/{projeto}/delete', 'ProjetosController@confirmDelete')
        ->name('projetos.confirmDelete');

    Route::get('/projetos/{projeto}/compartilhar', 'ProjetosController@compartilharProjeto')
        ->name('projetos.compartilhar');

    Route::post('/projetos/{projeto}/compartilhar', 'ProjetosController@salvarCompartilhamento')
        ->name('projetos.salvar-compartilhamento');

    /* Cenários */

    Route::get('/projetos/{projeto}/cenarios', 'CenariosController@index')
        ->name('cenarios.index');

    Route::get('/projetos/{projeto}/cenarios/create', 'CenariosController@create')
        ->name('cenarios.create');

    Route::get('/projetos/{projeto}/cenarios/{cenario}', 'CenariosController@show')
        ->name('cenarios.show');

    Route::post('/projetos/{projeto}/cenarios', 'CenariosController@store')
        ->name('cenarios.store');

    Route::get('/projetos/{projeto}/cenarios/{cenario}/edit', 'CenariosController@edit')
        ->name('cenarios.edit');

    Route::match(['patch', 'put'], '/projetos/{projeto}/cenarios/{cenario}', 'CenariosController@update')
        ->name('cenarios.update');

    Route::delete('/projetos/{projeto}/cenarios/{cenario}', 'CenariosController@destroy')
        ->name('cenarios.destroy');

    Route::get('/projetos/{projeto}/cenarios/{cenario}/delete', 'CenariosController@confirmDelete')
        ->name('cenarios.confirm-delete');

    // Atividades
    Route::get('/projetos/{projeto}/atividades', 'AtividadesController@index')
        ->name('atividades.index');

    Route::get('/projetos/{projeto}/atividades/create', 'AtividadesController@create')
        ->name('atividades.create');

    Route::get('/projetos/{projeto}/atividades/{atividade}', 'AtividadesController@show')
        ->name('atividades.show');

    Route::post('/projetos/{projeto}/atividades', 'AtividadesController@store')
        ->name('atividades.store');

    Route::get('/projetos/{projeto}/atividades/{atividade}/edit', 'AtividadesController@edit')
        ->name('atividades.edit');

    Route::match(['patch', 'put'], '/projetos/{projeto}/atividades/{atividade}', 'AtividadesController@update')
        ->name('atividades.update');

    Route::delete('/projetos/{projeto}/atividades/{atividade}', 'AtividadesController@destroy')
        ->name('atividades.destroy');

    Route::get('/projetos/{projeto}/atividades/{atividade}/delete', 'AtividadesController@confirmDelete')
        ->name('atividades.confirm-delete');

    // Recursos
    Route::get('/projetos/{projeto}/recursos', 'RecursosController@index')
        ->name('recursos.index');

    Route::get('/projetos/{projeto}/recursos/create', 'RecursosController@create')
        ->name('recursos.create');

    Route::get('/projetos/{projeto}/recursos/{recurso}', 'RecursosController@show')
        ->name('recursos.show');

    Route::post('/projetos/{projeto}/recursos', 'RecursosController@store')
        ->name('recursos.store');

    Route::get('/projetos/{projeto}/recursos/{recurso}/edit', 'RecursosController@edit')
        ->name('recursos.edit');

    Route::match(['patch', 'put'], '/projetos/{projeto}/recursos/{recursos}', 'RecursosController@update')
        ->name('recursos.update');

    Route::delete('/projetos/{projeto}/recursos/{recursos}', 'RecursosController@destroy')
        ->name('recursos.destroy');

    Route::get('/projetos/{projeto}/recursos/{recurso}/delete', 'RecursosController@confirmDelete')
        ->name('recursos.confirm-delete');

    /* Sequências */
    Route::get('/projetos/{projeto}/sequencias/cenarios/{cenario?}', 'SequenciasController@index')
        ->name('sequencias.index');

    Route::post('/projetos/{projeto}/sequencias/cenarios', 'SequenciasController@store')
        ->name('sequencias.store');
});