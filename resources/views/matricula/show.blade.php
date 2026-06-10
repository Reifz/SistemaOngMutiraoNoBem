<x-app-layout>
    <div class="max-w-8xl mx-auto sm:px-6 lg:px-8 py-6">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-t-8 border-multirao-roxo">
            <div class="p-10 text-gray-900">

                @if(session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 shadow-sm" role="alert">
                        <p class="font-bold uppercase text-xs">Sucesso</p>
                        <p>{{ session('success') }}</p>
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 shadow-sm" role="alert">
                        <p class="font-bold uppercase text-xs">Erro</p>
                        <p>{{ session('error') }}</p>
                    </div>
                @endif
                
                <div class="mb-8 text-center border-b pb-6 flex justify-between items-center">
                    <div class="text-left">
                        <h2 class="text-2xl font-bold text-multirao-roxo mb-2">Visualização de Matrícula</h2>
                        <p class="text-gray-500 text-sm italic">Dados consolidados de <b>{{ $crianca->nome }}</b>.</p>
                        <p class="text-xs text-gray-400">Protocolo Interno: #{{ str_pad($crianca->id, 6, '0', STR_PAD_LEFT) }}</p>
                    </div>
                    <div class="flex gap-3">
                        @if(in_array($crianca->status, ['PENDENTE_MATRICULA', 'PENDENTE_APROVACAO']))
                            @php
                                $camposFaltando = [];
                                
                                // Nova Regra (Item 5): Pelo menos um documento da criança
                                $temDocCrianca = $crianca->cpf || $crianca->rg || $crianca->anexo_certidao || $crianca->anexo_rg || $crianca->anexo_cpf;
                                if (!$temDocCrianca) $camposFaltando[] = 'Pelo menos 1 documento da criança (CPF, RG ou Certidão)';

                                // Nova Regra (Item 5): Pelo menos um documento do responsável
                                $temDocResponsavel = $crianca->responsavel->cpf || $crianca->responsavel->rg || $crianca->responsavel->anexo_rg;
                                if (!$temDocResponsavel) $camposFaltando[] = 'Pelo menos 1 documento do responsável (CPF, RG ou CNH)';

                                // Dados obrigatórios que não são "documentos" ID
                                if (!$crianca->moradia) $camposFaltando[] = 'Dados de Moradia';
                                if ($crianca->familiares->count() === 0) $camposFaltando[] = 'Composição Familiar';
                                
                                $podeAprovar = count($camposFaltando) === 0;
                            @endphp

                            @if($podeAprovar)
                                <form action="{{ route('matricula.aprovar', $crianca->id) }}" method="POST" onsubmit="return confirm('Confirmar aprovação desta matrícula?')">
                                    @csrf
                                    <button type="submit" class="bg-green-600 text-white font-bold py-2 px-4 rounded shadow hover:bg-green-700 transition uppercase text-xs flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        Aprovar para Anamnese
                                    </button>
                                </form>
                            @else
                                <button type="button" disabled title="Campos pendentes: {{ implode(', ', $camposFaltando) }}" class="bg-gray-400 text-white font-bold py-2 px-4 rounded shadow cursor-not-allowed uppercase text-xs flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                    Aprovação Bloqueada (Dados Incompletos)
                                </button>
                            @endif
                        @elseif(in_array($crianca->status, ['APROVADA', 'ANAMNESE_CONCLUIDA', 'EM_TURMA']))
                            <span class="bg-green-100 text-green-800 font-bold py-2 px-4 rounded border border-green-200 uppercase text-xs flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                Matrícula Aprovada
                            </span>
                        @endif

                        <a href="{{ route('matricula.pdf', $crianca->id) }}" target="_blank" class="bg-multirao-amarelo text-multirao-roxo font-bold py-2 px-4 rounded shadow-sm hover:bg-opacity-90 transition uppercase text-xs flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm5 6a1 1 0 10-2 0v3.586l-1.293-1.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 11.586V8z" clip-rule="evenodd"></path></svg>
                            PDF
                        </a>

                        @if(in_array($crianca->status, ['APROVADA', 'ANAMNESE_CONCLUIDA', 'EM_TURMA']))
                            <button type="button" onclick="openEvasaoModal()" class="bg-red-600 text-white font-bold py-2 px-4 rounded shadow hover:bg-red-700 transition uppercase text-xs flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                Registrar Saída/Evasão
                            </button>
                        @endif

                        @if(in_array($crianca->status, ['PENDENTE_MATRICULA', 'PENDENTE_APROVACAO']))
                            <a href="{{ route('matricula.edit', $crianca->id) }}" class="bg-amber-500 text-white font-bold py-2 px-4 rounded shadow hover:bg-amber-600 transition uppercase text-xs flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                Editar
                            </a>
                        @endif

                        <a href="{{ route('mensagens.create', ['crianca_id' => $crianca->id]) }}" class="bg-indigo-600 text-white font-bold py-2 px-4 rounded shadow hover:bg-indigo-700 transition uppercase text-xs flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                            Mensagem
                        </a>

                        <a href="{{ route('matricula.index') }}" class="text-sm font-bold text-gray-500 hover:text-multirao-roxo transition flex items-center ml-4">
                            &larr; Voltar
                        </a>
                    </div>
                </div>

                <!-- SEÇÃO 1: DADOS DA CRIANÇA/ ADOLESCENTE -->
                <div class="mb-12 border-b pb-8">
                    <h3 class="text-lg font-bold text-multirao-roxo mb-6 flex items-center uppercase">
                        <span class="w-8 h-8 rounded-full bg-multirao-roxo text-white flex items-center justify-center mr-3 text-sm">1</span>
                        DADOS DA CRIANÇA/ ADOLESCENTE
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Nome Completo</label>
                            <p class="p-2 bg-gray-50 rounded border font-bold">{{ $crianca->nome }}</p>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Idade</label>
                            <p class="p-2 bg-gray-50 rounded border">{{ $crianca->idade }} anos</p>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Sexo</label>
                            <p class="p-2 bg-gray-50 rounded border">{{ $crianca->sexo }}</p>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Data de Nascimento</label>
                            <p class="p-2 bg-gray-50 rounded border">{{ $crianca->data_nascimento ? $crianca->data_nascimento->format('d/m/Y') : '---' }}</p>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Cor/Raça</label>
                            <p class="p-2 bg-gray-50 rounded border">{{ $crianca->cor_raca ?? '---' }}</p>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Naturalidade</label>
                            <p class="p-2 bg-gray-50 rounded border">{{ $crianca->naturalidade ?? '---' }}</p>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Data de Inscrição</label>
                            <p class="p-2 bg-gray-50 rounded border">{{ $crianca->data_inscricao ? $crianca->data_inscricao->format('d/m/Y') : '---' }}</p>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Data de Matrícula</label>
                            <p class="p-2 bg-gray-50 rounded border">{{ $crianca->data_matricula ? $crianca->data_matricula->format('d/m/Y') : '---' }}</p>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Está na Escola?</label>
                            <p class="p-2 bg-gray-50 rounded border font-bold {{ $crianca->esta_na_escola ? 'text-gray-700' : 'text-gray-700' }}">{{ $crianca->esta_na_escola ? 'SIM' : 'NÃO' }}</p>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Escola</label>
                            <p class="p-2 bg-gray-50 rounded border">{{ $crianca->escola ?? '---' }}  - <span style="text-transform: uppercase;">{{ $crianca->tipo_escola }}</span></p>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Série / Período (Escola)</label>
                            <p class="p-2 bg-gray-50 rounded border">{{ $crianca->serie }} - {{ $crianca->periodo_escolar }}</p>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Período Desejado (ONG)</label>
                            <p class="p-2 bg-gray-50 rounded border font-bold">{{ $crianca->periodo_ong ?? 'Não informado' }}</p>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">CPF</label>
                            <p class="p-2 bg-gray-50 rounded border">{{ $crianca->cpf ?? '---' }}</p>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">RG</label>
                            <p class="p-2 bg-gray-50 rounded border">{{ $crianca->rg ?? '---' }}</p>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">PCD?</label>
                            <p class="p-2 bg-gray-50 rounded border font-bold">{{ $crianca->possui_deficiencia ? 'SIM' : 'NÃO' }}</p>
                        </div>

                     
                        <div>
                            <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Certidão Nº</label>
                            <p class="p-2 bg-gray-50 rounded border">{{ $crianca->certidao_nascimento ?? '---' }}</p>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Folha</label>
                            <p class="p-2 bg-gray-50 rounded border">{{ $crianca->certidao_folha ?? '---' }}</p>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Livro</label>
                            <p class="p-2 bg-gray-50 rounded border">{{ $crianca->certidao_livro ?? '---' }}</p>
                        </div>
                       

                        <!-- Mãe e Pai -->
                        @php
                            $mae = $crianca->responsaveis->where('pivot.parentesco', 'MAE')->first();
                            $pai = $crianca->responsaveis->where('pivot.parentesco', 'PAI')->first();
                        @endphp

                        <div>
                            <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Nome da mãe</label>
                            <p class="p-2 bg-gray-50 rounded border">{{ $mae->nome ?? '---' }}</p>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Idade da mãe</label>
                            <p class="p-2 bg-gray-50 rounded border">{{ $mae->idade ?? '---' }} anos</p>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Profissão da Mãe</label>
                            <p class="p-2 bg-gray-50 rounded border"> {{ $mae->profissao ?? '---' }} {{ ($mae && $mae->desempregado) ? '(Desempregada)' : '' }}</p>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Nome do Pai</label>
                            <p class="p-2 bg-gray-50 rounded border">{{ $pai->nome ?? '---' }}</p>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Idade do Pai</label>
                            <p class="p-2 bg-gray-50 rounded border">{{ $pai->idade ?? '---' }} anos</p>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Profissão do Pai</label>
                            <p class="p-2 bg-gray-50 rounded border"> {{ $pai->profissao ?? '---' }} {{ ($pai && $pai->desempregado) ? '(Desempregado)' : '' }}</p>
                        </div>

                    </div>
                </div>

                <!-- SEÇÃO 2: MORADIA -->
                <div class="mb-12 border-b pb-8">
                    <h3 class="text-lg font-bold text-multirao-roxo mb-6 flex items-center uppercase">
                        <span class="w-8 h-8 rounded-full bg-multirao-roxo text-white flex items-center justify-center mr-3 text-sm">2</span>
                        MORADIA
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">

                        <div class="">
                            <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Endereço</label>
                            <p class="p-2 bg-gray-50 rounded border">{{ $crianca->moradia->endereco ?? '---' }}</p>
                        </div>

                        <div class="">
                            <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Complemento</label>
                            <p class="p-2 bg-gray-50 rounded border">{{ $crianca->moradia->complemento ?? '---' }}</p>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">CEP</label>
                            <p class="p-2 bg-gray-50 rounded border">{{ $crianca->moradia->cep ?? '---' }}</p>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Bairro</label>
                            <p class="p-2 bg-gray-50 rounded border">{{ $crianca->moradia->bairro ?? '---' }}</p>
                        </div>

                        <div class="">
                            <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Ponto de Referência</label>
                            <p class="p-2 bg-gray-50 rounded border">{{ $crianca->moradia->ponto_referencia ?? '---' }}</p>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Situação Habitacional</label>
                            <p class="p-2 bg-gray-50 rounded border font-bold">{{ $crianca->moradia->situacao_habitacional ?? '---' }}</p>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Nº Cômodos</label>
                            <p class="p-2 bg-gray-50 rounded border">{{ $crianca->moradia->numero_comodos ?? '0' }} </p>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Moradores</label>
                            <p class="p-2 bg-gray-50 rounded border">{{ $crianca->moradia->numero_moradores ?? '0' }}</p>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Condição da Moradia</label>
                            <p class="p-2 bg-gray-50 rounded border">{{ $crianca->moradia->condicao_moradia ?? '0' }}</p>
                        </div>

                    </div>
                </div>

                <!-- SEÇÃO 3: TELEFONES e CONTATOS -->
                <div class="mb-12 border-b pb-8">
                    <h3 class="text-lg font-bold text-multirao-roxo mb-6 flex items-center uppercase">
                        <span class="w-8 h-8 rounded-full bg-multirao-roxo text-white flex items-center justify-center mr-3 text-sm">3</span>
                        TELEFONES e CONTATOS
                    </h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        @foreach($crianca->responsavel->contatos as $contato)
                            <div class="">  @php $telefone = preg_replace('/\D/', '', $contato->numero); @endphp
                                <div class="flex items-center gap-2 block text-xs font-bold text-multirao-roxo uppercase mb-1">
                                    <label class="">{{ $contato->tipo }}</label>
                                    <a href="https://wa.me/55{{ $telefone }}?text=Olá,%20tudo%20bem?%20Somos%20da%20Ong%20Multirao%20no%20Bem" target="_blank" class="text-green-600 underline">
                                        <svg class="w-5 h-5 mr-2 text-green-500" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M12 2a10 10 0 00-8.94 14.32L2 22l5.83-1.53A10 10 0 1012 2zm5.07 14.57c-.21.58-1.23 1.08-1.7 1.15-.44.07-1 .1-1.62-.1-.38-.12-.87-.28-1.5-.55-2.64-1.14-4.36-3.93-4.5-4.12-.14-.19-1.07-1.43-1.07-2.72 0-1.29.67-1.92.9-2.18.23-.26.5-.32.67-.32.17 0 .34 0 .5.01.16.01.37-.06.58.44.21.5.71 1.74.77 1.87.06.13.1.29.02.48-.08.19-.12.31-.25.48-.13.17-.27.38-.39.51-.13.13-.27.27-.12.53.14.26.63 1.04 1.35 1.69.93.83 1.71 1.08 1.97 1.2.26.12.41.1.56-.06.15-.17.64-.74.81-.99.17-.25.34-.21.57-.13.23.08 1.48.7 1.73.82.25.12.42.19.48.29.06.1.06.58-.15 1.16z"/>
                                        </svg>
                                    </a>
                                </div>
                                <p class="p-2 bg-gray-50 rounded border">{{ $contato->numero }}</p>
                                @if($contato->pessoa_contato)
                                    <p class="text-[12px] text-gray-500 italic">Pessoa de contato: {{ $contato->pessoa_contato }}</p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- SEÇÃO 4: DADOS DE TODOS QUE MORAM NA CASA -->
                <div class="mb-12 border-b pb-8">
                    <h3 class="text-lg font-bold text-multirao-roxo mb-6 flex items-center uppercase">
                        <span class="w-8 h-8 rounded-full bg-multirao-roxo text-white flex items-center justify-center mr-3 text-sm">4</span>
                        DADOS DE TODOS QUE MORAM NA CASA
                    </h3>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left">
                            <thead class="bg-gray-100 text-multirao-roxo uppercase text-xs">
                                <tr>
                                    <th class="p-3 border">Nome</th>
                                     <th class="p-3 border">Data de Nascimento</th>
                                    <th class="p-3 border">Parentesco</th>
                                    <th class="p-3 border">Estuda</th>
                                    <th class="p-3 border">CCA</th>
                                    <th class="p-3 border">Profissão</th>
                                    <th class="p-3 border">Renda</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($crianca->familiares as $familiar)
                                    <tr class="hover:bg-gray-50">
                                        <td class="p-3 border font-bold">{{ $familiar->nome }}</td>
                                        <td class="p-3 border">{{ $familiar->data_nascimento ? $familiar->data_nascimento->format('d/m/Y') : '---' }}</td>
                                        <td class="p-3 border">{{ $familiar->grau_parentesco }}</td>
                                        <td class="p-3 border"> Estuda: {{ $familiar->estuda ? 'SIM' : 'NÃO' }}</td>
                                        <td class="p-3 border">{{ ($familiar->inserido_cca) ? 'SIM' : 'NÃO' }}</td>
                                        <td class="p-3 border">{{ $familiar->profissao ?? '---' }} </td>
                                        <td class="p-3 border">  R$ {{ number_format($familiar->renda, 2, ',', '.') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="p-3 text-center text-gray-500 italic">Nenhum familiar adicional registrado.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- SEÇÃO 5: DADOS DO RESPONSÁVEL FAMILIAR -->
                <div class="mb-12 border-b pb-8 bg-indigo-50 p-6 rounded-xl border-2 border-indigo-200">
                    <h3 class="text-lg font-bold text-multirao-roxo mb-6 flex items-center uppercase">
                        <span class="w-8 h-8 rounded-full bg-multirao-roxo text-white flex items-center justify-center mr-3 text-sm">5</span>
                        RESPONSÁVEL PRINCIPAL (Com quem mora)
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                        <div>
                            <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Nome do Responsável</label>
                            <p class="p-2 bg-white rounded border font-bold text-indigo-700">{{ $crianca->responsavel->nome }}</p>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Parentesco</label>
                            <p class="p-2 bg-white rounded border">{{ $crianca->responsavel->parentesco }}</p>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Estado Civil</label>
                            <p class="p-2 bg-white rounded border">{{ $crianca->responsavel->estado_civil }}</p>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">CPF</label>
                            <p class="p-2 bg-white rounded border font-bold">{{ $crianca->responsavel->cpf }}</p>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">RG</label>
                            <p class="p-2 bg-white rounded border">{{ $crianca->responsavel->rg }}</p>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Data Nasc / Idade</label>
                            <p class="p-2 bg-white rounded border">{{ $crianca->responsavel->data_nascimento ? $crianca->responsavel->data_nascimento->format('d/m/Y') : '---' }} ({{ $crianca->responsavel->idade }} anos)</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="flex items-center space-x-2 p-3 bg-white border rounded">
                            <span class="text-xs font-bold text-gray-700 uppercase">POSSUI CADÚNICO:</span>
                            <span class="">{{ $crianca->responsavel->tem_cadastro_unico ? 'SIM' : 'NÃO' }}</span>
                        </div>
                        <div class="flex items-center space-x-2 p-3 bg-white border rounded">
                            <span class="text-xs font-bold text-gray-700 uppercase">RECEBE AUXÍLIO/BOLSA:</span>
                            <span class="">{{ $crianca->responsavel->recebe_transferencia_renda ? 'SIM' : 'NÃO' }}</span>
                        </div>
                        <div class="flex items-center space-x-2 p-3 bg-white border rounded">
                            <span class="text-xs font-bold text-gray-700 uppercase">RECEBE BPC:</span>
                            <span class="">{{ $crianca->responsavel->recebe_bpc ? 'SIM' : 'NÃO' }}</span>
                        </div>
                    </div>
                </div>

                <!-- SEÇÃO 6: DOCUMENTOS E ANEXOS -->
                <div class="mb-12" id="sessao-arquivos">
                    <h3 class="text-lg font-bold text-multirao-roxo mb-6 flex items-center uppercase">
                        <span class="w-8 h-8 rounded-full bg-multirao-roxo text-white flex items-center justify-center mr-3 text-sm">6</span>
                        Documentos e Anexos
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <div class="p-6 border-2 rounded-lg {{ $crianca->responsavel->anexo_rg ? 'border-green-200 bg-green-50' : 'border-gray-200 bg-gray-50' }}">
                            <label class="block text-sm font-bold text-gray-700 mb-2 uppercase">RG ou CNH do Responsável</label>
                            @if($crianca->responsavel->anexo_rg)
                                <div class="flex items-center justify-between">
                                    <span class="text-xs text-green-700 font-bold flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                        Arquivo Carregado
                                    </span>
                                    <a href="{{ asset('storage/' . $crianca->responsavel->anexo_rg) }}" target="_blank" class="bg-multirao-roxo text-white text-[10px] px-3 py-1 rounded hover:bg-opacity-90 font-bold uppercase">Visualizar</a>
                                </div>
                            @else
                                <span class="text-xs text-red-500 italic">Nenhum arquivo enviado.</span>
                            @endif
                        </div>

                        <div class="p-6 border-2 rounded-lg {{ $crianca->anexo_certidao ? 'border-green-200 bg-green-50' : 'border-gray-200 bg-gray-50' }}">
                            <label class="block text-sm font-bold text-gray-700 mb-2 uppercase">Certidão de Nascimento da Criança</label>
                            @if($crianca->anexo_certidao)
                                <div class="flex items-center justify-between">
                                    <span class="text-xs text-green-700 font-bold flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                        Arquivo Carregado
                                    </span>
                                    <a href="{{ asset('storage/' . $crianca->anexo_certidao) }}" target="_blank" class="bg-multirao-roxo text-white text-[10px] px-3 py-1 rounded hover:bg-opacity-90 font-bold uppercase">Visualizar</a>
                                </div>
                            @else
                                <span class="text-xs text-red-500 italic">Nenhum arquivo enviado.</span>
                            @endif
                        </div>

                        <div class="p-6 border-2 rounded-lg {{ $crianca->anexo_excel_matricula ? 'border-green-200 bg-green-50' : 'border-gray-200 bg-gray-50' }}">
                            <label class="block text-sm font-bold text-gray-700 mb-2 uppercase">Ficha de Inscrição (Excel)</label>
                            @if($crianca->anexo_excel_matricula)
                                <div class="flex items-center justify-between">
                                    <span class="text-xs text-green-700 font-bold flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                        Arquivo Carregado
                                    </span>
                                   <a href="{{ route('matricula.download_ficha_mae', $crianca->id) }}" class="bg-multirao-roxo text-white text-[10px] px-3 py-1 rounded hover:bg-opacity-90 font-bold uppercase">
                                        Baixar Excel 
                                    </a>
                                </div>
                            @else
                                <span class="text-xs text-red-500 italic">Nenhum arquivo enviado.</span>
                            @endif
                        </div>

                        <div class="p-6 border-2 rounded-lg {{ $crianca->anexo_rg ? 'border-green-200 bg-green-50' : 'border-gray-200 bg-gray-50' }}">
                            <label class="block text-sm font-bold text-gray-700 mb-2 uppercase">RG da Criança</label>
                            @if($crianca->anexo_rg)
                                <div class="flex items-center justify-between">
                                    <span class="text-xs text-green-700 font-bold flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                        Arquivo Carregado
                                    </span>
                                    <a href="{{ asset('storage/' . $crianca->anexo_rg) }}" target="_blank" class="bg-multirao-roxo text-white text-[10px] px-3 py-1 rounded hover:bg-opacity-90 font-bold uppercase">Visualizar</a>
                                </div>
                            @else
                                <span class="text-xs text-red-500 italic">Nenhum arquivo enviado.</span>
                            @endif
                        </div>

                        <div class="p-6 border-2 rounded-lg {{ $crianca->anexo_cpf ? 'border-green-200 bg-green-50' : 'border-gray-200 bg-gray-50' }}">
                            <label class="block text-sm font-bold text-gray-700 mb-2 uppercase">CPF da Criança</label>
                            @if($crianca->anexo_cpf)
                                <div class="flex items-center justify-between">
                                    <span class="text-xs text-green-700 font-bold flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                        Arquivo Carregado
                                    </span>
                                    <a href="{{ asset('storage/' . $crianca->anexo_cpf) }}" target="_blank" class="bg-multirao-roxo text-white text-[10px] px-3 py-1 rounded hover:bg-opacity-90 font-bold uppercase">Visualizar</a>
                                </div>
                            @else
                                <span class="text-xs text-red-500 italic">Nenhum arquivo enviado.</span>
                            @endif
                        </div>

                        <div class="p-6 border-2 rounded-lg {{ $crianca->anexo_comprovante_residencia ? 'border-green-200 bg-green-50' : 'border-gray-200 bg-gray-50' }}">
                            <label class="block text-sm font-bold text-gray-700 mb-2 uppercase">Comprovante de Residência</label>
                            @if($crianca->anexo_comprovante_residencia)
                                <div class="flex items-center justify-between">
                                    <span class="text-xs text-green-700 font-bold flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                        Arquivo Carregado
                                    </span>
                                    <a href="{{ asset('storage/' . $crianca->anexo_comprovante_residencia) }}" target="_blank" class="bg-multirao-roxo text-white text-[10px] px-3 py-1 rounded hover:bg-opacity-90 font-bold uppercase">Visualizar</a>
                                </div>
                            @else
                                <span class="text-xs text-red-500 italic">Nenhum arquivo enviado.</span>
                            @endif
                        </div>

                        <div class="p-6 border-2 rounded-lg {{ $crianca->anexo_comprovante_escolaridade ? 'border-green-200 bg-green-50' : 'border-gray-200 bg-gray-50' }}">
                            <label class="block text-sm font-bold text-gray-700 mb-2 uppercase">Comprovante de Escolaridade</label>
                            @if($crianca->anexo_comprovante_escolaridade)
                                <div class="flex items-center justify-between">
                                    <span class="text-xs text-green-700 font-bold flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                        Arquivo Carregado
                                    </span>
                                    <a href="{{ asset('storage/' . $crianca->anexo_comprovante_escolaridade) }}" target="_blank" class="bg-multirao-roxo text-white text-[10px] px-3 py-1 rounded hover:bg-opacity-90 font-bold uppercase">Visualizar</a>
                                </div>
                            @else
                                <span class="text-xs text-red-500 italic">Nenhum arquivo enviado.</span>
                            @endif
                        </div>

                        <div class="p-6 border-2 rounded-lg {{ $crianca->anexo_comprovante_renda ? 'border-green-200 bg-green-50' : 'border-gray-200 bg-gray-50' }}">
                            <label class="block text-sm font-bold text-gray-700 mb-2 uppercase">Comprovante de Renda</label>
                            @if($crianca->anexo_comprovante_renda)
                                <div class="flex items-center justify-between">
                                    <span class="text-xs text-green-700 font-bold flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                        Arquivo Carregado
                                    </span>
                                    <a href="{{ asset('storage/' . $crianca->anexo_comprovante_renda) }}" target="_blank" class="bg-multirao-roxo text-white text-[10px] px-3 py-1 rounded hover:bg-opacity-90 font-bold uppercase">Visualizar</a>
                                </div>
                            @else
                                <span class="text-xs text-red-500 italic">Nenhum arquivo enviado.</span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Auditoria -->
                <div class="mt-8 bg-gray-50 p-6 rounded-lg border">
                    <h3 class="text-xs font-bold text-multirao-roxo uppercase mb-4 border-b pb-1">Histórico de Alterações</h3>
                    <div class="space-y-4 max-h-[300px] overflow-y-auto pr-2">
                        @foreach($crianca->logsAuditoria as $log)
                            <div class="border-l-2 border-multirao-roxo pl-3 pb-2">
                                <p class="text-[16px] font-bold text-gray-500 uppercase">
                                    {{ $log->data_hora->format('d/m/Y H:i') }} por {{ $log->usuario->name ?? 'Sistema' }}
                                </p>
                                <p class="text font-bold text-multirao-roxo">{{ $log->acao }}</p>
                                <p class="text text-gray-600 italic">"{{ $log->detalhes }}"</p>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Conversas Internas -->
                <div class="mt-8 bg-indigo-50 p-6 rounded-lg border border-indigo-100">
                    <div class="flex justify-between items-center mb-4 border-b border-indigo-200 pb-2">
                        <h3 class="text-xs font-bold text-multirao-roxo uppercase">Conversas sobre esta criança</h3>
                        <a href="{{ route('mensagens.create', ['crianca_id' => $crianca->id]) }}" class="text-[10px] font-bold bg-multirao-roxo text-white px-3 py-1 rounded uppercase hover:bg-opacity-90">Nova Mensagem</a>
                    </div>
                    
                    <div class="space-y-4 max-h-[400px] overflow-y-auto pr-2">
                        @forelse($mensagens as $msg)
                            <div class="bg-white p-3 rounded shadow-sm border border-indigo-50">
                                <div class="flex justify-between items-start mb-2">
                                    <div class="text-[10px] uppercase font-bold text-multirao-roxo">
                                        De: {{ $msg->remetente->name }} | Para: {{ $msg->destinatario->name }}
                                    </div>
                                    <div class="text-[10px] text-gray-400">
                                        {{ $msg->created_at->format('d/m/Y H:i') }}
                                    </div>
                                </div>
                                <p class="text-sm text-gray-700 leading-snug">{{ $msg->mensagem }}</p>
                            </div>
                        @empty
                            <p class="text-center text-xs text-gray-500 italic py-4">Nenhuma conversa registrada sobre esta criança.</p>
                        @endforelse
                    </div>
                </div>

            </div>
        </div>
    </div>
    </div>

    <!-- Modal de Registro de Evasão -->
    <div id="evasaoModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="closeEvasaoModal()"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border-t-8 border-red-600">
                <form action="{{ route('matricula.evadir', $crianca->id) }}" method="POST">
                    @csrf
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                <h3 class="text-lg leading-6 font-bold text-gray-900 uppercase" id="modal-title">Registrar Saída/Evasão</h3>
                                <div class="mt-4 space-y-4">
                                    <p class="text-sm text-gray-500 italic">Informe os detalhes do desligamento de <b>{{ $crianca->nome }}</b>. Esta ação é irreversível por esta tela.</p>
                                    
                                    <div>
                                        <label class="block text-xs font-bold text-red-600 uppercase mb-1">Data da Evasão/Saída</label>
                                        <input type="date" name="data_evasao" value="{{ date('Y-m-d') }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-red-600 focus:ring-red-600 text-sm" required>
                                    </div>

                                    <div>
                                        <label class="block text-xs font-bold text-red-600 uppercase mb-1">Motivo do Desligamento</label>
                                        <select name="motivo_evasao" class="w-full border-gray-300 rounded-md shadow-sm focus:border-red-600 focus:ring-red-600 text-sm" required>
                                            <option value="">Selecione um motivo...</option>
                                            <option value="Mudança de Endereço">Mudança de Endereço</option>
                                            <option value="Conflito de Horário">Conflito de Horário</option>
                                            <option value="Inadaptação">Inadaptação</option>
                                            <option value="Falta de Interesse">Falta de Interesse</option>
                                            <option value="Problemas Familiares">Problemas Familiares</option>
                                            <option value="Conclusão do Ciclo">Conclusão do Ciclo</option>
                                            <option value="Outros">Outros</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label class="block text-xs font-bold text-red-600 uppercase mb-1">Observações Adicionais</label>
                                        <textarea name="observacao_evasao" rows="3" placeholder="Detalhes opcionais sobre a saída..." class="w-full border-gray-300 rounded-md shadow-sm focus:border-red-600 focus:ring-red-600 text-sm"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-bold text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-xs uppercase">
                            Confirmar Evasão
                        </button>
                        <button type="button" onclick="closeEvasaoModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-bold text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-xs uppercase">
                            Cancelar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function openEvasaoModal() {
            document.getElementById('evasaoModal').classList.remove('hidden');
        }

        function closeEvasaoModal() {
            document.getElementById('evasaoModal').classList.add('hidden');
        }
    </script>
    @endpush
</x-app-layout>
