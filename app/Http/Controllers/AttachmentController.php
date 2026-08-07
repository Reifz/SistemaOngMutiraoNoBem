<?php

namespace App\Http\Controllers;

use App\Models\Crianca;
use App\Models\LogAuditoria;
use App\Models\Responsavel;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AttachmentController extends Controller
{
    private const ALLOWED_FIELDS = [
        'crianca' => [
            'anexo_certidao',
            'anexo_excel_matricula',
            'anexo_rg',
            'anexo_cpf',
            'anexo_comprovante_residencia',
            'anexo_comprovante_escolaridade',
            'anexo_comprovante_renda',
        ],
        'responsavel' => ['anexo_rg'],
    ];

    public function show(string $tipo, int $id, string $campo): StreamedResponse|Response
    {
        abort_unless(isset(self::ALLOWED_FIELDS[$tipo]), 404);
        abort_unless(in_array($campo, self::ALLOWED_FIELDS[$tipo], true), 404);

        $model = $tipo === 'crianca'
            ? Crianca::findOrFail($id)
            : Responsavel::findOrFail($id);

        $path = $model->{$campo};
        abort_unless(is_string($path) && $path !== '' && Storage::disk('local')->exists($path), 404);

        LogAuditoria::create([
            'usuario_id' => auth()->id(),
            'acao' => 'Documento: Download autorizado',
            'tabela_afetada' => $tipo === 'crianca' ? 'criancas' : 'responsaveis',
            'registro_id' => $model->id,
            'detalhes' => "Campo documental acessado: {$campo}",
            'data_hora' => now(),
        ]);

        $extension = pathinfo($path, PATHINFO_EXTENSION);
        $filename = $campo.($extension ? '.'.$extension : '');

        return Storage::disk('local')->download($path, $filename, [
            'Cache-Control' => 'private, no-store, max-age=0',
            'Pragma' => 'no-cache',
            'X-Content-Type-Options' => 'nosniff',
        ]);
    }
}
