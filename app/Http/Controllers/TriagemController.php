<?php

namespace App\Http\Controllers;

use App\Models\Crianca;
use App\Models\LogAuditoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TriagemController extends Controller
{
    /**
     * Lista as pré-inscrições aguardando triagem.
     */
    public function index(Request $request)
    {
        // Se for POST, salvamos os filtros na sessão
        if ($request->isMethod('post')) {
            if ($request->has('clear')) {
                session()->forget(['triagem_filtro_status', 'triagem_filtro_nome', 'triagem_filtro_data_inicio', 'triagem_filtro_data_fim']);
            } else {
                session([
                    'triagem_filtro_status' => $request->get('status', 'PREENCHER'),
                    'triagem_filtro_nome' => $request->get('nome'),
                    'triagem_filtro_data_inicio' => $request->get('data_inicio'),
                    'triagem_filtro_data_fim' => $request->get('data_fim')
                ]);
            }
            return redirect()->route('triagem.index');
        }

        $status = session('triagem_filtro_status', 'PREENCHER');
        $nome = session('triagem_filtro_nome');
        $data_inicio = session('triagem_filtro_data_inicio');
        $data_fim = session('triagem_filtro_data_fim');

        $query = Crianca::with('responsavel');

        if ($status && $status !== 'TODOS') {
            $query->where('status', $status);
        } else if ($status === 'TODOS') {
            $query->whereIn('status', ['PREENCHER', 'PENDENTE_MATRICULA', 'REJEITADO']);
        } else {
            $query->where('status', 'PREENCHER');
        }

        if ($nome) {
            $query->where('nome', 'like', "%{$nome}%");
        }
        if ($data_inicio) {
            $query->whereDate('created_at', '>=', $data_inicio);
        }
        if ($data_fim) {
            $query->whereDate('created_at', '<=', $data_fim);
        }

        $triagem = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('triagem.index', compact('triagem', 'status', 'nome', 'data_inicio', 'data_fim'));
    }

    /**
     * Exibe detalhes para triagem.
     */
    public function show($id)
    {
        $crianca = Crianca::with(['responsavel', 'logsAuditoria.usuario'])->findOrFail($id);
        return view('triagem.show', compact('crianca'));
    }
    public function onlyRead($id)
    {
        $crianca = Crianca::with(['responsavel', 'logsAuditoria.usuario'])->findOrFail($id);
        return view('triagem.onlyRead', compact('crianca'));
    }

    /**
     * Aprova ou rejeita a triagem inicial.
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:PENDENTE_MATRICULA,REJEITADO',
            'detalhes' => 'nullable|string'
        ]);

        $crianca = Crianca::findOrFail($id);
  
        $statusAntigo = $crianca->status;
        $crianca->status = $request->status;
        $crianca->save();

        // Se aprovado, sincroniza com tabela Matriculas (Fase 6)
        if ($request->status === 'PENDENTE_MATRICULA') {
            $anoAtual = \App\Models\AnoLetivo::atual();
            if ($anoAtual) {
                \App\Models\Matricula::updateOrCreate(
                    ['crianca_id' => $crianca->id, 'ano_letivo_id' => $anoAtual->id],
                    [
                        'status' => 'PENDENTE_MATRICULA',
                        'escola' => $crianca->escola,
                        'tipo_escola' => $crianca->tipo_escola,
                        'serie' => $crianca->serie,
                        'periodo_escolar' => $crianca->periodo_escolar,
                        'periodo_ong' => $crianca->periodo_ong,
                    ]
                );
            }
        }

        LogAuditoria::create([
            'usuario_id' => Auth::id(),
            'acao' => "Triagem: Alterou status de {$statusAntigo} para {$request->status}",
            'tabela_afetada' => 'criancas',
            'registro_id' => $crianca->id,
            'detalhes' => $request->detalhes ?? "Triagem realizada pelo administrador.",
            'data_hora' => now()
        ]);

        $mensagem = $request->status === 'PENDENTE_MATRICULA' 
            ? 'Triagem aprovada! A criança agora está na fase de Matrícula.' 
            : 'Inscrição rejeitada.';

        return redirect()->route('triagem.index')->with('success', $mensagem);
    }
}
