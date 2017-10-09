<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Atividade extends Model
{
    protected $table = 'atividades';

    protected $fillable = [
        'nome',
        'duracao',
        'descricao',
    ];

    public function sequencias()
    {
        return $this->hasMany(Sequencia::class);
    }

    public function projetos()
    {
        return $this->belongsToMany(Projeto::class, 'projetos_atividades');
    }
}
