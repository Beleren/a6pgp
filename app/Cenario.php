<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cenario extends Model
{
    protected $table = 'cenarios';

    protected $fillable = [
        'nome',
        'descricao',
        'projeto_id',
    ];

    public function projeto()
    {
        return $this->belongsTo(Projeto::class);
    }
}
