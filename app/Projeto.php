<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Projeto extends Model
{
    protected $table = 'projetos';

    protected $fillable = [
        'nome',
        'descricao',
        'medida_tempo',
    ];

    public function cenarios()
    {
        return $this->hasMany(Cenario::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'projetos_usuarios')
            ->withPivot('proprietario');
    }

    public function recursos()
    {
        return $this->belongsToMany(Recurso::class, 'projetos_recursos');
    }

    public function atividades()
    {
        return $this->belongsToMany(Atividade::class, 'projetos_atividades');
    }

    public function sequencias()
    {
        return $this->hasManyThrough(Sequencia::class, Cenario::class);
    }
}
