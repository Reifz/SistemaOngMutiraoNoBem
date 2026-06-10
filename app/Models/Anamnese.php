<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anamnese extends Model
{
    use HasFactory;

    protected $table = 'anamnese';
    
    // Conforme database_schema, anamnese usa apenas updated_at
    const UPDATED_AT = 'updated_at';
    const CREATED_AT = null;

    protected $fillable = [
        'crianca_id',
        'ano_letivo_id',
        'dados_json',
    ];

    public function anoLetivo()
    {
        return $this->belongsTo(AnoLetivo::class, 'ano_letivo_id');
    }

    protected $casts = [
        'dados_json' => 'encrypted:array', // Criptografia nativa para dados sensíveis (LGPD)
    ];

    public function crianca()
    {
        return $this->belongsTo(Crianca::class, 'crianca_id');
    }
}
