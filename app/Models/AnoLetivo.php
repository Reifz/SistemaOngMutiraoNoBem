<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnoLetivo extends Model
{
    use HasFactory;

    protected $table = 'anos_letivos';

    protected $fillable = [
        'ano',
        'data_virada',
        'status_ativo',
    ];

    protected $casts = [
        'status_ativo' => 'boolean',
        'data_virada' => 'date',
    ];

    public function matriculas()
    {
        return $this->hasMany(Matricula::class, 'ano_letivo_id');
    }

    public function anamneses()
    {
        return $this->hasMany(Anamnese::class, 'ano_letivo_id');
    }

    /**
     * Retorna o ano letivo ativo atual.
     */
    public static function atual()
    {
        return self::where('status_ativo', true)->first();
    }
}
