<?php

namespace App\Http\Controllers;

use App\Models\Crianca;
use App\Models\Matricula;
use App\Models\AnoLetivo;
use App\Models\LogAuditoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RematriculaController extends Controller
{
    /**
     * Lista as crianças para gestão de rematrícula no ano atual.
     */
    public function index(Request $request)
    {
        $anoAtual = AnoLetivo::atual();
        
        if ($request->isMethod('post') && !$request->has('ano')) { // Filtros
            if ($request->has('clear')) {
                session()->forget(['remat_filtro_status', 'remat_filtro_nome']);
            } else {
                session([
                    'remat_filtro_status' => $request->get('status'),
                    'remat_filtro_nome' => $request->get('nome'),
                ]);
            }
            return redirect()->route('rematricula.index');
        }

        $status = session('remat_filtro_status');
        $nome = session('remat_filtro_nome');

        $query = Crianca::with(['matriculas' => function($q) use ($anoAtual) {
            if ($anoAtual) {
                $q->where('ano_letivo_id', $anoAtual->id);
            }
        }, 'responsavel', 'turma']);

        if ($nome) {
            $query->where('nome', 'like', "%{$nome}%");
        }

        if ($status && $status !== 'TODOS' && $anoAtual) {
            $query->whereHas('matriculas', function($q) use ($anoAtual, $status) {
                $q->where('ano_letivo_id', $anoAtual->id)->where('status', $status);
            });
        }

        $criancas = $query->orderBy('nome')->paginate(15);
        $anosLetivos = AnoLetivo::orderBy('ano', 'desc')->get();

        return view('rematricula.index', compact('criancas', 'anoAtual', 'anosLetivos', 'status', 'nome'));
    }

    /**
     * Exibe a tela de gestão de períodos (Anos Letivos).
     */
    public function anosIndex()
    {
        $anosLetivos = AnoLetivo::orderBy('ano', 'desc')->get();
        return view('rematricula.anos.index', compact('anosLetivos'));
    }

    /**
     * Cria um novo ano letivo com data de virada.
     */
    public function storeAno(Request $request)
    {
        $request->validate([
            'ano' => 'required|integer|unique:anos_letivos,ano',
            'data_virada' => 'required|date',
        ]);

        AnoLetivo::create([
            'ano' => $request->ano,
            'data_virada' => $request->data_virada,
            'status_ativo' => false,
        ]);

        return redirect()->route('rematricula.anos.index')->with('success', 'Ano letivo ' . $request->ano . ' criado com sucesso!');
    }

    /**
     * Define um ano letivo como ativo.
     */
    public function ativarAno($id)
    {
        $exitCode = \Illuminate\Support\Facades\Artisan::call('app:set-active-year', ['id' => $id]);

        if ($exitCode === 0) {
            return back()->with('success', 'Ano letivo ativado e dados sincronizados com sucesso!');
        }

        return back()->with('error', 'Falha ao ativar o ano letivo.');
    }

    /**
     * Inicia o processo de rematrícula para uma criança em um novo ano.
     */
    public function iniciar(Request $request, $id)
    {
        $request->validate([
            'ano_letivo_id' => 'required|exists:anos_letivos,id'
        ]);

        try {
            $crianca = Crianca::findOrFail($id);
            $anoDestino = AnoLetivo::findOrFail($request->ano_letivo_id);

            // Verifica se já existe matrícula para este ano
            $existe = Matricula::where('crianca_id', $id)
                ->where('ano_letivo_id', $anoDestino->id)
                ->exists();

            if ($existe) {
                return back()->with('error', 'Esta criança já possui matrícula iniciada para o ano ' . $anoDestino->ano);
            }

            DB::beginTransaction();

            // Busca a última matrícula (do ano anterior ou mais recente)
            $ultimaMatricula = $crianca->matriculas()->orderBy('id', 'desc')->first();

            // Cria nova matrícula clonando dados básicos do ano anterior
            Matricula::create([
                'crianca_id' => $crianca->id,
                'ano_letivo_id' => $anoDestino->id,
                'turma_id' => null, // Nova turma deve ser alocada
                'escola' => $ultimaMatricula ? $ultimaMatricula->escola : $crianca->escola,
                'tipo_escola' => $ultimaMatricula ? $ultimaMatricula->tipo_escola : $crianca->tipo_escola,
                'serie' => $ultimaMatricula ? $ultimaMatricula->serie : $crianca->serie,
                'periodo_escolar' => $ultimaMatricula ? $ultimaMatricula->periodo_escolar : $crianca->periodo_escolar,
                'periodo_ong' => $ultimaMatricula ? $ultimaMatricula->periodo_ong : $crianca->periodo_ong,
                'status' => 'PENDENTE_REMATRICULA_MATRICULA',
            ]);

            LogAuditoria::create([
                'usuario_id' => Auth::id(),
                'acao' => "Rematrícula: Iniciada para o ano " . $anoDestino->ano,
                'tabela_afetada' => 'criancas',
                'registro_id' => $crianca->id,
                'detalhes' => "Processo de rematrícula iniciado. Status: PENDENTE_REMATRICULA_MATRICULA.",
                'data_hora' => now()
            ]);

            DB::commit();
            return back()->with('success', 'Rematrícula iniciada com sucesso para ' . $crianca->nome);

        } catch (\Exception $e) {
            if (DB::transactionLevel() > 0) {
                DB::rollBack();
            }

            return back()->with('error', 'Erro ao iniciar rematrícula: ' . $e->getMessage());
        }
    }
}
