<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CriancaResponsavel extends Model
{
    use HasFactory;

    protected $table = 'crianca_responsavel';

    protected $fillable = [
        'crianca_id',
        'responsavel_id',
        'parentesco',
        'principal',
    ];

    protected $casts = [
        'principal' => 'boolean',
    ];

    public function crianca()
    {
        return $this->belongsTo(Crianca::class, 'crianca_id');
    }

    public function responsavel()
    {
        return $this->belongsTo(Responsavel::class, 'responsavel_id');
    }
}
