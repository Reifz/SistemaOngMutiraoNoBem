<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inscricao extends Model
{
    use HasFactory;

    protected $table = 'inscricoes';
    
    // Conforme database_schema, inscricoes usa data_criacao em vez de created_at tradicional
    public $timestamps = false;

    protected $fillable = [
        'crianca_id',
        'status',
        'consentimento_lgpd',
        'data_criacao',
    ];

    protected $casts = [
        'consentimento_lgpd' => 'boolean',
        'data_criacao' => 'datetime',
    ];

    public function crianca()
    {
        return $this->belongsTo(Crianca::class, 'crianca_id');
    }
}
