<?php

namespace App\Http\Controllers;

use App\Models\Crianca;
use App\Models\Responsavel;
use App\Models\LogAuditoria;
use App\Models\Moradia;
use App\Models\Familiar;
use App\Models\Contato;
use App\Models\CriancaResponsavel;
use App\Models\Mensagem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class MatriculaController extends Controller
{
    /**
     * Lista as matrículas em andamento ou para aprovação.
     */
    public function index(Request $request)
    {
        if ($request->isMethod('post')) {
            if ($request->has('clear')) {
                session()->forget(['mat_filtro_status', 'mat_filtro_nome', 'mat_filtro_data_inicio', 'mat_filtro_data_fim']);
            } else {
                session([
                    'mat_filtro_status' => $request->get('status', 'PENDENTE_MATRICULA'),
                    'mat_filtro_nome' => $request->get('nome'),
                    'mat_filtro_data_inicio' => $request->get('data_inicio'),
                    'mat_filtro_data_fim' => $request->get('data_fim'),
                ]);
            }
            return redirect()->route('matricula.index');
        }

        $status = session('mat_filtro_status', 'PENDENTE_MATRICULA');
        $nome = session('mat_filtro_nome');
        $data_inicio = session('mat_filtro_data_inicio');
        $data_fim = session('mat_filtro_data_fim');

        $query = Crianca::with('responsavel');

        if ($status && $status !== 'TODOS') {
            $query->where('status', $status);
        } else {
            $query->whereIn('status', [
                'PENDENTE_MATRICULA', 
                'PENDENTE_REMATRICULA_MATRICULA', 
                'PENDENTE_APROVACAO', 
                'PENDENTE_REMATRICULA_APROVACAO', 
                'APROVADA', 
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

        $matriculas = $query->orderBy('updated_at', 'desc')->paginate(10);

        return view('matricula.index', compact('matriculas', 'status', 'nome', 'data_inicio', 'data_fim'));
    }

    /**
     * Exibe o formulário de preenchimento (Censo).
     */
    public function formulario($id)
    {
        $crianca = Crianca::with('responsavel')->findOrFail($id);
        if ($crianca->status !== 'PENDENTE_MATRICULA' && $crianca->status !== 'PENDENTE_REMATRICULA_MATRICULA') {
            return redirect()->route('matricula.index')->with('error', 'Esta criança não está em fase de preenchimento.');
        }
        return view('matricula.formulario', compact('crianca'));
    }

    /**
     * Salva os dados completos da Matrícula (Mapeamento Pesado).
     */
    public function store(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $crianca = Crianca::with('responsavel')->findOrFail($id);

            // Determinar o próximo status baseado no atual
            $proximoStatus = ($crianca->status === 'PENDENTE_REMATRICULA_MATRICULA') 
                ? 'PENDENTE_REMATRICULA_APROVACAO' 
                : 'PENDENTE_APROVACAO';

            // 1. ATUALIZAR CRIANÇA
            $crianca->update([
                'nome' => $request->crianca_nome,
                'idade' => $request->crianca_idade,
                'sexo' => $request->crianca_sexo,
                'cor_raca' => $request->crianca_cor_raca,
                'data_nascimento' => $request->crianca_data_nascimento,
                'data_inscricao' => $request->crianca_data_inscricao,
                'data_matricula' => $request->crianca_data_matricula,
                'data_desligamento' => $request->crianca_data_desligamento,
                'motivo_desligamento' => $request->crianca_motivo_desligamento,
                'esta_na_escola' => $request->crianca_esta_na_escola,
                'escola' => $request->crianca_escola,
                'tipo_escola' => $request->crianca_tipo_escola,
                'serie' => $request->crianca_serie,
                'periodo_escolar' => $request->crianca_periodo_escolar,
                'certidao_nascimento' => $request->crianca_certidao_nascimento,
                'certidao_folha' => $request->crianca_certidao_folha,
                'certidao_livro' => $request->crianca_certidao_livro,
                'cpf' => $request->crianca_cpf,
                'rg' => $request->crianca_rg,
                'possui_deficiencia' => $request->has('crianca_possui_deficiencia'),
                'naturalidade' => $request->crianca_naturalidade,
                'status' => $proximoStatus,
            ]);

            // Sincronizar com tabela Matriculas (Fase 6)
            $anoAtual = \App\Models\AnoLetivo::atual();
            if ($anoAtual) {
                \App\Models\Matricula::updateOrCreate(
                    ['crianca_id' => $crianca->id, 'ano_letivo_id' => $anoAtual->id],
                    [
                        'escola' => $request->crianca_escola,
                        'tipo_escola' => $request->crianca_tipo_escola,
                        'serie' => $request->crianca_serie,
                        'periodo_escolar' => $request->crianca_periodo_escolar,
                        'status' => $proximoStatus,
                        'data_matricula' => $request->crianca_data_matricula,
                    ]
                );
            }

            // 2. TRATAR MÃE (Se preenchido)
            if ($request->mae_nome) {
                $mae = Responsavel::updateOrCreate(
                    ['nome' => $request->mae_nome], 
                    [
                        'email' => 'mae_' . uniqid() . '@multiraobem.org.br', // Email fictício para satisfazer restrição DB
                        'telefone' => '0000000000', // Telefone fictício
                        'idade' => $request->mae_idade,
                        'data_nascimento' => $request->mae_data_nascimento,
                        'profissao' => $request->mae_profissao,
                        'desempregado' => $request->mae_desempregada == '1',
                    ]
                );
                CriancaResponsavel::updateOrCreate(
                    ['crianca_id' => $crianca->id, 'parentesco' => 'MAE'],
                    ['responsavel_id' => $mae->id, 'principal' => false]
                );
            }

            // 3. TRATAR PAI (Se preenchido)
            if ($request->pai_nome) {
                $pai = Responsavel::updateOrCreate(
                    ['nome' => $request->pai_nome],
                    [
                        'email' => 'pai_' . uniqid() . '@multiraobem.org.br', // Email fictício
                        'telefone' => '0000000000', // Telefone fictício
                        'idade' => $request->pai_idade,
                        'data_nascimento' => $request->pai_data_nascimento,
                        'profissao' => $request->pai_profissao,
                        'desempregado' => $request->pai_desempregado == '1',
                    ]
                );
                CriancaResponsavel::updateOrCreate(
                    ['crianca_id' => $crianca->id, 'parentesco' => 'PAI'],
                    ['responsavel_id' => $pai->id, 'principal' => false]
                );
            }

            // 4. ATUALIZAR RESPONSÁVEL PRINCIPAL (Com quem mora)
            $responsavelPrincipal = $crianca->responsavel;
            $responsavelPrincipal->update([
                'nome' => $request->responsavel_nome,
                'parentesco' => $request->responsavel_parentesco,
                'estado_civil' => $request->responsavel_estado_civil,
                'data_nascimento' => $request->responsavel_data_nascimento,
                'idade' => $request->responsavel_idade,
                'grau_instrucao' => $request->responsavel_grau_instrucao,
                'cpf' => $request->responsavel_cpf,
                'rg' => $request->responsavel_rg,
                'tem_cadastro_unico' => $request->has('responsavel_tem_cadastro_unico'),
                'recebe_transferencia_renda' => $request->has('responsavel_recebe_transferencia_renda'),
                'recebe_bpc' => $request->has('responsavel_recebe_bpc'),
            ]);

            // Vincular como principal na pivot se ainda não estiver
            CriancaResponsavel::updateOrCreate(
                ['crianca_id' => $crianca->id, 'responsavel_id' => $responsavelPrincipal->id],
                ['parentesco' => $request->responsavel_parentesco, 'principal' => true]
            );

            // 5. TRATAR CONTATOS DO RESPONSÁVEL
            $tiposContatos = [
                'contato_celular' => 'CELULAR',
                'contato_residencia' => 'RESIDENCIA',
                'contato_trabalho' => 'TRABALHO',
                'contato_outro_1' => 'OUTRO',
                'contato_outro_2' => 'OUTRO',
                'contato_recado' => 'RECADO'
            ];

            foreach ($tiposContatos as $input => $tipo) {
                if ($request->has($input) && $request->$input) {
                    Contato::updateOrCreate(
                        ['responsavel_id' => $responsavelPrincipal->id, 'tipo' => $tipo, 'numero' => $request->$input],
                        ['pessoa_contato' => ($input == 'contato_recado' || $input == 'contato_pessoa_nome') ? $request->contato_pessoa_nome : null]
                    );
                }
            }

            // 6. TRATAR MORADIA
            Moradia::updateOrCreate(
                ['crianca_id' => $crianca->id],
                [
                    'endereco' => $request->moradia_endereco,
                    'complemento' => $request->moradia_complemento,
                    'cep' => $request->moradia_cep,
                    'bairro' => $request->moradia_bairro,
                    'ponto_referencia' => $request->moradia_ponto_referencia,
                    'situacao_habitacional' => $request->moradia_situacao_habitacional,
                    'numero_comodos' => $request->moradia_numero_comodos,
                    'numero_moradores' => $request->moradia_numero_moradores,
                    'condicao_moradia' => $request->moradia_condicao_moradia,
                ]
            );

            // 7. TRATAR FAMILIARES (Processar múltiplos familiares)
            if ($request->has('familiares') && is_array($request->familiares)) {
                foreach ($request->familiares as $fData) {
                    if (!empty($fData['nome'])) {
                        Familiar::create([
                            'crianca_id' => $crianca->id,
                            'nome' => $fData['nome'],
                            'data_nascimento' => $fData['data_nascimento'],
                            'grau_parentesco' => $fData['parentesco'],
                            'grau_instrucao' => $fData['grau_instrucao'],
                            'estuda' => ($fData['estuda'] ?? '0') == '1',
                            'inserido_cca' => ($fData['inserido_cca'] ?? '0') == '1',
                            'profissao' => $fData['profissao'],
                            'renda' => $fData['renda'] ?? 0,
                            'fatores_risco' => $fData['fatores_risco'],
                        ]);
                    }
                }
            } elseif ($request->familiar_nome) {
                // Fallback para o formato antigo caso algum form ainda não tenha sido atualizado
                Familiar::create([
                    'crianca_id' => $crianca->id,
                    'nome' => $request->familiar_nome,
                    'data_nascimento' => $request->familiar_data_nascimento,
                    'grau_parentesco' => $request->familiar_parentesco,
                    'grau_instrucao' => $request->familiar_grau_instrucao,
                    'estuda' => $request->familiar_estuda == '1',
                    'inserido_cca' => $request->familiar_inserido_cca == '1',
                    'profissao' => $request->familiar_profissao,
                    'renda' => $request->familiar_renda ?? 0,
                    'fatores_risco' => $request->familiar_fatores_risco,
                ]);
            }

            // 8. TRATAR ANEXOS
            if ($request->hasFile('anexo_rg_responsavel')) {
                $path = $request->file('anexo_rg_responsavel')->store('anexos/responsaveis', 'public');
                $responsavelPrincipal->update(['anexo_rg' => $path]);
            }
            if ($request->hasFile('anexo_certidao')) {
                $path = $request->file('anexo_certidao')->store('anexos/criancas', 'public');
                $crianca->update(['anexo_certidao' => $path]);
            }
            if ($request->hasFile('anexo_excel_matricula')) {
                $path = $request->file('anexo_excel_matricula')->store('anexos/criancas/excel', 'public');
                $crianca->update(['anexo_excel_matricula' => $path]);
            }
            if ($request->hasFile('anexo_rg_crianca')) {
                $path = $request->file('anexo_rg_crianca')->store('anexos/criancas', 'public');
                $crianca->update(['anexo_rg' => $path]);
            }
            if ($request->hasFile('anexo_cpf_crianca')) {
                $path = $request->file('anexo_cpf_crianca')->store('anexos/criancas', 'public');
                $crianca->update(['anexo_cpf' => $path]);
            }
            if ($request->hasFile('anexo_comprovante_residencia')) {
                $path = $request->file('anexo_comprovante_residencia')->store('anexos/criancas', 'public');
                $crianca->update(['anexo_comprovante_residencia' => $path]);
            }
            if ($request->hasFile('anexo_comprovante_escolaridade')) {
                $path = $request->file('anexo_comprovante_escolaridade')->store('anexos/criancas', 'public');
                $crianca->update(['anexo_comprovante_escolaridade' => $path]);
            }
            if ($request->hasFile('anexo_comprovante_renda')) {
                $path = $request->file('anexo_comprovante_renda')->store('anexos/criancas', 'public');
                $crianca->update(['anexo_comprovante_renda' => $path]);
            }

            LogAuditoria::create([
                'usuario_id' => Auth::id(),
                'acao' => "Matrícula: Finalizou preenchimento completo",
                'tabela_afetada' => 'criancas',
                'registro_id' => $crianca->id,
                'detalhes' => "Dados detalhados (Criança, Mãe, Pai, Familiares, Moradia, Contatos) inseridos.",
                'data_hora' => now()
            ]);


            DB::commit();
 
            return redirect()->route('matricula.index')->with('success', 'Matrícula completa enviada para aprovação final!');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erro ao salvar matrícula: ' . $e->getMessage());
            return back()->with('error', 'Erro ao salvar matrícula: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Visualiza os dados da matrícula (Ponto 3).
     */
    public function show($id)
    {
        $crianca = Crianca::with([
            'responsavel.contatos', 
            'moradia', 
            'familiares', 
            'responsaveis', // Mãe e Pai via pivot
            'logsAuditoria.usuario'
        ])->findOrFail($id);

        $mensagens = Mensagem::with('remetente', 'destinatario')
            ->where('crianca_id', $id)
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('matricula.show', compact('crianca', 'mensagens'));
    }

    /**
     * Exibe o histórico completo de logs da criança.
     */
    public function historico($id)
    {
        $crianca = Crianca::with(['logsAuditoria.usuario', 'anamnese'])->findOrFail($id);
        return view('matricula.historico', compact('crianca'));
    }

    /**
     * Edita os dados da matrícula (Ponto 3).
     */
    public function edit($id)
    {
        $crianca = Crianca::with(['responsavel', 'moradia'])->findOrFail($id);
        return view('matricula.edit', compact('crianca'));
    }

    /**
     * Atualiza os dados da matrícula (Ponto 3).
     */
    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $crianca = Crianca::with(['responsavel', 'responsaveis', 'moradia', 'familiares'])->findOrFail($id);

            // 1. ATUALIZAR CRIANÇA
            $crianca->update([
                'nome' => $request->crianca_nome,
                'idade' => $request->crianca_idade,
                'sexo' => $request->crianca_sexo,
                'cor_raca' => $request->crianca_cor_raca,
                'data_nascimento' => $request->crianca_data_nascimento,
                'data_inscricao' => $request->crianca_data_inscricao,
                'data_matricula' => $request->crianca_data_matricula,
                'data_desligamento' => $request->crianca_data_desligamento,
                'motivo_desligamento' => $request->crianca_motivo_desligamento,
                'esta_na_escola' => $request->crianca_esta_na_escola,
                'escola' => $request->crianca_escola,
                'tipo_escola' => $request->crianca_tipo_escola,
                'serie' => $request->crianca_serie,
                'periodo_escolar' => $request->crianca_periodo_escolar,
                'certidao_nascimento' => $request->crianca_certidao_nascimento,
                'certidao_folha' => $request->crianca_certidao_folha,
                'certidao_livro' => $request->crianca_certidao_livro,
                'cpf' => $request->crianca_cpf,
                'rg' => $request->crianca_rg,
                'possui_deficiencia' => $request->crianca_possui_deficiencia,
                'naturalidade' => $request->crianca_naturalidade,
            ]);

            // Sincronizar com tabela Matriculas (Fase 6)
            $anoAtual = \App\Models\AnoLetivo::atual();
            if ($anoAtual) {
                \App\Models\Matricula::updateOrCreate(
                    ['crianca_id' => $crianca->id, 'ano_letivo_id' => $anoAtual->id],
                    [
                        'escola' => $request->crianca_escola,
                        'tipo_escola' => $request->crianca_tipo_escola,
                        'serie' => $request->crianca_serie,
                        'periodo_escolar' => $request->crianca_periodo_escolar,
                        'data_matricula' => $request->crianca_data_matricula,
                    ]
                );
            }

            // 2. TRATAR MÃE
            if ($request->mae_nome) {
                $mae = Responsavel::updateOrCreate(
                    ['nome' => $request->mae_nome],
                    [
                        'email' => 'mae_' . uniqid() . '@multiraobem.org.br', // Email fictício
                        'telefone' => '0000000000', // Telefone fictício
                        'idade' => $request->mae_idade,
                        'data_nascimento' => $request->mae_data_nascimento,
                        'profissao' => $request->mae_profissao,
                        'desempregado' => $request->mae_desempregada == '1',
                    ]
                );
                CriancaResponsavel::updateOrCreate(
                    ['crianca_id' => $crianca->id, 'parentesco' => 'MAE'],
                    ['responsavel_id' => $mae->id, 'principal' => false]
                );
            }

            // 3. TRATAR PAI
            if ($request->pai_nome) {
                $pai = Responsavel::updateOrCreate(
                    ['nome' => $request->pai_nome],
                    [
                        'email' => 'pai_' . uniqid() . '@multiraobem.org.br', // Email fictício
                        'telefone' => '0000000000', // Telefone fictício
                        'idade' => $request->pai_idade,
                        'data_nascimento' => $request->pai_data_nascimento,
                        'profissao' => $request->pai_profissao,
                        'desempregado' => $request->pai_desempregado == '1',
                    ]
                );
                CriancaResponsavel::updateOrCreate(
                    ['crianca_id' => $crianca->id, 'parentesco' => 'PAI'],
                    ['responsavel_id' => $pai->id, 'principal' => false]
                );
            }

            // 4. ATUALIZAR RESPONSÁVEL PRINCIPAL
            $responsavelPrincipal = $crianca->responsavel;
            $responsavelPrincipal->update([
                'nome' => $request->responsavel_nome,
                'parentesco' => $request->responsavel_parentesco,
                'estado_civil' => $request->responsavel_estado_civil,
                'data_nascimento' => $request->responsavel_data_nascimento,
                'idade' => $request->responsavel_idade,
                'grau_instrucao' => $request->responsavel_grau_instrucao,
                'cpf' => $request->responsavel_cpf,
                'rg' => $request->responsavel_rg,
                'tem_cadastro_unico' => $request->has('responsavel_tem_cadastro_unico'),
                'recebe_transferencia_renda' => $request->has('responsavel_recebe_transferencia_renda'),
                'recebe_bpc' => $request->has('responsavel_recebe_bpc'),
            ]);

            // 5. ATUALIZAR CONTATOS
            if ($request->hasAny(['contato_celular', 'contato_residencia', 'contato_trabalho'])) {
                $responsavelPrincipal->contatos()->delete(); // Limpa e insere novos apenas se vierem dados
                $tiposContatos = [
                    'contato_celular' => 'CELULAR',
                    'contato_residencia' => 'RESIDENCIA',
                    'contato_trabalho' => 'TRABALHO',
                    'contato_outro_1' => 'OUTRO',
                    'contato_outro_2' => 'OUTRO',
                    'contato_recado' => 'RECADO'
                ];

                foreach ($tiposContatos as $input => $tipo) {
                    if ($request->has($input) && $request->$input) {
                        Contato::create([
                            'responsavel_id' => $responsavelPrincipal->id,
                            'tipo' => $tipo,
                            'numero' => $request->$input,
                            'pessoa_contato' => ($input == 'contato_recado' || $input == 'contato_pessoa_nome') ? $request->contato_pessoa_nome : null
                        ]);
                    }
                }
            }

            // 6. ATUALIZAR MORADIA
            if ($request->has('moradia_endereco')) {
                Moradia::updateOrCreate(
                    ['crianca_id' => $crianca->id],
                    [
                        'endereco' => $request->moradia_endereco,
                        'complemento' => $request->moradia_complemento,
                        'cep' => $request->moradia_cep,
                        'bairro' => $request->moradia_bairro,
                        'ponto_referencia' => $request->moradia_ponto_referencia,
                        'situacao_habitacional' => $request->moradia_situacao_habitacional,
                        'numero_comodos' => $request->moradia_numero_comodos,
                        'numero_moradores' => $request->moradia_numero_moradores,
                        'condicao_moradia' => $request->moradia_condicao_moradia,
                    ]
                );
            }

            // 7. ATUALIZAR FAMILIARES
            if ($request->has('familiares') && is_array($request->familiares)) {
                $crianca->familiares()->delete(); // Limpa apenas se vier o array (garante que o usuário quer atualizar a lista)
                foreach ($request->familiares as $fData) {
                    if (!empty($fData['nome'])) {
                        Familiar::create([
                            'crianca_id' => $crianca->id,
                            'nome' => $fData['nome'],
                            'data_nascimento' => $fData['data_nascimento'],
                            'grau_parentesco' => $fData['parentesco'],
                            'grau_instrucao' => $fData['grau_instrucao'],
                            'estuda' => ($fData['estuda'] ?? '0') == '1',
                            'inserido_cca' => ($fData['inserido_cca'] ?? '0') == '1',
                            'profissao' => $fData['profissao'],
                            'renda' => $fData['renda'] ?? 0,
                            'fatores_risco' => $fData['fatores_risco'],
                        ]);
                    }
                }
            } elseif ($request->familiar_nome) {
                // Fallback para o formato antigo
                Familiar::create([
                    'crianca_id' => $crianca->id,
                    'nome' => $request->familiar_nome,
                    'data_nascimento' => $request->familiar_data_nascimento,
                    'grau_parentesco' => $request->familiar_parentesco,
                    'grau_instrucao' => $request->familiar_grau_instrucao,
                    'estuda' => $request->familiar_estuda == '1',
                    'inserido_cca' => $request->familiar_inserido_cca == '1',
                    'profissao' => $request->familiar_profissao,
                    'renda' => $request->familiar_renda ?? 0,
                    'fatores_risco' => $request->familiar_fatores_risco,
                ]);
            }

            // 8. TRATAR ANEXOS (Se enviados novos)
            if ($request->hasFile('anexo_rg_responsavel')) {
                // Remover antigo se existir
                if ($responsavelPrincipal->anexo_rg) {
                    Storage::disk('public')->delete($responsavelPrincipal->anexo_rg);
                }
                $path = $request->file('anexo_rg_responsavel')->store('anexos/responsaveis', 'public');
                $responsavelPrincipal->update(['anexo_rg' => $path]);
            }
            if ($request->hasFile('anexo_certidao')) {
                // Remover antigo se existir
                if ($crianca->anexo_certidao) {
                    Storage::disk('public')->delete($crianca->anexo_certidao);
                }
                $path = $request->file('anexo_certidao')->store('anexos/criancas', 'public');
                $crianca->update(['anexo_certidao' => $path]);
            }
            if ($request->hasFile('anexo_excel_matricula')) {
                // Remover antigo se existir
                if ($crianca->anexo_excel_matricula) {
                    Storage::disk('public')->delete($crianca->anexo_excel_matricula);
                }
                $path = $request->file('anexo_excel_matricula')->store('anexos/criancas/excel', 'public');
                $crianca->update(['anexo_excel_matricula' => $path]);
            }
            if ($request->hasFile('anexo_rg_crianca')) {
                if ($crianca->anexo_rg) {
                    Storage::disk('public')->delete($crianca->anexo_rg);
                }
                $path = $request->file('anexo_rg_crianca')->store('anexos/criancas', 'public');
                $crianca->update(['anexo_rg' => $path]);
            }
            if ($request->hasFile('anexo_cpf_crianca')) {
                if ($crianca->anexo_cpf) {
                    Storage::disk('public')->delete($crianca->anexo_cpf);
                }
                $path = $request->file('anexo_cpf_crianca')->store('anexos/criancas', 'public');
                $crianca->update(['anexo_cpf' => $path]);
            }
            if ($request->hasFile('anexo_comprovante_residencia')) {
                if ($crianca->anexo_comprovante_residencia) {
                    Storage::disk('public')->delete($crianca->anexo_comprovante_residencia);
                }
                $path = $request->file('anexo_comprovante_residencia')->store('anexos/criancas', 'public');
                $crianca->update(['anexo_comprovante_residencia' => $path]);
            }
            if ($request->hasFile('anexo_comprovante_escolaridade')) {
                if ($crianca->anexo_comprovante_escolaridade) {
                    Storage::disk('public')->delete($crianca->anexo_comprovante_escolaridade);
                }
                $path = $request->file('anexo_comprovante_escolaridade')->store('anexos/criancas', 'public');
                $crianca->update(['anexo_comprovante_escolaridade' => $path]);
            }
            if ($request->hasFile('anexo_comprovante_renda')) {
                if ($crianca->anexo_comprovante_renda) {
                    Storage::disk('public')->delete($crianca->anexo_comprovante_renda);
                }
                $path = $request->file('anexo_comprovante_renda')->store('anexos/criancas', 'public');
                $crianca->update(['anexo_comprovante_renda' => $path]);
            }

            LogAuditoria::create([
                'usuario_id' => Auth::id(),
                'acao' => "Matrícula: Editou dados completos",
                'tabela_afetada' => 'criancas',
                'registro_id' => $crianca->id,
                'detalhes' => "Alteração manual de dados via tela de edição (Novo Censo).",
                'data_hora' => now()
            ]);

            DB::commit();
            return redirect()->route('matricula.show', $crianca->id)->with('success', 'Dados atualizados com sucesso!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Erro ao atualizar: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Aprova a matrícula final.
     */
    public function aprovar(Request $request, $id)
    {
        $crianca = Crianca::findOrFail($id);
        
        // Determinar o próximo status baseado no atual
        $proximoStatus = ($crianca->status === 'PENDENTE_REMATRICULA_APROVACAO') 
            ? 'PENDENTE_REMATRICULA_ANAMNESE' 
            : 'APROVADA';

        // Atualiza status na tabela de crianças
        $crianca->status = $proximoStatus;
        $crianca->save();

        // Sincronizar com tabela Matriculas (Fase 6)
        $anoAtual = \App\Models\AnoLetivo::atual();
        if ($anoAtual) {
            \App\Models\Matricula::updateOrCreate(
                ['crianca_id' => $crianca->id, 'ano_letivo_id' => $anoAtual->id],
                ['status' => $proximoStatus]
            );
        }

        // Sincroniza status na tabela de inscrições se existir
        if ($crianca->inscricao) {
            $crianca->inscricao->update(['status' => 'APROVADA']);
        }

        LogAuditoria::create([
            'usuario_id' => Auth::id(),
            'acao' => "Matrícula: Aprovada para Anamnese",
            'tabela_afetada' => 'criancas',
            'registro_id' => $crianca->id,
            'detalhes' => $request->detalhes ?? "Aprovação de matrícula após conferência de dados socioeconômicos.",
            'data_hora' => now()
        ]);

        return redirect()->route('matricula.show', $crianca->id)->with('success', 'Matrícula aprovada! Criança apta para o preenchimento da Anamnese.');
    }

    /**
     * Registra a evasão/saída da criança.
     */
    public function evadir(Request $request, $id)
    {
        $request->validate([
            'data_evasao' => 'required|date',
            'motivo_evasao' => 'required|string',
            'observacao_evasao' => 'nullable|string',
        ]);

        $crianca = Crianca::findOrFail($id);
        $statusAnterior = $crianca->status;
        $turmaAnterior = $crianca->turma ? $crianca->turma->nome : 'Nenhuma';

        // Atualiza a criança
        $crianca->update([
            'status' => 'EVADIDA',
            'turma_id' => null, // Remove da turma atual
            'data_evasao' => $request->data_evasao,
            'motivo_evasao' => $request->motivo_evasao,
            'observacao_evasao' => $request->observacao_evasao,
        ]);

        // Sincronizar com tabela Matriculas (Fase 6)
        $anoAtual = \App\Models\AnoLetivo::atual();
        if ($anoAtual) {
            \App\Models\Matricula::updateOrCreate(
                ['crianca_id' => $crianca->id, 'ano_letivo_id' => $anoAtual->id],
                [
                    'status' => 'EVADIDA',
                    'turma_id' => null,
                    'data_evasao' => $request->data_evasao,
                    'motivo_evasao' => $request->motivo_evasao,
                    'observacao_evasao' => $request->observacao_evasao,
                ]
            );
        }

        // Sincroniza status na tabela de inscrições se existir
        if ($crianca->inscricao) {
            $crianca->inscricao->update(['status' => 'EVADIDA']);
        }

        LogAuditoria::create([
            'usuario_id' => Auth::id(),
            'acao' => "Desligamento: Registro de Evasão/Saída",
            'tabela_afetada' => 'criancas',
            'registro_id' => $crianca->id,
            'detalhes' => "Evasão registrada. Motivo: {$request->motivo_evasao}. Turma anterior: {$turmaAnterior}. Observação: " . ($request->observacao_evasao ?? 'Nenhuma'),
            'data_hora' => now()
        ]);

        return redirect()->route('pesquisa.index')->with('success', "Desligamento de {$crianca->nome} registrado com sucesso.");
    }

    /**
     * Gera o PDF completo (Ponto 4 & 5).
     */
    public function pdf($id)
    {
        $crianca = Crianca::with(['responsavel.contatos', 'responsaveis', 'moradia', 'familiares', 'logsAuditoria.usuario'])->findOrFail($id);
        $pdf = Pdf::loadView('pdf.matricula_completa', compact('crianca'));
        return $pdf->download("matricula_{$crianca->nome}.pdf");
    }

    public function downloadFichaMae($id = null)
    {
        $filePath = base_path('FICHA_MAE_nome_completo_da_criança_Ficha de Inscrição_MNB_v2026.xlsx');
        
        if (file_exists($filePath)) {
            $fileName = 'Ficha_Mae';
            
            if ($id) {
                $crianca = Crianca::find($id);
                if ($crianca) {
                    // Remove espaços e caracteres especiais do nome para o arquivo
                    $nomeLimpo = str_replace(' ', '_', preg_replace('/[^A-Za-z0-9 ]/', '', $crianca->nome));
                    $fileName .= '_' . $nomeLimpo . '_' . $id;
                } else {
                    $fileName .= '_ID_' . $id;
                }
            } else {
                $fileName .= '_Modelo_2026';
            }
            
            $fileName .= '.xlsx';

            return response()->download($filePath, $fileName);
        }

        return abort(404, 'Arquivo não encontrado.');
    }
}
