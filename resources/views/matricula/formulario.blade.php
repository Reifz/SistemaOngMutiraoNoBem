<x-app-layout>
    <div class="py-12">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-t-8 border-multirao-roxo">
                <div class="p-10 text-gray-900">
                    
                    <div class="mb-8 text-center border-b pb-6">
                        <h2 class="text-2xl font-bold text-multirao-roxo mb-2">FICHA DE INSCRIÇÃO/ MATRÍCULA/ DESLIGAMENTO DA CRIANÇA E ADOLESCENTE </h2>
                        <p>Educandário Mutirão no Bem - Cidade Dutra</p>
                        <p class="text-gray-500 text-sm italic">Este formulário deve ser preenchido pela equipe interna para a matrícula de <b>{{ $crianca->nome }}</b>.</p>
                        <p class="text-xs text-gray-400 mt-2">Protocolo Interno: #{{ str_pad($crianca->id, 6, '0', STR_PAD_LEFT) }}</p>
                    </div>

                    <form action="{{ route('matricula.store', $crianca->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <!-- Seção 1: Dados da Criança -->
                        <div class="mb-12 border-b pb-8">
                            <h3 class="text-lg font-bold text-multirao-roxo mb-6 flex items-center">
                                <span class="w-8 h-8 rounded-full bg-multirao-roxo text-white flex items-center justify-center mr-3 text-sm">1</span>
                                DADOS DA CRIANÇA/ ADOLESCENTE
                            </h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div class="md:col-span-1">
                                    <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Nome da Cça/Adol:</label>
                                    <input type="text" name="crianca_nome" value="{{ $crianca->nome }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo" required>
                                </div>

                                <div class="md:col-span-1">
                                    <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Idade:</label>
                                    <input type="number" name="crianca_idade" value="{{ $crianca->idade }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo" required>
                                </div>

                                <div class="md:col-span-1">
                                    <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Sexo: </label>
                                    <select name="crianca_sexo" class="w-full border-gray-300 rounded-md shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo">
                                        <option value="MASCULINO" {{ $crianca->sexo == 'MASCULINO' ? 'selected' : '' }}>Masculino</option>
                                        <option value="FEMININO" {{ $crianca->sexo == 'FEMININO' ? 'selected' : '' }}>Feminino</option>
                                    </select>
                                </div>

                                <div class="md:col-span-1">
                                    <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Cor/Raça</label>
                                    <input type="text" name="crianca_cor_raca" value="{{ $crianca->cor_raca }}" placeholder="Branco, Pardo..." class="w-full border-gray-300 rounded-md shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo">
                                </div>

                                <div class="md:col-span-1">
                                    <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Data de Nascimento:</label>
                                    <input type="date" name="crianca_data_nascimento" value="{{ $crianca->data_nascimento ? $crianca->data_nascimento->format('Y-m-d') : '' }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo" required>
                                </div>

                                <div class="md:col-span-1">
                                    <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Data de Inscrição:</label>
                                    <input type="date" name="crianca_data_inscricao" value="{{ $crianca->created_at->format('Y-m-d') }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo" required>
                                </div>

                                <div class="md:col-span-1">
                                    <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Data de Matrícula:</label>
                                    <input type="date" name="crianca_data_matricula" value="{{ now()->format('Y-m-d') }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo" required>
                                </div>

                                <div class="md:col-span-1">
                                    <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Data do Desligamento: </label>
                                    <input type="date" name="crianca_data_desligamento" class="w-full border-gray-300 rounded-md shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo">
                                </div>

                                <div class="md:col-span-1">
                                    <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Motivo do desligamento: </label>
                                    <select name="crianca_motivo_desligamento" class="w-full border-gray-300 rounded-md shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo">
                                        <option value="">Selecione...</option>
                                        <option value="abandono">Abandono</option>
                                        <option value="obito">Óbito</option>
                                        <option value="mudanca">Mudança</option>
                                        <option value="idade">Limite de idade</option>
                                    </select>
                                </div>

                                <div class="md:col-span-1">
                                    <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Está na Escola: </label>
                                    <select name="crianca_esta_na_escola" class="w-full border-gray-300 rounded-md shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo">
                                        <option value="1">Sim</option>
                                        <option value="0">Não</option>
                                    </select>
                                </div>

                               <div class="md:col-span-1">
                                    <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Nome completo da Escola: </label>
                                    <input type="text" name="crianca_escola" value="{{ $crianca->escola }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo">
                                </div>

                                <div class="md:col-span-1">
                                    <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Tipo Escola: </label>
                                    <select name="crianca_tipo_escola" class="w-full border-gray-300 rounded-md shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo">
                                        <option value="estadual">Estadual</option>
                                        <option value="municipal">Municipal</option>
                                        <option value="particular">Particular</option>
                                    </select>
                                </div>

                                <div class="md:col-span-1">
                                    <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Série / Ano: </label>
                                    <input type="text" name="crianca_serie" value="{{ $crianca->serie }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo">
                                </div>

                                <div class="md:col-span-1">
                                    <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Periodo: </label>
                                    <select name="crianca_periodo_escolar" class="w-full border-gray-300 rounded-md shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo">
                                        <option value="manhã" {{ $crianca->periodo_escolar == 'manhã' ? 'selected' : '' }}>Manhã</option>
                                        <option value="tarde" {{ $crianca->periodo_escolar == 'tarde' ? 'selected' : '' }}>Tarde</option>
                                        <option value="integral">Integral</option>
                                    </select>
                                </div>

                                <div class="md:col-span-1">
                                    <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Certidão de Nascimento (Nº)</label>
                                    <input type="text" name="crianca_certidao_nascimento" value="{{ $crianca->certidao_nascimento }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo">
                                </div>

                                <div class="md:col-span-1">
                                    <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Folha</label>
                                    <input type="text" name="crianca_certidao_folha" value="{{ $crianca->certidao_folha }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo">
                                </div>

                                <div class="md:col-span-1">
                                    <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Livro</label>
                                    <input type="text" name="crianca_certidao_livro" value="{{ $crianca->certidao_livro }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo">
                                </div>

                                <div class="md:col-span-1">
                                    <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">CPF</label>
                                    <input type="text" name="crianca_cpf" value="{{ $crianca->cpf }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo">
                                </div>

                                <div class="md:col-span-1">
                                    <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">RG</label>
                                    <input type="text" name="crianca_rg" value="{{ $crianca->rg }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo">
                                </div>

                                <div class="md:col-span-1">
                                    <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Pessoa com deficiência:</label>
                                    <select name="crianca_possui_deficiencia" class="w-full border-gray-300 rounded-md shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo">
                                        <option value="1">Sim</option>
                                        <option value="0" selected>Não</option>
                                    </select>
                                </div>

                                <div class="md:col-span-1">
                                    <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Naturalidade (Município/Estado):</label>
                                    <input type="text" name="crianca_naturalidade" value="{{ $crianca->naturalidade }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo">
                                </div>

                                <div class="md:col-span-1">
                                    <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Mãe:</label>
                                    <input type="text" name="mae_nome" class="w-full border-gray-300 rounded-md shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo">
                                </div>

                                <div class="md:col-span-1">
                                    <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Pai:</label>
                                    <input type="text" name="pai_nome" class="w-full border-gray-300 rounded-md shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo">
                                </div>

                                <div class="md:col-span-1">
                                    <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Idade da Mãe:</label>
                                    <input type="number" name="mae_idade" class="w-full border-gray-300 rounded-md shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo">
                                </div>

                                <div class="md:col-span-1">
                                    <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Data de Nascimento da Mãe:</label>
                                    <input type="date" name="mae_data_nascimento" class="w-full border-gray-300 rounded-md shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo">
                                </div>

                                <div class="md:col-span-1">
                                    <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Idade do Pai: </label>
                                    <input type="number" name="pai_idade" class="w-full border-gray-300 rounded-md shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo">
                                </div>

                                <div class="md:col-span-1">
                                    <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Data de Nascimento do Pai:</label>
                                    <input type="date" name="pai_data_nascimento" class="w-full border-gray-300 rounded-md shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo">
                                </div>

                                <div class="md:col-span-1">
                                    <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Profissão Mãe: </label>
                                    <input type="text" name="mae_profissao" class="w-full border-gray-300 rounded-md shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo">
                                </div>

                               

                                <div class="md:col-span-1">
                                    <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Profissão Pai: </label>
                                    <input type="text" name="pai_profissao" class="w-full border-gray-300 rounded-md shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo">
                                </div><br>

                                <div class="md:col-span-1">
                                    <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Desempregada? (Mãe)</label>
                                    <div class="flex gap-4 mt-2">
                                        <label class="flex items-center text-sm"><input type="radio" name="mae_desempregada" value="1" class="mr-1"> Sim</label>
                                        <label class="flex items-center text-sm"><input type="radio" name="mae_desempregada" value="0" class="mr-1" checked> Não</label>
                                    </div>
                                </div>

                                <div class="md:col-span-1">
                                    <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Desempregado? (Pai)</label>
                                    <div class="flex gap-4 mt-2">
                                        <label class="flex items-center text-sm"><input type="radio" name="pai_desempregado" value="1" class="mr-1"> Sim</label>
                                        <label class="flex items-center text-sm"><input type="radio" name="pai_desempregado" value="0" class="mr-1" checked> Não</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Seção 2: Dados da Moradia -->
                        <div class="mb-12 border-b pb-8">
                            <h3 class="text-lg font-bold text-multirao-roxo mb-6 flex items-center">
                                <span class="w-8 h-8 rounded-full bg-multirao-roxo text-white flex items-center justify-center mr-3 text-sm">2</span>
                                MORADIA
                            </h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div class="md:col-span-1">
                                    <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Endereço: </label>
                                    <input type="text" name="moradia_endereco" class="w-full border-gray-300 rounded-md shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo" required>
                                </div>

                                <div class="md:col-span-1">
                                    <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Complemento: </label>
                                    <input type="text" name="moradia_complemento" class="w-full border-gray-300 rounded-md shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo">
                                </div>
                                
                                <div class="md:col-span-1">
                                    <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">CEP: </label>
                                    <input type="text" name="moradia_cep" class="w-full border-gray-300 rounded-md shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo">
                                </div>

                                <div class="md:col-span-1">
                                    <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Bairro: </label>
                                    <input type="text" name="moradia_bairro" class="w-full border-gray-300 rounded-md shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo">
                                </div>

                                <div class="md:col-span-1">
                                    <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Ponto de Referência: </label>
                                    <input type="text" name="moradia_ponto_referencia" class="w-full border-gray-300 rounded-md shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo">
                                </div>

                                <div class="md:col-span-1">
                                    <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Situação Habitacional</label>
                                    <select name="moradia_situacao_habitacional" class="w-full border-gray-300 rounded-md shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo">
                                        <option value="cortiço">Cortiço</option>
                                        <option value="comunidade">Comunidade</option>
                                        <option value="loteamento">Loteamento</option>
                                         <option value="outro">Outro</option>
                                    </select>
                                </div>

                                <div class="md:col-span-1">
                                    <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Nº de cômodos: </label>
                                    <input type="number" name="moradia_numero_comodos" class="w-full border-gray-300 rounded-md shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo">
                                </div>
                               
                                <div class="md:col-span-1">
                                    <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Nº de moradores: </label>
                                    <input type="number" name="moradia_numero_moradores" class="w-full border-gray-300 rounded-md shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo">
                                </div>

                                <div class="md:col-span-1">
                                    <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Condições de Moradia</label>
                                    <select name="moradia_condicao_moradia" class="w-full border-gray-300 rounded-md shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo">
                                        <option value="propria">Propria</option>
                                        <option value="alugada">Alugada</option>
                                        <option value="cedida">Cedida</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Seção 3: Telefones e Contatos -->
                        <div class="mb-12 border-b pb-8">
                            <h3 class="text-lg font-bold text-multirao-roxo mb-6 flex items-center">
                                <span class="w-8 h-8 rounded-full bg-multirao-roxo text-white flex items-center justify-center mr-3 text-sm">3</span>
                                TELEFONES e CONTATOS
                            </h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div class="md:col-span-1">
                                    <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Celular</label>
                                    <input type="text" name="contato_celular" value="{{ $crianca->responsavel->telefone }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo">
                                </div>
                                <div class="md:col-span-1">
                                    <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Residência</label>
                                    <input type="text" name="contato_residencia" class="w-full border-gray-300 rounded-md shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo">
                                </div>
                                <div class="md:col-span-1">
                                    <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Trabalho: </label>
                                    <input type="text" name="contato_trabalho" class="w-full border-gray-300 rounded-md shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo">
                                </div>

                                <div class="md:col-span-1">
                                    <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Outro 1:</label>
                                    <input type="text" name="contato_outro_1" class="w-full border-gray-300 rounded-md shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo">
                                </div>

                                <div class="md:col-span-1">
                                    <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Outro 2:</label>
                                    <input type="text" name="contato_outro_2" class="w-full border-gray-300 rounded-md shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo">
                                </div>

                                <div class="md:col-span-1">
                                    <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Recado:</label>
                                    <input type="text" name="contato_recado" class="w-full border-gray-300 rounded-md shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo">
                                </div>

                                <div class="md:col-span-1">
                                    <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Pessoa de Contato: </label>
                                    <input type="text" name="contato_pessoa_nome" class="w-full border-gray-300 rounded-md shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo">
                                </div>
                            </div>
                        </div>

                        <!-- Seção 4: Dados de Todos que Moram na Casa -->
                        <div class="mb-12 border-b pb-8">
                            <div class="flex items-center justify-between mb-6">
                                <h3 class="text-lg font-bold text-multirao-roxo flex items-center">
                                    <span class="w-8 h-8 rounded-full bg-multirao-roxo text-white flex items-center justify-center mr-3 text-sm">4</span>
                                    DADOS DE TODOS QUE MORAM NA CASA
                                </h3>
                                <button type="button" id="add-familiar" class="bg-green-500 hover:bg-green-600 text-white text-xs font-bold py-2 px-4 rounded-full transition flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                    ADICIONAR MORADOR
                                </button>
                            </div>
                            
                            <div id="familiares-container">
                                <!-- Primeiro Familiar (Padrão) -->
                                <div class="familiar-row bg-gray-50 p-6 rounded-xl mb-6 border border-gray-200 relative">
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                        <div class="md:col-span-1">
                                            <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Nome</label>
                                            <input type="text" name="familiares[0][nome]" class="w-full border-gray-300 rounded-md shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo">
                                        </div>
                                        <div class="md:col-span-1">
                                            <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Data de nascimento</label>
                                            <input type="date" name="familiares[0][data_nascimento]" class="w-full border-gray-300 rounded-md shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo">
                                        </div>
                                        <div class="md:col-span-1">
                                            <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Grau de Parentesco / vínculo</label>
                                            <input type="text" name="familiares[0][parentesco]" class="w-full border-gray-300 rounded-md shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo">
                                        </div>
                              
                                        <div class="md:col-span-1">
                                            <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Grau de Instrução</label>
                                            <input type="text" name="familiares[0][grau_instrucao]" class="w-full border-gray-300 rounded-md shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo">
                                        </div>

                                        <div class="md:col-span-1">
                                            <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Estuda ?</label>
                                            <select name="familiares[0][estuda]" class="w-full border-gray-300 rounded-md shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo">
                                                <option value="1">Sim</option>
                                                <option value="0">Não</option>
                                            </select>
                                        </div>

                                        <div class="md:col-span-1">
                                            <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Inserido em CCA ?</label>
                                            <select name="familiares[0][inserido_cca]" class="w-full border-gray-300 rounded-md shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo">
                                                <option value="1">Sim</option>
                                                <option value="0">Não</option>
                                            </select>
                                        </div>

                                         <div class="md:col-span-1">
                                            <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Profissão / Ocupação</label>
                                            <input type="text" name="familiares[0][profissao]" class="w-full border-gray-300 rounded-md shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo">
                                        </div>

                                         <div class="md:col-span-1">
                                            <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Renda</label>
                                            <input type="number" step="0.01" name="familiares[0][renda]" class="w-full border-gray-300 rounded-md shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo">
                                        </div>

                                         <div class="md:col-span-1">
                                            <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Fator(es) de risco social (b)</label>
                                            <input type="text" name="familiares[0][fatores_risco]" class="w-full border-gray-300 rounded-md shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Seção 5: Dados do Responsável Familiar -->
                        <div class="mb-12 border-b pb-8">
                            <h3 class="text-lg font-bold text-multirao-roxo mb-6 flex items-center">
                                <span class="w-8 h-8 rounded-full bg-multirao-roxo text-white flex items-center justify-center mr-3 text-sm">5</span>
                                DADOS DO RESPONSÁVEL FAMILIAR COM QUEM O EDUCANDO MORA
                            </h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div class="md:col-span-1">
                                    <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Nome do Responsável: </label>
                                    <input type="text" name="responsavel_nome" value="{{ $crianca->responsavel->nome }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo" required>
                                </div>

                                <div class="md:col-span-1">
                                    <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Grau de parentesco:</label>
                                    <input type="text" name="responsavel_parentesco" value="{{ $crianca->responsavel->parentesco }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo" required>
                                </div>

                                <div class="md:col-span-1">
                                    <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Estado civil: </label>
                                    <select name="responsavel_estado_civil" class="w-full border-gray-300 rounded-md shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo">
                                        <option value="Solteiro">Solteiro</option>
                                        <option value="Casado">Casado</option>
                                        <option value="Divorciado">Divorciado</option>
                                        <option value="Viuvo">Viuvo</option>
                                        <option value="União Estável">União Estável</option>
                                    </select>
                                </div>

                                <div class="md:col-span-1">
                                    <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Data de nascimento: </label>
                                    <input type="date" name="responsavel_data_nascimento" value="{{ $crianca->responsavel->data_nascimento ? $crianca->responsavel->data_nascimento->format('Y-m-d') : '' }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo" required>
                                </div>

                                <div class="md:col-span-1">
                                    <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Idade: </label>
                                    <input type="number" name="responsavel_idade" value="{{ $crianca->responsavel->idade }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo" required>
                                </div>

                                <div class="md:col-span-1">
                                    <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Grau de Instrução:</label>
                                    <select name="responsavel_grau_instrucao" class="w-full border-gray-300 rounded-md shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo">
                                        <option value="Analfabeto">Analfabeto</option>
                                        <option value="Ensino Fundamental">Ensino Fundamental</option>
                                        <option value="Ensino Médio">Ensino Médio</option>
                                        <option value="Ensino Superior">Ensino Superior</option>
                                    </select>
                                </div>

                               <div class="md:col-span-1">
                                    <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">CPF: </label>
                                    <input type="text" name="responsavel_cpf" value="{{ $crianca->responsavel->cpf }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo" required>
                                </div>

                                <div class="md:col-span-1">
                                    <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">RG: </label>
                                    <input type="text" name="responsavel_rg" value="{{ $crianca->responsavel->rg }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo" required>
                                </div>

                                <div class="md:col-span-1">
                                    <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Programa de Transferência de Renda? </label>
                                    <select name="responsavel_transferencia_renda_tipo" class="w-full border-gray-300 rounded-md shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo">
                                        <option value="nao">Não</option>
                                        <option value="renda minima">Renda minima</option>
                                        <option value="bolsa familia">Bolsa familia</option>
                                        <option value="renda cidadã">Renda Cidadã</option>
                                        <option value="ação jovem">Ação Jovem</option>
                                        <option value="peti">Peti</option>
                                        <option value="auxilio brasil">Auxilio Brasil</option>
                                        <option value="outro">Outro</option>
                                    </select>
                                </div>

                                <div class="md:col-span-1">
                                    <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Benefício de Prestação Continuada? </label>
                                    <select name="responsavel_bpc_tipo" class="w-full border-gray-300 rounded-md shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo">
                                        <option value="nao">Não</option>
                                        <option value="idoso">Idoso</option>
                                        <option value="deficiencia">Pessoa com deficiencia</option>
                                        <option value="outro">outro</option>
                                    </select>
                                </div>
                            </div>

                            <div class="bg-gray-50 p-6 rounded-lg mb-6 border border-gray-200 mt-4">
                                <p class="text-sm text-gray-600 mb-4 font-semibold italic">Informações Socioeconômicas do Responsável:</p>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                    <div class="flex items-center space-x-2">
                                        <input type="checkbox" name="responsavel_tem_cadastro_unico" value="1" id="tem_cadastro_unico" class="rounded text-multirao-roxo focus:ring-multirao-roxo" {{ $crianca->responsavel->tem_cadastro_unico ? 'checked' : '' }}>
                                        <label for="tem_cadastro_unico" class="text-xs font-bold text-gray-700">POSSUI CADÚNICO?</label>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <input type="checkbox" name="responsavel_recebe_transferencia_renda" value="1" id="recebe_transferencia_renda" class="rounded text-multirao-roxo focus:ring-multirao-roxo" {{ $crianca->responsavel->recebe_transferencia_renda ? 'checked' : '' }}>
                                        <label for="recebe_transferencia_renda" class="text-xs font-bold text-gray-700">RECEBE BOLSA FAMÍLIA/AUXÍLIO?</label>
                                    <div class="flex items-center space-x-2">
                                        <input type="checkbox" name="responsavel_recebe_bpc" value="1" id="recebe_bpc" class="rounded text-multirao-roxo focus:ring-multirao-roxo" {{ $crianca->responsavel->recebe_bpc ? 'checked' : '' }}>
                                        <label for="recebe_bpc" class="text-xs font-bold text-gray-700">RECEBE BPC?</label>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4">
                                <label class="block text-xs font-bold text-multirao-roxo uppercase mb-2">Fatores de Risco ou Vulnerabilidade Social</label>
                                <textarea name="responsavel_fatores_risco" rows="3" placeholder="Descreva se há desemprego, problemas de saúde na família, etc..." class="w-full border-gray-300 rounded-md shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo"></textarea>
                            </div>
                        </div>

                        <!-- Seção 6: Upload de Documentos -->
                        <div class="mb-12">
                            <h3 class="text-lg font-bold text-multirao-roxo mb-6 flex items-center">
                                <span class="w-8 h-8 rounded-full bg-multirao-roxo text-white flex items-center justify-center mr-3 text-sm">6</span>
                                Anexos e Documentos (Obrigatório)
                            </h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <div class="border-2 border-dashed border-gray-300 p-6 rounded-lg text-center hover:border-multirao-roxo transition duration-300">
                                    <label class="block text-sm font-bold text-gray-700 mb-2">RG ou CNH do Responsável</label>
                                    <input type="file" name="anexo_rg_responsavel" class="text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-multirao-roxo file:text-white hover:file:bg-opacity-90">
                                    <p class="text-[10px] text-gray-400 mt-2">Formatos aceitos: PDF, JPG, PNG (Máx 2MB)</p>
                                </div>
                                <div class="border-2 border-dashed border-gray-300 p-6 rounded-lg text-center hover:border-multirao-roxo transition duration-300">
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Certidão de Nascimento da Criança</label>
                                    <input type="file" name="anexo_certidao" class="text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-multirao-roxo file:text-white hover:file:bg-opacity-90">
                                    <p class="text-[10px] text-gray-400 mt-2">Documento essencial para aprovação</p>
                                </div>
                                <div class="border-2 border-dashed border-gray-300 p-6 rounded-lg text-center hover:border-multirao-roxo transition duration-300">
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Ficha de Inscrição Preenchida (Excel)</label>
                                    <input type="file" name="anexo_excel_matricula" class="text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-green-600 file:text-white hover:file:bg-opacity-90">
                                    <p class="text-[10px] text-gray-400 mt-2">Opcional: Anexe o arquivo Excel preenchido</p>
                                </div>
                                <div class="border-2 border-dashed border-gray-300 p-6 rounded-lg text-center hover:border-multirao-roxo transition duration-300">
                                    <label class="block text-sm font-bold text-gray-700 mb-2">RG da Criança</label>
                                    <input type="file" name="anexo_rg_crianca" class="text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-multirao-roxo file:text-white hover:file:bg-opacity-90">
                                </div>
                                <div class="border-2 border-dashed border-gray-300 p-6 rounded-lg text-center hover:border-multirao-roxo transition duration-300">
                                    <label class="block text-sm font-bold text-gray-700 mb-2">CPF da Criança</label>
                                    <input type="file" name="anexo_cpf_crianca" class="text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-multirao-roxo file:text-white hover:file:bg-opacity-90">
                                </div>
                                <div class="border-2 border-dashed border-gray-300 p-6 rounded-lg text-center hover:border-multirao-roxo transition duration-300">
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Comprovante de Residência</label>
                                    <input type="file" name="anexo_comprovante_residencia" class="text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-multirao-roxo file:text-white hover:file:bg-opacity-90">
                                </div>
                                <div class="border-2 border-dashed border-gray-300 p-6 rounded-lg text-center hover:border-multirao-roxo transition duration-300">
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Comprovante de Escolaridade</label>
                                    <input type="file" name="anexo_comprovante_escolaridade" class="text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-multirao-roxo file:text-white hover:file:bg-opacity-90">
                                </div>
                                <div class="border-2 border-dashed border-gray-300 p-6 rounded-lg text-center hover:border-multirao-roxo transition duration-300">
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Comprovante de Renda</label>
                                    <input type="file" name="anexo_comprovante_renda" class="text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-multirao-roxo file:text-white hover:file:bg-opacity-90">
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-center mt-10">
                             <button type="submit" class="w-full md:w-auto bg-multirao-roxo hover:bg-opacity-90 text-white font-bold py-4 px-12 rounded-lg shadow-xl transform transition hover:scale-105">
                                FINALIZAR E PEDIR APROVAÇÃO
                            </button><br>
                           
                           
                        </div>
                         <a href="{{ route('dashboard') }}" class="text-sm text-multirao-roxo font-bold hover:underline">
                                ← Cancelar e Voltar para Fila
                            </a>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let familiarIndex = 1;
            const container = document.getElementById('familiares-container');
            const addButton = document.getElementById('add-familiar');

            addButton.addEventListener('click', function() {
                const newRow = document.createElement('div');
                newRow.className = 'familiar-row bg-gray-50 p-6 rounded-xl mb-6 border border-gray-200 relative animate-fade-in-down';
                newRow.innerHTML = `
                    <button type="button" class="remove-familiar absolute -top-3 -right-3 bg-red-500 text-white rounded-full w-8 h-8 flex items-center justify-center hover:bg-red-600 shadow-lg transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="md:col-span-1">
                            <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Nome</label>
                            <input type="text" name="familiares[${familiarIndex}][nome]" class="w-full border-gray-300 rounded-md shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo">
                        </div>
                        <div class="md:col-span-1">
                            <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Data de nascimento</label>
                            <input type="date" name="familiares[${familiarIndex}][data_nascimento]" class="w-full border-gray-300 rounded-md shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo">
                        </div>
                        <div class="md:col-span-1">
                            <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Grau de Parentesco / vínculo</label>
                            <input type="text" name="familiares[${familiarIndex}][parentesco]" class="w-full border-gray-300 rounded-md shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo">
                        </div>
                        <div class="md:col-span-1">
                            <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Grau de Instrução</label>
                            <input type="text" name="familiares[${familiarIndex}][grau_instrucao]" class="w-full border-gray-300 rounded-md shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo">
                        </div>
                        <div class="md:col-span-1">
                            <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Estuda ?</label>
                            <select name="familiares[${familiarIndex}][estuda]" class="w-full border-gray-300 rounded-md shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo">
                                <option value="1">Sim</option>
                                <option value="0">Não</option>
                            </select>
                        </div>
                        <div class="md:col-span-1">
                            <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Inserido em CCA ?</label>
                            <select name="familiares[${familiarIndex}][inserido_cca]" class="w-full border-gray-300 rounded-md shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo">
                                <option value="1">Sim</option>
                                <option value="0">Não</option>
                            </select>
                        </div>
                        <div class="md:col-span-1">
                            <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Profissão / Ocupação</label>
                            <input type="text" name="familiares[${familiarIndex}][profissao]" class="w-full border-gray-300 rounded-md shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo">
                        </div>
                        <div class="md:col-span-1">
                            <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Renda</label>
                            <input type="number" step="0.01" name="familiares[${familiarIndex}][renda]" class="w-full border-gray-300 rounded-md shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo">
                        </div>
                        <div class="md:col-span-1">
                            <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Fator(es) de risco social (b)</label>
                            <input type="text" name="familiares[${familiarIndex}][fatores_risco]" class="w-full border-gray-300 rounded-md shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo">
                        </div>
                    </div>
                `;
                container.appendChild(newRow);
                familiarIndex++;

                newRow.querySelector('.remove-familiar').addEventListener('click', function() {
                    newRow.remove();
                });
            });
        });
    </script>
</x-app-layout>