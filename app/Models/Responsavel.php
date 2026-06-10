<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Responsavel extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'responsaveis';

    protected $fillable = [
        'nome',
        'email',
        'telefone',
        'consentimento_lgpd',
        'data_consentimento',
        'acesso_local',
        'telefone_secundario',
        'cpf',
        'rg',
        'data_nascimento',
        'idade',
        'estado_civil',
        'parentesco',
        'grau_instrucao',
        'profissao',
        'desempregado',
        'tem_cadastro_unico',
        'recebe_transferencia_renda',
        'recebe_bpc',
        'anexo_rg',
    ];

    protected $casts = [
        'consentimento_lgpd' => 'boolean',
        'data_consentimento' => 'datetime',
        'data_nascimento' => 'date',
        'tem_cadastro_unico' => 'boolean',
        'recebe_transferencia_renda' => 'boolean',
        'recebe_bpc' => 'boolean',
        'desempregado' => 'boolean',
    ];

    public function criancas()
    {
        return $this->belongsToMany(Crianca::class, 'crianca_responsavel')
                    ->withPivot('parentesco', 'principal')
                    ->withTimestamps();
    }

    public function contatos()
    {
        return $this->hasMany(Contato::class, 'responsavel_id');
    }

    public function criancasDiretas()
    {
        return $this->hasMany(Crianca::class, 'responsavel_id');
    }
}
