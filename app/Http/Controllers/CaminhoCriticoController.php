<?php

namespace App\Http\Controllers;

use App\Cenario;
use App\Projeto;
use Illuminate\Http\Request;

class CaminhoCriticoController extends Controller
{
    public function index(Projeto $projeto, Cenario $cenario) {
        return 'CaminhoCriticoController@index';
    }

    private function calculoIngenuo(Projeto $projeto, Cenario $cenario) {
        $this->authorize('view-projeto', $projeto);

    }
}
