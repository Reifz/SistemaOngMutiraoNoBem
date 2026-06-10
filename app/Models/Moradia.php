<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Moradia extends Model
{
    use HasFactory;

    protected $table = 'moradias';

    protected $fillable = [
        'crianca_id',
        'endereco',
        'complemento',
        'cep',
        'bairro',
        'ponto_referencia',
        'situacao_habitacional',
        'numero_comodos',
        'numero_moradores',
        'condicao_moradia',
    ];

    public function crianca()
    {
        return $this->belongsTo(Crianca::class, 'crianca_id');
    }
}
