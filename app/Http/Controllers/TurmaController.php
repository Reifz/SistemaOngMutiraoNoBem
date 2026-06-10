<?php

namespace App\Http\Controllers;

use App\Models\Turma;
use App\Models\Crianca;
use App\Models\LogAuditoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TurmaController extends Controller
{
    /**
     * Lista todas as turmas.
     */
    public function index()
    {
        $turmas = Turma::withCount('criancas')->get();
        return view('turmas.index', compact('turmas'));
    }

    /**
     * Exibe o formulário de criação de turma.
     */
    public function create()
    {
        return view('turmas.create');
    }

    /**
     * Salva uma nova turma.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'turno' => 'required|string',
            'capacidade' => 'required|integer|min:1',
            'idade_minima' => 'nullable|integer|min:0',
            'idade_maxima' => 'nullable|integer|min:0',
            'ativa' => 'boolean',
        ]);

        $turma = Turma::create($request->all());

        LogAuditoria::create([
            'usuario_id' => Auth::id(),
            'acao' => "Turmas: Criou nova turma",
            'tabela_afetada' => 'turmas',
            'registro_id' => $turma->id,
            'detalhes' => "Turma {$turma->nome} criada.",
            'data_hora' => now()
        ]);

        return redirect()->route('turmas.index')->with('success', 'Turma criada com sucesso!');
    }

    /**
     * Exibe os detalhes de uma turma e a lista de alunos alocados.
     */
    public function show($id)
    {
        $turma = Turma::with('criancas.responsavel')->findOrFail($id);
        
        // Crianças disponíveis para alocação (Status: ANAMNESE_CONCLUIDA ou REMATRICULADA e sem turma)
        $criancasDisponiveis = Crianca::whereIn('status', ['ANAMNESE_CONCLUIDA', 'REMATRICULADA'])
                                      ->whereNull('turma_id')
                                      ->get();

        return view('turmas.show', compact('turma', 'criancasDisponiveis'));
    }

    /**
     * Aloca uma criança na turma.
     */
    public function alocar(Request $request, $id)
    {
        $request->validate([
            'crianca_id' => 'required|exists:criancas,id',
        ]);

        $turma = Turma::findOrFail($id);
        $crianca = Crianca::findOrFail($request->crianca_id);

        // Verificar capacidade
        if ($turma->criancas()->count() >= $turma->capacidade) {
            return redirect()->back()->with('error', 'Esta turma já atingiu a capacidade máxima.');
        }

        $crianca->update([
            'turma_id' => $turma->id,
            'status' => 'EM_TURMA'
        ]);

        LogAuditoria::create([
            'usuario_id' => Auth::id(),
            'acao' => "Turmas: Alocou criança",
            'tabela_afetada' => 'criancas',
            'registro_id' => $crianca->id,
            'detalhes' => "Criança {$crianca->nome} alocada na turma {$turma->nome}.",
            'data_hora' => now()
        ]);

        return redirect()->back()->with('success', "Criança {$crianca->nome} alocada com sucesso!");
    }

    /**
     * Remove uma criança da turma.
     */
    public function removerCrianca(Request $request, $id)
    {
        $request->validate([
            'crianca_id' => 'required|exists:criancas,id',
        ]);

        $turma = Turma::findOrFail($id);
        $crianca = Crianca::findOrFail($request->crianca_id);

        $crianca->update([
            'turma_id' => null,
            'status' => 'ANAMNESE_CONCLUIDA'
        ]);

        LogAuditoria::create([
            'usuario_id' => Auth::id(),
            'acao' => "Turmas: Removeu criança da turma",
            'tabela_afetada' => 'criancas',
            'registro_id' => $crianca->id,
            'detalhes' => "Criança {$crianca->nome} removida da turma {$turma->nome}.",
            'data_hora' => now()
        ]);

        return redirect()->back()->with('success', "Criança removida da turma com sucesso!");
    }

    /**
     * Exibe o formulário de edição de turma.
     */
    public function edit($id)
    {
        $turma = Turma::findOrFail($id);
        return view('turmas.edit', compact('turma'));
    }

    /**
     * Atualiza os dados de uma turma.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'turno' => 'required|string',
            'capacidade' => 'required|integer|min:1',
            'idade_minima' => 'nullable|integer|min:0',
            'idade_maxima' => 'nullable|integer|min:0',
            'ativa' => 'boolean',
        ]);

        $turma = Turma::findOrFail($id);
        $turma->update($request->all());

        LogAuditoria::create([
            'usuario_id' => Auth::id(),
            'acao' => "Turmas: Editou turma",
            'tabela_afetada' => 'turmas',
            'registro_id' => $turma->id,
            'detalhes' => "Dados da turma {$turma->nome} atualizados.",
            'data_hora' => now()
        ]);

        return redirect()->route('turmas.index')->with('success', 'Turma atualizada com sucesso!');
    }

    /**
     * Remove uma turma.
     */
    public function destroy($id)
    {
        $turma = Turma::findOrFail($id);
        $nome = $turma->nome;
        
        // Verificar se há alunos antes de excluir? 
        // Por enquanto deleta.
        $turma->delete();

        LogAuditoria::create([
            'usuario_id' => Auth::id(),
            'acao' => "Turmas: Excluiu turma",
            'tabela_afetada' => 'turmas',
            'registro_id' => $id,
            'detalhes' => "Turma {$nome} removida do sistema.",
            'data_hora' => now()
        ]);

        return redirect()->route('turmas.index')->with('success', 'Turma excluída com sucesso!');
    }
}
