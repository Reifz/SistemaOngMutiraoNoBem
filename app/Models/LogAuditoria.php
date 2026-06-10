<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogAuditoria extends Model
{
    use HasFactory;

    protected $table = 'logs_auditoria';
    
    // Conforme database_schema, logs_auditoria usa data_hora
    public $timestamps = false;

    protected $fillable = [
        'usuario_id',
        'acao',
        'tabela_afetada',
        'registro_id',
        'detalhes',
        'data_hora',
    ];

    protected $casts = [
        'data_hora' => 'datetime',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
}
