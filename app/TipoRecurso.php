<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoRecurso extends Model
{
    protected $table = 'tipos_recursos';

    protected $fillable = [
        'nome',
    ];

    public function recurso()
    {
        return $this->hasMany(Recurso::class);
    }
}
