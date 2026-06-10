<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Familiar extends Model
{
    use HasFactory;

    protected $table = 'familiares';

    protected $fillable = [
        'crianca_id',
        'nome',
        'data_nascimento',
        'idade',
        'grau_parentesco',
        'grau_instrucao',
        'estuda',
        'inserido_cca',
        'profissao',
        'ocupacao',
        'renda',
        'fatores_risco',
    ];

    protected $casts = [
        'data_nascimento' => 'date',
        'estuda' => 'boolean',
        'inserido_cca' => 'boolean',
        'renda' => 'decimal:2',
    ];

    public function crianca()
    {
        return $this->belongsTo(Crianca::class, 'crianca_id');
    }
}
