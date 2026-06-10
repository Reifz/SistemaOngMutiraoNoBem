<?php

namespace App\Http\Controllers;

use App\Models\Crianca;
use App\Models\Turma;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class RelatorioController extends Controller
{
    public function evasao(Request $request)
    {
        $dataInicio = $request->input('data_inicio') ? Carbon::parse($request->input('data_inicio')) : Carbon::now()->startOfYear();
        $dataFim = $request->input('data_fim') ? Carbon::parse($request->input('data_fim')) : Carbon::now()->endOfDay();
        $turmaId = $request->input('turma_id');
        $periodo = $request->input('periodo');

        // Consulta base para crianças que estão ou estiveram matriculadas no período
        $queryBase = Crianca::where(function($q) {
            $q->where('status', 'EM_TURMA')
              ->orWhere('status', 'EVADIDA');
        });

        if ($turmaId) {
            $queryBase->where('turma_id', $turmaId);
        }

        if ($periodo) {
            $queryBase->where('periodo_escolar', $periodo);
        }

        // Total de matriculados (Ativos + Evadidos)
        $totalMatriculados = (clone $queryBase)->count();

        // Consulta para evadidos no período
        $queryEvadidos = Crianca::where('status', 'EVADIDA')
            ->whereBetween('data_evasao', [$dataInicio, $dataFim]);

        if ($turmaId) {
            $queryEvadidos->where('turma_id', $turmaId);
        }

        if ($periodo) {
            $queryEvadidos->where('periodo_escolar', $periodo);
        }

        // Contagens por período para os Cards
        $totalEvadidosManha = (clone $queryEvadidos)->where('periodo_escolar', 'Manhã')->count();
        $totalEvadidosTarde = (clone $queryEvadidos)->where('periodo_escolar', 'Tarde')->count();

        // Motivos principais por período
        $motivoPrincipalManha = (clone $queryEvadidos)
            ->where('periodo_escolar', 'Manhã')
            ->select('motivo_evasao', \DB::raw('count(*) as total'))
            ->groupBy('motivo_evasao')
            ->orderBy('total', 'desc')
            ->first();

        $motivoPrincipalTarde = (clone $queryEvadidos)
            ->where('periodo_escolar', 'Tarde')
            ->select('motivo_evasao', \DB::raw('count(*) as total'))
            ->groupBy('motivo_evasao')
            ->orderBy('total', 'desc')
            ->first();

        $evadidos = $queryEvadidos->with(['responsavel'])->orderBy('data_evasao', 'desc')->get();
        $totalEvadidos = $evadidos->count();

        // Cálculo da Taxa
        $taxaEvasao = $totalMatriculados > 0 ? ($totalEvadidos / $totalMatriculados) * 100 : 0;

        // Estatísticas extras
        $turmas = Turma::all();
        $motivoPrincipal = (clone $queryEvadidos)
            ->select('motivo_evasao', \DB::raw('count(*) as total'))
            ->groupBy('motivo_evasao')
            ->orderBy('total', 'desc')
            ->first();

        return view('relatorios.evasao', compact(
            'evadidos', 
            'totalMatriculados', 
            'totalEvadidos', 
            'totalEvadidosManha',
            'totalEvadidosTarde',
            'motivoPrincipalManha',
            'motivoPrincipalTarde',
            'taxaEvasao', 
            'dataInicio', 
            'dataFim', 
            'turmas',
            'turmaId',
            'periodo',
            'motivoPrincipal'
        ));
    }

    /**
     * Gera o PDF do relatório de evasão.
     */
    public function pdf(Request $request)
    {
        $dataInicio = $request->input('data_inicio') ? Carbon::parse($request->input('data_inicio')) : Carbon::now()->startOfYear();
        $dataFim = $request->input('data_fim') ? Carbon::parse($request->input('data_fim')) : Carbon::now()->endOfDay();
        $turmaId = $request->input('turma_id');
        $periodo = $request->input('periodo');

        $queryBase = Crianca::where(function($q) {
            $q->where('status', 'EM_TURMA')
              ->orWhere('status', 'EVADIDA');
        });

        if ($turmaId) {
            $queryBase->where('turma_id', $turmaId);
        }

        if ($periodo) {
            $queryBase->where('periodo_escolar', $periodo);
        }

        $totalMatriculados = (clone $queryBase)->count();

        $queryEvadidos = Crianca::where('status', 'EVADIDA')
            ->whereBetween('data_evasao', [$dataInicio, $dataFim]);

        if ($turmaId) {
            $queryEvadidos->where('turma_id', $turmaId);
        }

        if ($periodo) {
            $queryEvadidos->where('periodo_escolar', $periodo);
        }

        $evadidos = $queryEvadidos->with(['responsavel'])->orderBy('data_evasao', 'desc')->get();
        $totalEvadidos = $evadidos->count();

        $taxaEvasao = $totalMatriculados > 0 ? ($totalEvadidos / $totalMatriculados) * 100 : 0;

        $motivoPrincipal = (clone $queryEvadidos)
            ->select('motivo_evasao', \DB::raw('count(*) as total'))
            ->groupBy('motivo_evasao')
            ->orderBy('total', 'desc')
            ->first();

        $turmaNome = $turmaId ? Turma::find($turmaId)->nome : 'Todas as Turmas';
        $periodoNome = $periodo ?? 'Todos';

        $pdf = Pdf::loadView('pdf.relatorio_evasao', compact(
            'evadidos', 
            'totalMatriculados', 
            'totalEvadidos', 
            'taxaEvasao', 
            'dataInicio', 
            'dataFim', 
            'turmaNome',
            'periodoNome',
            'motivoPrincipal'
        ));

        return $pdf->download("relatorio_evasao_" . now()->format('d_m_Y') . ".pdf");
    }
}
