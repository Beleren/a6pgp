<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjetoUsuario extends Model
{
    protected $table = 'projetos_usuarios';

    protected $fillable = [
        'proprietario',
    ];

    protected $casts = [
        'proprietario' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function projeto()
    {
        return $this->belongsTo(Projeto::class);
    }
}
