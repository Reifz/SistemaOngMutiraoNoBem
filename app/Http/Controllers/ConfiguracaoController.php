<?php

namespace App\Http\Controllers;

use App\Services\ConfiguracaoService;
use App\Models\LogAuditoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConfiguracaoController extends Controller
{
    /**
     * Exibe o formulário de configurações do sistema.
     */
    public function index()
    {
        $inscricoesAbertas = ConfiguracaoService::get('inscricoes_abertas', true);
        return view('configuracoes.index', compact('inscricoesAbertas'));
    }

    /**
     * Atualiza as configurações do sistema.
     */
    public function store(Request $request)
    {
        $request->validate([
            'inscricoes_abertas' => 'required|boolean'
        ]);

        $statusAntigo = ConfiguracaoService::get('inscricoes_abertas', true) ? 'Abertas' : 'Fechadas';
        $statusNovo = $request->inscricoes_abertas ? 'Abertas' : 'Fechadas';

        ConfiguracaoService::set('inscricoes_abertas', (bool) $request->inscricoes_abertas);

        // Registro de Auditoria para conformidade e transparência
        LogAuditoria::create([
            'usuario_id' => Auth::id(),
            'acao' => "Configuração: Alteração de Status das Inscrições",
            'tabela_afetada' => 'configuracoes',
            'registro_id' => 0,
            'detalhes' => "Alterou status das pré-inscrições de {$statusAntigo} para {$statusNovo}.",
            'data_hora' => now()
        ]);

        return redirect()->route('configuracoes.index')->with('success', 'Configurações atualizadas com sucesso!');
    }
}
