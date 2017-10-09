<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjetoAtividade extends Model
{
    protected $table = 'projetos_atividades';

    protected $fillable = [
        'projeto_id',
        'atividade_id',
    ];

    public function atividade()
    {
        return $this->belongsTo(Atividade::class);
    }

    public function projeto()
    {
        return $this->belongsTo(Projeto::class);
    }
}
