<?php

namespace App\Http\Controllers;

use App\Models\Crianca;
use App\Models\Turma;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PesquisaController extends Controller
{
    /**
     * Exibe a tela de pesquisa geral.
     */
    public function index(Request $request)
    {
        $nome = $request->input('nome');
        $turma_id = $request->input('turma_id');

        $query = Crianca::with(['turma', 'responsavel']);

        if ($nome) {
            $query->where('nome', 'like', "%{$nome}%");
        }

        if ($turma_id) {
            $query->where('turma_id', $turma_id);
        }

        $criancas = $query->orderBy('nome', 'asc')->paginate(15);
        $turmas = Turma::where('ativa', true)->orderBy('nome', 'asc')->get();

        return view('pesquisa', compact('criancas', 'turmas', 'nome', 'turma_id'));
    }

    /**
     * Gera o PDF da listagem filtrada.
     */
    public function pdf(Request $request)
    {
        $nome = $request->input('nome');
        $turma_id = $request->input('turma_id');

        $query = Crianca::with(['turma', 'responsavel.contatos']);

        if ($nome) {
            $query->where('nome', 'like', "%{$nome}%");
        }

        if ($turma_id) {
            $query->where('turma_id', $turma_id);
        }

        $criancas = $query->orderBy('nome', 'asc')->get();
        $turma = $turma_id ? Turma::find($turma_id) : null;

        $pdf = Pdf::loadView('pdf.listagem_criancas', compact('criancas', 'turma', 'nome'));
        
        // Configura papel A4 em paisagem para caber mais colunas se necessário
        $pdf->setPaper('a4', 'landscape');

        return $pdf->download("listagem_criancas_" . now()->format('d_m_Y') . ".pdf");
    }
}
