<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sequencia extends Model
{
    protected $table = 'sequencias';

    protected $fillable = [
        'cenario_id',
        'inicio_otimista',
        'fim_otimista',
        'inicio_pessimista',
        'fim_pessimista',
        'atividade_id',
        'recurso_id',
        'quantidade_recurso',
        'atividade_predecessora_id',
        'requer_recursos',
        'tempo_alocado',
        'data_inicio_disp_recurso',
        'duracao',
    ];

//    protected $dates = [
//        'inicio_otimista',
//        'fim_otimista',
//    ];

    protected $casts = [
        'requer_recursos' => 'boolean',
    ];

    public function cenarios()
    {
        return $this->belongsTo(Cenario::class);
    }

    public function atividade()
    {
        return $this->belongsTo(Atividade::class);
    }

    public function atividadePredecessora()
    {
        return $this->belongsTo(Atividade::class);
    }

    public function recurso()
    {
        return $this->belongsTo(Recurso::class);
    }
}
