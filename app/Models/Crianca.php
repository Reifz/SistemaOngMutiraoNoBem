<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Crianca extends Model
{
    use HasFactory;

    protected $table = 'criancas';

    protected $fillable = [
        'responsavel_id',
        'turma_id',
        'nome',
        'data_nascimento',        'status',
        'idade_declarada',
        'idade',
        'escola',
        'tipo_escola',
        'serie',
        'periodo_escolar',
        'periodo_ong',
        'esta_na_escola',
        'sexo',
        'cor_raca',
        'cpf',
        'rg',
        'certidao_nascimento',
        'certidao_folha',
        'certidao_livro',
        'naturalidade',
        'data_inscricao',
        'data_matricula',
        'data_desligamento',
        'motivo_desligamento',
        'possui_deficiencia',
        'anexo_certidao',
        'anexo_excel_matricula',
        'anexo_rg',
        'anexo_cpf',
        'anexo_comprovante_residencia',
        'anexo_comprovante_escolaridade',
        'anexo_comprovante_renda',
        'data_evasao',
        'motivo_evasao',
        'observacao_evasao',
    ];

    protected $casts = [
        'data_nascimento' => 'date',
        'data_inscricao' => 'date',
        'data_matricula' => 'date',
        'data_desligamento' => 'date',
        'data_evasao' => 'date',
        'esta_na_escola' => 'boolean',
        'possui_deficiencia' => 'boolean',
    ];

    public function matriculas()
    {
        return $this->hasMany(Matricula::class, 'crianca_id');
    }

    /**
     * Retorna a matrícula do ano letivo atual.
     */
    public function matriculaAtual()
    {
        $anoAtual = AnoLetivo::atual();
        if (!$anoAtual) return null;
        
        return $this->matriculas()->where('ano_letivo_id', $anoAtual->id)->first();
    }

    /**
     * Accessor para obter o status da matrícula atual (mantendo compatibilidade).
     */
    public function getStatusAttribute()
    {
        $matricula = $this->matriculaAtual();
        return $matricula ? $matricula->status : ($this->attributes['status'] ?? 'PREENCHER');
    }

    /**
     * Mutator para salvar o status em ambas as tabelas.
     */
    public function setStatusAttribute($value)
    {
        $this->attributes['status'] = $value;
        
        $matricula = $this->matriculaAtual();
        if ($matricula) {
            $matricula->status = $value;
            $matricula->save();
        }
    }

    /**
     * Accessor para obter a turma atual.
     */
    public function getTurmaIdAttribute()
    {
        $matricula = $this->matriculaAtual();
        return $matricula ? $matricula->turma_id : ($this->attributes['turma_id'] ?? null);
    }

    /**
     * Mutator para salvar a turma em ambas as tabelas.
     */
    public function setTurmaIdAttribute($value)
    {
        $this->attributes['turma_id'] = $value;
        
        $matricula = $this->matriculaAtual();
        if ($matricula) {
            $matricula->turma_id = $value;
            $matricula->save();
        }
    }

    public function getEscolaAttribute()
    {
        $matricula = $this->matriculaAtual();
        return $matricula ? $matricula->escola : ($this->attributes['escola'] ?? null);
    }

    public function getTipoEscolaAttribute()
    {
        $matricula = $this->matriculaAtual();
        return $matricula ? $matricula->tipo_escola : ($this->attributes['tipo_escola'] ?? null);
    }

    public function getSerieAttribute()
    {
        $matricula = $this->matriculaAtual();
        return $matricula ? $matricula->serie : ($this->attributes['serie'] ?? null);
    }

    public function getPeriodoEscolarAttribute()
    {
        $matricula = $this->matriculaAtual();
        return $matricula ? $matricula->periodo_escolar : ($this->attributes['periodo_escolar'] ?? null);
    }

    public function getPeriodoOngAttribute()
    {
        $matricula = $this->matriculaAtual();
        return $matricula ? $matricula->periodo_ong : ($this->attributes['periodo_ong'] ?? null);
    }

    public function getDataMatriculaAttribute()
    {
        $matricula = $this->matriculaAtual();
        return $matricula ? $matricula->data_matricula : ($this->attributes['data_matricula'] ?? null);
    }

    public function responsavel()
    {
        return $this->belongsTo(Responsavel::class, 'responsavel_id');
    }

    public function turma()
    {
        return $this->belongsTo(Turma::class, 'turma_id');
    }

    public function responsaveis()
    {
        return $this->belongsToMany(Responsavel::class, 'crianca_responsavel')
                    ->withPivot('parentesco', 'principal')
                    ->withTimestamps();
    }

    public function familiares()
    {
        return $this->hasMany(Familiar::class, 'crianca_id');
    }

    public function moradia()
    {
        return $this->hasOne(Moradia::class, 'crianca_id');
    }

    public function inscricao()
    {
        return $this->hasOne(Inscricao::class, 'crianca_id');
    }

    public function anamnese()
    {
        return $this->hasOne(Anamnese::class, 'crianca_id');
    }

    /**
     * Accessor para a idade real calculada com base na data de nascimento.
     */
    public function getIdadeAttribute()
    {
        if ($this->data_nascimento) {
            return $this->data_nascimento->age;
        }

        return $this->attributes['idade'] ?? $this->idade_declarada;
    }

    public function logsAuditoria()
    {
        return $this->hasMany(LogAuditoria::class, 'registro_id')->where('tabela_afetada', 'criancas');
    }
}
