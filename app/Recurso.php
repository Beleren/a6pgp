<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recurso extends Model
{
    protected $table = 'recursos';

    protected $fillable = [
        'tipo_recurso_id',
        'nome',
        'custo',
    ];

    public function sequencias()
    {
        return $this->hasMany(Sequencia::class);
    }

    public function tipoRecurso()
    {
        return $this->belongsTo(TipoRecurso::class);
    }

    public function projetos()
    {
        return $this->belongsToMany(Projeto::class, 'projetos_recursos');
    }
}
