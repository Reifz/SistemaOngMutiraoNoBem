<?php

namespace App\Http\Controllers;

use App\Models\Crianca;
use App\Models\LogAuditoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnamneseController extends Controller
{
    /**
     * Lista crianças aptas para Anamnese.
     */
    public function index(Request $request)
    {
        if ($request->isMethod('post')) {
            if ($request->has('clear')) {
                session()->forget(['ana_filtro_status', 'ana_filtro_nome', 'ana_filtro_data_inicio', 'ana_filtro_data_fim']);
            } else {
                session([
                    'ana_filtro_status' => $request->get('status', 'APROVADA'),
                    'ana_filtro_nome' => $request->get('nome'),
                    'ana_filtro_data_inicio' => $request->get('data_inicio'),
                    'ana_filtro_data_fim' => $request->get('data_fim')
                ]);
            }
            return redirect()->route('anamnese.index');
        }

        $status = session('ana_filtro_status', 'APROVADA');
        $nome = session('ana_filtro_nome');
        $data_inicio = session('ana_filtro_data_inicio');
        $data_fim = session('ana_filtro_data_fim');

        $query = Crianca::with('responsavel');

        if ($status && $status !== 'TODOS') {
            $query->where('status', $status);
        } else {
            $query->whereIn('status', [
                'APROVADA', 
                'PENDENTE_REMATRICULA_ANAMNESE', 
                'ANAMNESE_CONCLUIDA', 
                'REMATRICULADA', 
                'EM_TURMA', 
                'EVADIDA'
            ]);
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

        $anamneses = $query->paginate(10);

        return view('anamnese.index', compact('anamneses', 'status', 'nome', 'data_inicio', 'data_fim'));
    }

    /**
     * Exibe o formulário de Anamnese.
     */
    public function formulario($id)
    {
        $crianca = Crianca::with('responsavel')->findOrFail($id);
        
        // Verifica se já existe anamnese para pré-carregar
        $anamnese = \App\Models\Anamnese::where('crianca_id', $id)->first();
        $dados = $anamnese ? $anamnese->dados_json : [];

        return view('anamnese.formulario', compact('crianca', 'dados'));
    }

    /**
     * Salva ou atualiza os dados da Anamnese.
     */
    public function store(Request $request, $id)
    {
        $crianca = Crianca::findOrFail($id);
        $anoAtual = \App\Models\AnoLetivo::atual();
        
        // Coleta todos os campos exceto o token CSRF
        $dados = $request->except(['_token']);

        // Salva ou atualiza a Anamnese para o ano atual
        \App\Models\Anamnese::updateOrCreate(
            [
                'crianca_id' => $crianca->id,
                'ano_letivo_id' => $anoAtual ? $anoAtual->id : null
            ],
            ['dados_json' => $dados]
        );

        // Se o status era APROVADA ou PENDENTE_REMATRICULA_ANAMNESE, muda para o status de conclusão correspondente
        if ($crianca->status === 'APROVADA') {
            $crianca->status = 'ANAMNESE_CONCLUIDA';
            $crianca->save();
        } elseif ($crianca->status === 'PENDENTE_REMATRICULA_ANAMNESE') {
            $crianca->status = 'REMATRICULADA';
            $crianca->save();
        }

        LogAuditoria::create([
            'usuario_id' => Auth::id(),
            'acao' => "Saúde: Salvou/Editou Anamnese (" . ($anoAtual ? $anoAtual->ano : 'N/A') . ")",
            'tabela_afetada' => 'criancas',
            'registro_id' => $crianca->id,
            'detalhes' => "Dados de saúde salvos para o ano letivo atual.",
            'data_hora' => now()
        ]);

        return redirect()->route('anamnese.index')->with('success', 'Anamnese salva com sucesso!');
    }

    /**
     * Exibe os dados da Anamnese.
     */
    public function show($id)
    {
        $crianca = Crianca::with('responsavel')->findOrFail($id);
        $anoAtual = \App\Models\AnoLetivo::atual();

        $anamnese = \App\Models\Anamnese::where('crianca_id', $id)
            ->where('ano_letivo_id', $anoAtual ? $anoAtual->id : null)
            ->firstOrFail();
            
        $dados = $anamnese->dados_json;

        return view('anamnese.show', compact('crianca', 'dados'));
    }

    /**
     * Exibe o formulário de edição da Anamnese.
     */
    public function edit($id)
    {
        $crianca = Crianca::with('responsavel')->findOrFail($id);
        $anoAtual = \App\Models\AnoLetivo::atual();

        $anamnese = \App\Models\Anamnese::where('crianca_id', $id)
            ->where('ano_letivo_id', $anoAtual ? $anoAtual->id : null)
            ->firstOrFail();

        $dados = $anamnese->dados_json;

        return view('anamnese.formulario', compact('crianca', 'dados'));
    }

    /**
     * Gera o PDF da Anamnese.
     */
    public function pdf($id)
    {
        $crianca = Crianca::with('responsavel')->findOrFail($id);
        $anoAtual = \App\Models\AnoLetivo::atual();

        $anamnese = \App\Models\Anamnese::where('crianca_id', $id)
            ->where('ano_letivo_id', $anoAtual ? $anoAtual->id : null)
            ->firstOrFail();

        $dados = $anamnese->dados_json;

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('anamnese.pdf', compact('crianca', 'dados'));
        
        LogAuditoria::create([
            'usuario_id' => Auth::id(),
            'acao' => "Saúde: Exportou PDF Anamnese",
            'tabela_afetada' => 'criancas',
            'registro_id' => $crianca->id,
            'detalhes' => "PDF de saúde gerado.",
            'data_hora' => now()
        ]);

        return $pdf->download("anamnese_{$crianca->nome}.pdf");
    }
}
