<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjetoRecurso extends Model
{
    protected $table = 'projetos_recursos';

    protected $fillable = [
        'projeto_id',
        'recurso_id',
    ];

    public function projeto()
    {
        return $this->belongsTo(Projeto::class);
    }

    public function recurso()
    {
        return $this->belongsTo(Recurso::class);
    }
}
