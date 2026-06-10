<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matricula extends Model
{
    use HasFactory;

    protected $table = 'matriculas';

    protected $fillable = [
        'crianca_id',
        'ano_letivo_id',
        'turma_id',
        'escola',
        'tipo_escola',
        'serie',
        'periodo_escolar',
        'periodo_ong',
        'status',
        'data_matricula',
        'data_evasao',
        'motivo_evasao',
        'observacao_evasao',
        'data_desligamento',
        'motivo_desligamento',
    ];

    protected $casts = [
        'data_matricula' => 'date',
        'data_evasao' => 'date',
        'data_desligamento' => 'date',
    ];

    public function crianca()
    {
        return $this->belongsTo(Crianca::class, 'crianca_id');
    }

    public function anoLetivo()
    {
        return $this->belongsTo(AnoLetivo::class, 'ano_letivo_id');
    }

    public function turma()
    {
        return $this->belongsTo(Turma::class, 'turma_id');
    }
}
