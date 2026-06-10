<?php

namespace App\Http\Controllers;

use App\Models\Crianca;
use App\Models\LogAuditoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class DashboardController extends Controller
{
    /**
     * Exibe o dashboard com filtros de status.
     */
    public function index(Request $request)
    {
        // Se for POST, salvamos os filtros na sessão e redirecionamos para o GET
        if ($request->isMethod('post')) {
            
            // Caso seja uma solicitação de limpar filtros
            if ($request->has('clear')) {
                session()->forget(['filtro_status', 'filtro_nome', 'filtro_data_inicio', 'filtro_data_fim']);
            } else {
                // Caso contrário, salvamos os filtros enviados
                session([
                    'filtro_status' => $request->get('status'),
                    'filtro_nome' => $request->get('nome'),
                    'filtro_data_inicio' => $request->get('data_inicio'),
                    'filtro_data_fim' => $request->get('data_fim')
                ]);
            }

            return redirect()->route('dashboard');
        }

        // Recuperamos da sessão para exibição (GET)
        $status = session('filtro_status', 'PREENCHER');
        $nome = session('filtro_nome');
        $data_inicio = session('filtro_data_inicio');
        $data_fim = session('filtro_data_fim');
        
        $query = Crianca::with('responsavel');

        if ($status && $status !== 'TODOS') {
            $query->where('status', $status);
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

        // Item 7: Aniversariantes do dia
        $aniversariantes = Crianca::whereMonth('data_nascimento', now()->month)
            ->whereDay('data_nascimento', now()->day)
            ->get();

        // Item 3: Alertas de Triagem (paradas há mais de 7 dias)
        $alertasTriagem = Crianca::where('status', 'PREENCHER')
            ->where('created_at', '<=', now()->subDays(7))
            ->get();

        return view('dashboard', compact('triagem', 'status', 'nome', 'data_inicio', 'data_fim', 'aniversariantes', 'alertasTriagem'));
    }

    /**
     * Exibe os detalhes de uma criança para triagem.
     */
    public function show($id)
    {
        $crianca = Crianca::with('responsavel')->findOrFail($id);
        
        return view('triagem.show', compact('crianca'));
    }

    /**
     * Atualiza o status da triagem (Aprovar/Rejeitar).
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:PENDENTE_MATRICULA,PENDENTE_APROVACAO,APROVADA,REJEITADA,PREENCHER',
            'detalhes' => 'nullable|string'
        ]);

        $crianca = Crianca::findOrFail($id);
        $statusAntigo = $crianca->status;
        $crianca->status = $request->status;
        $crianca->save();

        // Registro de Auditoria (LGPD)
        LogAuditoria::create([
            'usuario_id' => Auth::id(),
            'acao' => "Alterou status de {$statusAntigo} para {$request->status}",
            'tabela_afetada' => 'criancas',
            'registro_id' => $crianca->id,
            'detalhes' => $request->detalhes ?? "Alteração manual via dashboard.",
            'data_hora' => now()
        ]);

        $mensagens = [
            'PENDENTE_MATRICULA' => 'Triagem concluída! Criança enviada para fase de matrícula.',
            'APROVADA' => 'Matrícula aprovada com sucesso! Criança agora está na fila de Anamnese.',
            'REJEITADA' => 'Inscrição rejeitada.',
        ];

        $mensagem = $mensagens[$request->status] ?? 'Status atualizado.';
        
        return redirect()->route('dashboard')->with('success', $mensagem);
    }

    /**
     * Gera o PDF de comprovante de pré-inscrição aprovada.
     */
    public function gerarComprovante($id)
    {
        $crianca = Crianca::with('responsavel')->findOrFail($id);

        if ($crianca->status !== 'APROVADA') {
            return redirect()->back()->withErrors(['error' => 'Apenas crianças aprovadas podem gerar comprovante.']);
        }

        $pdf = Pdf::loadView('pdf.comprovante', compact('crianca'));
        
        return $pdf->download("comprovante_{$crianca->nome}.pdf");
    }
}
