<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Turma extends Model
{
    use HasFactory;

    protected $table = 'turmas';

    protected $fillable = [
        'nome',
        'turno',
        'idade_minima',
        'idade_maxima',
        'capacidade',
        'ativa',
        'descricao',
    ];

    protected $casts = [
        'ativa' => 'boolean',
    ];

    public function criancas()
    {
        return $this->hasMany(Crianca::class, 'turma_id');
    }
}
