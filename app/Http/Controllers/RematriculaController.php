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
        $podeIniciarRematricula = false;

        if ($anoAtual && $anoAtual->data_virada) {
            $podeIniciarRematricula = now()->greaterThanOrEqualTo($anoAtual->data_virada);
        }

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

        $criancas = collect();
        if ($anoAtual) {
            $anoAnterior = AnoLetivo::where('ano', '<', $anoAtual->ano)
                ->orderByDesc('ano')
                ->first();

            $query = Crianca::with(['matriculas.anoLetivo', 'matriculas.turma', 'responsavel']);

            // REGRA: Apenas crianças que precisam de rematrícula.
            // 1. Devem ter matrícula ativa (concluída) com status 'EM_TURMA' em algum ano letivo anterior.
            if ($anoAnterior) {
                $query->whereHas('matriculas', function($q) use ($anoAnterior) {
                    $q->where('ano_letivo_id', $anoAnterior->id)
                        ->where('status', 'EM_TURMA');
                });
            } else {
                $query->whereRaw('1 = 0');
            }

            // 2. Não devem estar totalmente concluídas ou evadidas no ano letivo atual
            $query->where(function($q) use ($anoAtual) {
                $q->whereDoesntHave('matriculas', function($sub) use ($anoAtual) {
                    $sub->where('ano_letivo_id', $anoAtual->id);
                })
                ->orWhereHas('matriculas', function($sub) use ($anoAtual) {
                    $sub->where('ano_letivo_id', $anoAtual->id)
                        ->whereIn('status', [
                            'PENDENTE_REMATRICULA_MATRICULA',
                            'PENDENTE_REMATRICULA_ANAMNESE',
                            'REMATRICULADA'
                        ]);
                });
            });

            if ($nome) {
                $query->where('nome', 'like', "%{$nome}%");
            }

            if ($status && $status !== 'TODOS') {
                if ($status === 'SEM_MATRICULA') {
                    $query->whereDoesntHave('matriculas', function($q) use ($anoAtual) {
                        $q->where('ano_letivo_id', $anoAtual->id);
                    });
                } else {
                    $query->whereHas('matriculas', function($q) use ($anoAtual, $status) {
                        $q->where('ano_letivo_id', $anoAtual->id)->where('status', $status);
                    });
                }
            }

            $criancas = $query->orderBy('nome')->paginate(15);
        }

        $anosLetivos = AnoLetivo::orderBy('ano', 'desc')->get();

        return view('rematricula.index', compact('criancas', 'anoAtual', 'anosLetivos', 'status', 'nome', 'podeIniciarRematricula'));
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

    public function iniciar(Request $request, $id)
    {
        $request->validate([
            'ano_letivo_id' => 'required|exists:anos_letivos,id'
        ]);

        try {
            $crianca = Crianca::findOrFail($id);
            $anoDestino = AnoLetivo::findOrFail($request->ano_letivo_id);

            if (!$anoDestino->status_ativo) {
                return back()->with('error', 'A rematrÃ­cula somente pode ser iniciada para o ano letivo ativo.');
            }

            // Verifica se a data de virada já foi atingida
            if ($anoDestino->data_virada && now()->lessThan($anoDestino->data_virada)) {
                return back()->with('error', 'O período de rematrícula para o ano ' . $anoDestino->ano . ' ainda não começou (início em ' . $anoDestino->data_virada->format('d/m/Y') . ').');
            }

            // Verifica se já existe matrícula para este ano
            $existe = Matricula::where('crianca_id', $id)
                ->where('ano_letivo_id', $anoDestino->id)
                ->exists();

            if ($existe) {
                return back()->with('error', 'Esta criança já possui matrícula iniciada para o ano ' . $anoDestino->ano);
            }

            // Busca a última matrícula (do ano anterior ou mais recente)
            $anoAnterior = AnoLetivo::where('ano', '<', $anoDestino->ano)
                ->orderByDesc('ano')
                ->first();

            $ultimaMatricula = $anoAnterior
                ? $crianca->matriculas()
                    ->where('ano_letivo_id', $anoAnterior->id)
                    ->where('status', 'EM_TURMA')
                    ->first()
                : null;

            if (!$ultimaMatricula) {
                return back()->with('error', 'Esta crianÃ§a nÃ£o concluiu o ano letivo anterior em uma turma e nÃ£o estÃ¡ apta para rematrÃ­cula.');
            }

            // Cria nova matrícula clonando dados básicos do ano anterior
            DB::beginTransaction();

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

            $crianca->status = 'PENDENTE_REMATRICULA_MATRICULA';
            $crianca->turma_id = null;
            $crianca->save();

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

    /**
     * Confirma os dados de matrícula do ano ativo sem alterações.
     */
    public function confirmarDados($id)
    {
        $crianca = Crianca::findOrFail($id);
        $anoAtual = AnoLetivo::atual();

        if (!$anoAtual) {
            return back()->with('error', 'Não há ano letivo ativo.');
        }

        $matricula = $crianca->matriculas()->where('ano_letivo_id', $anoAtual->id)->first();
        if (!$matricula) {
            return back()->with('error', 'Matrícula não iniciada para este ano.');
        }

        if ($matricula->status !== 'PENDENTE_REMATRICULA_MATRICULA') {
            return back()->with('error', 'Esta criança não está na etapa de confirmação de matrícula.');
        }

        DB::beginTransaction();
        try {
            $matricula->status = 'PENDENTE_REMATRICULA_ANAMNESE';
            $matricula->save();

            $crianca->status = 'PENDENTE_REMATRICULA_ANAMNESE';
            $crianca->save();

            LogAuditoria::create([
                'usuario_id' => Auth::id(),
                'acao' => "Rematrícula: Dados confirmados sem alterações",
                'tabela_afetada' => 'criancas',
                'registro_id' => $crianca->id,
                'detalhes' => "Matrícula confirmada para o ano letivo " . $anoAtual->ano . ". Avançou para Anamnese.",
                'data_hora' => now()
            ]);

            DB::commit();
            return redirect()->route('rematricula.index')->with('success', 'Dados de matrícula de ' . $crianca->nome . ' confirmados com sucesso! Siga para a etapa de Anamnese.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Erro ao confirmar dados: ' . $e->getMessage());
        }
    }

    /**
     * Confirma a anamnese de saúde do ano ativo sem alterações.
     */
    public function confirmarAnamnese($id)
    {
        $crianca = Crianca::findOrFail($id);
        $anoAtual = AnoLetivo::atual();

        if (!$anoAtual) {
            return back()->with('error', 'Não há ano letivo ativo.');
        }

        $matricula = $crianca->matriculas()->where('ano_letivo_id', $anoAtual->id)->first();
        if (!$matricula) {
            return back()->with('error', 'Matrícula não iniciada para este ano.');
        }

        if ($matricula->status !== 'PENDENTE_REMATRICULA_ANAMNESE') {
            return back()->with('error', 'Esta criança não está na etapa de confirmação de anamnese.');
        }

        DB::beginTransaction();
        try {
            // Tenta pegar a anamnese do ano atual
            $anamneseAtual = \App\Models\Anamnese::where('crianca_id', $crianca->id)
                ->where('ano_letivo_id', $anoAtual->id)
                ->first();

            if (!$anamneseAtual) {
                // Tenta buscar a mais recente de anos anteriores para clonar
                $anamneseAnterior = \App\Models\Anamnese::where('crianca_id', $crianca->id)
                    ->where('ano_letivo_id', '!=', $anoAtual->id)
                    ->orderBy('id', 'desc')
                    ->first();

                \App\Models\Anamnese::create([
                    'crianca_id' => $crianca->id,
                    'ano_letivo_id' => $anoAtual->id,
                    'dados_json' => $anamneseAnterior ? $anamneseAnterior->dados_json : []
                ]);
            }

            $matricula->status = 'REMATRICULADA';
            $matricula->save();

            $crianca->status = 'REMATRICULADA';
            $crianca->save();

            LogAuditoria::create([
                'usuario_id' => Auth::id(),
                'acao' => "Rematrícula: Anamnese confirmada sem alterações",
                'tabela_afetada' => 'criancas',
                'registro_id' => $crianca->id,
                'detalhes' => "Anamnese de saúde confirmada para o ano letivo " . $anoAtual->ano . ". Criança apta para alocação de turma.",
                'data_hora' => now()
            ]);

            DB::commit();
            return redirect()->route('rematricula.index')->with('success', 'Anamnese de ' . $crianca->nome . ' confirmada com sucesso! A criança agora está apta para alocação em turma.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Erro ao confirmar anamnese: ' . $e->getMessage());
        }
    }
}
