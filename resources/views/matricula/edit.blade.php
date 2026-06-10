<x-app-layout>
    <div class="py-12">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-t-8 border-multirao-roxo">
                <div class="p-10 text-gray-900">
                    
                    <div class="mb-8 text-center border-b pb-6 flex justify-between items-center">
                        <div class="text-left">
                            <h2 class="text-2xl font-bold text-multirao-roxo mb-2">EDITAR FICHA DE MATRÍCULA</h2>
                            <p class="text-gray-500 text-sm italic">Atualizando informações de <b>{{ $crianca->nome }}</b>.</p>
                        </div>
                        <a href="{{ route('matricula.show', $crianca->id) }}" class="text-sm font-bold text-gray-500 hover:text-multirao-roxo transition flex items-center ml-4">
                            &larr; Cancelar e Voltar
                        </a>
                    </div>

                    <form action="{{ route('matricula.update', $crianca->id) }}" method="POST" enctype="multipart/form-data">
                        <!-- @method('PUT') removido para coincidir com a rota POST em web.php -->
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
                                    <input type="text" name="crianca_cor_raca" value="{{ $crianca->cor_raca }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo">
                                </div>

                                <div class="md:col-span-1">
                                    <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Data de Nascimento:</label>
                                    <input type="date" name="crianca_data_nascimento" value="{{ $crianca->data_nascimento ? $crianca->data_nascimento->format('Y-m-d') : '' }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo" required>
                                </div>

                                <div class="md:col-span-1">
                                    <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Data de Inscrição:</label>
                                    <input type="date" name="crianca_data_inscricao" value="{{ $crianca->data_inscricao ? $crianca->data_inscricao->format('Y-m-d') : '' }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo" required>
                                </div>

                                <div class="md:col-span-1">
                                    <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Data de Matrícula:</label>
                                    <input type="date" name="crianca_data_matricula" value="{{ $crianca->data_matricula ? $crianca->data_matricula->format('Y-m-d') : '' }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo" required>
                                </div>

                                <div class="md:col-span-1">
                                    <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Data do Desligamento: </label>
                                    <input type="date" name="crianca_data_desligamento" value="{{ $crianca->data_desligamento ? $crianca->data_desligamento->format('Y-m-d') : '' }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo">
                                </div>

                                <div class="md:col-span-1">
                                    <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Motivo do desligamento: </label>
                                    <select name="crianca_motivo_desligamento" class="w-full border-gray-300 rounded-md shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo">
                                        <option value="">Selecione...</option>
                                        <option value="abandono" {{ $crianca->motivo_desligamento == 'abandono' ? 'selected' : '' }}>Abandono</option>
                                        <option value="obito" {{ $crianca->motivo_desligamento == 'obito' ? 'selected' : '' }}>Óbito</option>
                                        <option value="mudanca" {{ $crianca->motivo_desligamento == 'mudanca' ? 'selected' : '' }}>Mudança</option>
                                        <option value="idade" {{ $crianca->motivo_desligamento == 'idade' ? 'selected' : '' }}>Limite de idade</option>
                                    </select>
                                </div>

                                <div class="md:col-span-1">
                                    <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Está na Escola: </label>
                                    <select name="crianca_esta_na_escola" class="w-full border-gray-300 rounded-md shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo">
                                        <option value="1" {{ $crianca->esta_na_escola ? 'selected' : '' }}>Sim</option>
                                        <option value="0" {{ !$crianca->esta_na_escola ? 'selected' : '' }}>Não</option>
                                    </select>
                                </div>

                               <div class="md:col-span-1">
                                    <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Nome completo da Escola: </label>
                                    <input type="text" name="crianca_escola" value="{{ $crianca->escola }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo">
                                </div>

                                <div class="md:col-span-1">
                                    <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Tipo Escola: </label>
                                    <select name="crianca_tipo_escola" class="w-full border-gray-300 rounded-md shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo">
                                        <option value="estadual" {{ $crianca->tipo_escola == 'estadual' ? 'selected' : '' }}>Estadual</option>
                                        <option value="municipal" {{ $crianca->tipo_escola == 'municipal' ? 'selected' : '' }}>Municipal</option>
                                        <option value="particular" {{ $crianca->tipo_escola == 'particular' ? 'selected' : '' }}>Particular</option>
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
                                        <option value="integral" {{ $crianca->periodo_escolar == 'integral' ? 'selected' : '' }}>Integral</option>
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
                                    <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Pessoa com deficiência: </label>
                                    <select name="crianca_possui_deficiencia" class="w-full border-gray-300 rounded-md shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo">
                                        <option value="1" {{ $crianca->possui_deficiencia ? 'selected' : '' }}>Sim</option>
                                        <option value="0" {{ !$crianca->possui_deficiencia ? 'selected' : '' }}>Não</option>
                                    </select>
                                </div>

                                <div class="md:col-span-1">
                                    <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Naturalidade:</label>
                                    <input type="text" name="crianca_naturalidade" value="{{ $crianca->naturalidade }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo">
                                </div>

                                @php
                                    $mae = $crianca->responsaveis->where('pivot.parentesco', 'MAE')->first();
                                    $pai = $crianca->responsaveis->where('pivot.parentesco', 'PAI')->first();
                                @endphp

                                <div class="md:col-span-1">
                                    <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Mãe:</label>
                                    <input type="text" name="mae_nome" value="{{ $mae->nome ?? '' }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo">
                                </div>

                                <div class="md:col-span-1">
                                    <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Pai:</label>
                                    <input type="text" name="pai_nome" value="{{ $pai->nome ?? '' }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo">
                                </div>

                                <div class="md:col-span-1">
                                    <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Idade da Mãe:</label>
                                    <input type="number" name="mae_idade" value="{{ $mae->idade ?? '' }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo">
                                </div>

                                <div class="md:col-span-1">
                                    <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Data de Nascimento da Mãe:</label>
                                    <input type="date" name="mae_data_nascimento" value="{{ ($mae && $mae->data_nascimento) ? $mae->data_nascimento->format('Y-m-d') : '' }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo">
                                </div>

                                <div class="md:col-span-1">
                                    <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Idade do Pai: </label>
                                    <input type="number" name="pai_idade" value="{{ $pai->idade ?? '' }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo">
                                </div>

                                <div class="md:col-span-1">
                                    <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Data de Nascimento do Pai:</label>
                                    <input type="date" name="pai_data_nascimento" value="{{ ($pai && $pai->data_nascimento) ? $pai->data_nascimento->format('Y-m-d') : '' }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo">
                                </div>

                                <div class="md:col-span-1">
                                    <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Profissão Mãe: </label>
                                    <input type="text" name="mae_profissao" value="{{ $mae->profissao ?? '' }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo">
                                </div>      

                                <div class="md:col-span-1">
                                    <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Profissão Pai: </label>
                                    <input type="text" name="pai_profissao" value="{{ $pai->profissao ?? '' }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo">
                                </div><br>

                                <div class="md:col-span-1">
                                    <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Desempregada? (Mãe)</label>
                                    <div class="flex gap-4 mt-2">
                                        <label class="flex items-center text-sm"><input type="radio" name="mae_desempregada" value="1" class="mr-1" {{ ($mae && $mae->desempregado) ? 'checked' : '' }}> Sim</label>
                                        <label class="flex items-center text-sm"><input type="radio" name="mae_desempregada" value="0" class="mr-1" {{ ($mae && !$mae->desempregado) ? 'checked' : '' }}> Não</label>
                                    </div>
                                </div>

                                <div class="md:col-span-1">
                                    <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Desempregado? (Pai)</label>
                                    <div class="flex gap-4 mt-2">
                                        <label class="flex items-center text-sm"><input type="radio" name="pai_desempregado" value="1" class="mr-1" {{ ($pai && $pai->desempregado) ? 'checked' : '' }}> Sim</label>
                                        <label class="flex items-center text-sm"><input type="radio" name="pai_desempregado" value="0" class="mr-1" {{ ($pai && !$pai->desempregado) ? 'checked' : '' }}> Não</label>
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
                                    <input type="text" name="moradia_endereco" value="{{ $crianca->moradia->endereco ?? '' }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo" required>
                                </div>

                                <div class="md:col-span-1">
                                    <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Complemento: </label>
                                    <input type="text" name="moradia_complemento" value="{{ $crianca->moradia->complemento ?? '' }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo">
                                </div>
                                
                                <div class="md:col-span-1">
                                    <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">CEP: </label>
                                    <input type="text" name="moradia_cep" value="{{ $crianca->moradia->cep ?? '' }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo">
                                </div>

                                <div class="md:col-span-1">
                                    <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Bairro: </label>
                                    <input type="text" name="moradia_bairro" value="{{ $crianca->moradia->bairro ?? '' }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo">
                                </div>

                                <div class="md:col-span-1">
                                    <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Ponto de Referência: </label>
                                    <input type="text" name="moradia_ponto_referencia" value="{{ $crianca->moradia->ponto_referencia ?? '' }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo">
                                </div>

                                <div class="md:col-span-1">
                                    <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Situação Habitacional</label>
                                    <select name="moradia_situacao_habitacional" class="w-full border-gray-300 rounded-md shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo">
                                        <option value="cortiço" {{ ($crianca->moradia->situacao_habitacional ?? '') == 'cortiço' ? 'selected' : '' }}>Cortiço</option>
                                        <option value="comunidade" {{ ($crianca->moradia->situacao_habitacional ?? '') == 'comunidade' ? 'selected' : '' }}>Comunidade</option>
                                        <option value="loteamento" {{ ($crianca->moradia->situacao_habitacional ?? '') == 'loteamento' ? 'selected' : '' }}>Loteamento</option>
                                         <option value="outro" {{ ($crianca->moradia->situacao_habitacional ?? '') == 'outro' ? 'selected' : '' }}>Outro</option>
                                    </select>
                                </div>

                                <div class="md:col-span-1">
                                    <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Nº de cômodos: </label>
                                    <input type="number" name="moradia_numero_comodos" value="{{ $crianca->moradia->numero_comodos ?? '' }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo">
                                </div>
                               
                                <div class="md:col-span-1">
                                    <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Nº de moradores: </label>
                                    <input type="number" name="moradia_numero_moradores" value="{{ $crianca->moradia->numero_moradores ?? '' }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo">
                                </div>

                                <div class="md:col-span-1">
                                    <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Condições de Moradia</label>
                                    <select name="moradia_condicao_moradia" class="w-full border-gray-300 rounded-md shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo">
                                        <option value="propria" {{ ($crianca->moradia->condicao_moradia ?? '') == 'propria' ? 'selected' : '' }}>Propria</option>
                                        <option value="alugada" {{ ($crianca->moradia->condicao_moradia ?? '') == 'alugada' ? 'selected' : '' }}>Alugada</option>
                                        <option value="cedida" {{ ($crianca->moradia->condicao_moradia ?? '') == 'cedida' ? 'selected' : '' }}>Cedida</option>
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
                            
                            @php
                                $contatoCelular = $crianca->responsavel->contatos->where('tipo', 'CELULAR')->first();
                                $contatoResidencia = $crianca->responsavel->contatos->where('tipo', 'RESIDENCIA')->first();
                                $contatoTrabalho = $crianca->responsavel->contatos->where('tipo', 'TRABALHO')->first();
                                $contatoOutro1 = $crianca->responsavel->contatos->where('tipo', 'OUTRO')->first();
                                $contatoOutro2 = $crianca->responsavel->contatos->where('tipo', 'OUTRO')->skip(1)->first();
                                $contatoRecado = $crianca->responsavel->contatos->where('tipo', 'RECADO')->first();
                            @endphp

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div class="md:col-span-1">
                                    <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Celular</label>
                                    <input type="text" name="contato_celular" value="{{ $contatoCelular->numero ?? $crianca->responsavel->telefone }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo">
                                </div>
                                <div class="md:col-span-1">
                                    <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Residência</label>
                                    <input type="text" name="contato_residencia" value="{{ $contatoResidencia->numero ?? '' }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo">
                                </div>
                                <div class="md:col-span-1">
                                    <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Trabalho: </label>
                                    <input type="text" name="contato_trabalho" value="{{ $contatoTrabalho->numero ?? '' }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo">
                                </div>

                                <div class="md:col-span-1">
                                    <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Outro 1:</label>
                                    <input type="text" name="contato_outro_1" value="{{ $contatoOutro1->numero ?? '' }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo">
                                </div>

                                <div class="md:col-span-1">
                                    <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Outro 2:</label>
                                    <input type="text" name="contato_outro_2" value="{{ $contatoOutro2->numero ?? '' }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo">
                                </div>

                                <div class="md:col-span-1">
                                    <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Recado:</label>
                                    <input type="text" name="contato_recado" value="{{ $contatoRecado->numero ?? '' }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo">
                                </div>

                                <div class="md:col-span-1">
                                    <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Pessoa de Contato: </label>
                                    <input type="text" name="contato_pessoa_nome" value="{{ $contatoRecado->pessoa_contato ?? '' }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo">
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
                                <button type="button" id="add-familiar" class="bg-green-800 hover:bg-green-600 text-white text-xs font-bold py-2 px-4 rounded-full transition flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                    ADICIONAR MORADOR
                                </button>
                            </div>
                            
                            <div id="familiares-container">
                                @forelse($crianca->familiares as $index => $familiar)
                                    <div class="familiar-row bg-gray-50 p-6 rounded-xl mb-6 border border-gray-200 relative">
                                        <button type="button" class="remove-familiar absolute -top-3 -right-3 bg-red-500 text-white rounded-full w-8 h-8 flex items-center justify-center hover:bg-red-600 shadow-lg transition">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                            <div class="md:col-span-1">
                                                <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Nome</label>
                                                <input type="text" name="familiares[{{ $index }}][nome]" value="{{ $familiar->nome }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo">
                                            </div>
                                            <div class="md:col-span-1">
                                                <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Data de nascimento</label>
                                                <input type="date" name="familiares[{{ $index }}][data_nascimento]" value="{{ $familiar->data_nascimento ? $familiar->data_nascimento->format('Y-m-d') : '' }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo">
                                            </div>
                                            <div class="md:col-span-1">
                                                <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Grau de Parentesco / vínculo</label>
                                                <input type="text" name="familiares[{{ $index }}][parentesco]" value="{{ $familiar->grau_parentesco }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo">
                                            </div>
                                  
                                            <div class="md:col-span-1">
                                                <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Grau de Instrução</label>
                                                <input type="text" name="familiares[{{ $index }}][grau_instrucao]" value="{{ $familiar->grau_instrucao }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo">
                                            </div>

                                            <div class="md:col-span-1">
                                                <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Estuda ?</label>
                                                <select name="familiares[{{ $index }}][estuda]" class="w-full border-gray-300 rounded-md shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo">
                                                    <option value="1" {{ $familiar->estuda ? 'selected' : '' }}>Sim</option>
                                                    <option value="0" {{ !$familiar->estuda ? 'selected' : '' }}>Não</option>
                                                </select>
                                            </div>

                                            <div class="md:col-span-1">
                                                <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Inserido em CCA ?</label>
                                                <select name="familiares[{{ $index }}][inserido_cca]" class="w-full border-gray-300 rounded-md shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo">
                                                    <option value="1" {{ $familiar->inserido_cca ? 'selected' : '' }}>Sim</option>
                                                    <option value="0" {{ !$familiar->inserido_cca ? 'selected' : '' }}>Não</option>
                                                </select>
                                            </div>

                                             <div class="md:col-span-1">
                                                <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Profissão / Ocupação</label>
                                                <input type="text" name="familiares[{{ $index }}][profissao]" value="{{ $familiar->profissao }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo">
                                            </div>

                                             <div class="md:col-span-1">
                                                <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Renda</label>
                                                <input type="number" step="0.01" name="familiares[{{ $index }}][renda]" value="{{ $familiar->renda }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo">
                                            </div>

                                             <div class="md:col-span-1">
                                                <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Fator(es) de risco social (b)</label>
                                                <input type="text" name="familiares[{{ $index }}][fatores_risco]" value="{{ $familiar->fatores_risco }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo">
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <!-- Caso não tenha familiares, exibe um vazio pronto para preencher -->
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
                                @endforelse
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
                                        <option value="Solteiro" {{ $crianca->responsavel->estado_civil == 'Solteiro' ? 'selected' : '' }}>Solteiro</option>
                                        <option value="Casado" {{ $crianca->responsavel->estado_civil == 'Casado' ? 'selected' : '' }}>Casado</option>
                                        <option value="Divorciado" {{ $crianca->responsavel->estado_civil == 'Divorciado' ? 'selected' : '' }}>Divorciado</option>
                                        <option value="Viuvo" {{ $crianca->responsavel->estado_civil == 'Viuvo' ? 'selected' : '' }}>Viuvo</option>
                                        <option value="União Estável" {{ $crianca->responsavel->estado_civil == 'União Estável' ? 'selected' : '' }}>União Estável</option>
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
                                        <option value="Analfabeto" {{ $crianca->responsavel->grau_instrucao == 'Analfabeto' ? 'selected' : '' }}>Analfabeto</option>
                                        <option value="Ensino Fundamental" {{ $crianca->responsavel->grau_instrucao == 'Ensino Fundamental' ? 'selected' : '' }}>Ensino Fundamental</option>
                                        <option value="Ensino Médio" {{ $crianca->responsavel->grau_instrucao == 'Ensino Médio' ? 'selected' : '' }}>Ensino Médio</option>
                                        <option value="Ensino Superior" {{ $crianca->responsavel->grau_instrucao == 'Ensino Superior' ? 'selected' : '' }}>Ensino Superior</option>
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
                                    </div>
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
                                Anexos e Documentos (Substituir se desejar)
                            </h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                                <div class="border-2 border-dashed border-gray-300 p-6 rounded-lg text-center hover:border-multirao-roxo transition duration-300 {{ $crianca->responsavel->anexo_rg ? 'bg-green-50' : '' }}">
                                    <label class="block text-sm font-bold text-gray-700 mb-2">RG ou CNH do Responsável</label>
                                    @if($crianca->responsavel->anexo_rg)
                                        <p class="text-[10px] text-green-600 font-bold mb-2 flex items-center justify-center">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                            JÁ ENVIADO
                                        </p>
                                    @endif
                                    <input type="file" name="anexo_rg_responsavel" style="width: 140px;" class="text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-multirao-roxo file:text-white hover:file:bg-opacity-90">
                                </div>
                                <div class="border-2 border-dashed border-gray-300 p-6 rounded-lg text-center hover:border-multirao-roxo transition duration-300 {{ $crianca->anexo_certidao ? 'bg-green-50' : '' }}">
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Certidão de Nascimento da Criança</label>
                                    @if($crianca->anexo_certidao)
                                        <p class="text-[10px] text-green-600 font-bold mb-2 flex items-center justify-center">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                            JÁ ENVIADO
                                        </p>
                                    @endif
                                    <input type="file" name="anexo_certidao" style="width: 140px;"  class="text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-multirao-roxo file:text-white hover:file:bg-opacity-90">
                                </div>
                                <div class="border-2 border-dashed border-gray-300 p-6 rounded-lg text-center hover:border-multirao-roxo transition duration-300 {{ $crianca->anexo_excel_matricula ? 'bg-green-50' : '' }}">
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Ficha de Inscrição (Excel)</label>
                                    @if($crianca->anexo_excel_matricula)
                                        <p class="text-[10px] text-green-600 font-bold mb-2 flex items-center justify-center">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                            JÁ ENVIADO
                                        </p>
                                    @endif
                                    <input type="file" name="anexo_excel_matricula" style="width: 140px;" class="text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-multirao-roxo file:text-white hover:file:bg-opacity-90">
                                </div>
                                <div class="border-2 border-dashed border-gray-300 p-6 rounded-lg text-center hover:border-multirao-roxo transition duration-300 {{ $crianca->anexo_rg ? 'bg-green-50' : '' }}">
                                    <label class="block text-sm font-bold text-gray-700 mb-2">RG da Criança</label>
                                    @if($crianca->anexo_rg)
                                        <p class="text-[10px] text-green-600 font-bold mb-2 flex items-center justify-center">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                            JÁ ENVIADO
                                        </p>
                                    @endif
                                    <input type="file" name="anexo_rg_crianca" style="width: 140px;" class="text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-multirao-roxo file:text-white hover:file:bg-opacity-90">
                                </div>
                                <div class="border-2 border-dashed border-gray-300 p-6 rounded-lg text-center hover:border-multirao-roxo transition duration-300 {{ $crianca->anexo_cpf ? 'bg-green-50' : '' }}">
                                    <label class="block text-sm font-bold text-gray-700 mb-2">CPF da Criança</label>
                                    @if($crianca->anexo_cpf)
                                        <p class="text-[10px] text-green-600 font-bold mb-2 flex items-center justify-center">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                            JÁ ENVIADO
                                        </p>
                                    @endif
                                    <input type="file" name="anexo_cpf_crianca" style="width: 140px;" class="text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-multirao-roxo file:text-white hover:file:bg-opacity-90">
                                </div>
                                <div class="border-2 border-dashed border-gray-300 p-6 rounded-lg text-center hover:border-multirao-roxo transition duration-300 {{ $crianca->anexo_comprovante_residencia ? 'bg-green-50' : '' }}">
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Comprovante de Residência</label>
                                    @if($crianca->anexo_comprovante_residencia)
                                        <p class="text-[10px] text-green-600 font-bold mb-2 flex items-center justify-center">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                            JÁ ENVIADO
                                        </p>
                                    @endif
                                    <input type="file" name="anexo_comprovante_residencia" style="width: 140px;" class="text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-multirao-roxo file:text-white hover:file:bg-opacity-90">
                                </div>
                                <div class="border-2 border-dashed border-gray-300 p-6 rounded-lg text-center hover:border-multirao-roxo transition duration-300 {{ $crianca->anexo_comprovante_escolaridade ? 'bg-green-50' : '' }}">
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Comprovante de Escolaridade</label>
                                    @if($crianca->anexo_comprovante_escolaridade)
                                        <p class="text-[10px] text-green-600 font-bold mb-2 flex items-center justify-center">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                            JÁ ENVIADO
                                        </p>
                                    @endif
                                    <input type="file" name="anexo_comprovante_escolaridade" style="width: 140px;" class="text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-multirao-roxo file:text-white hover:file:bg-opacity-90">
                                </div>
                                <div class="border-2 border-dashed border-gray-300 p-6 rounded-lg text-center hover:border-multirao-roxo transition duration-300 {{ $crianca->anexo_comprovante_renda ? 'bg-green-50' : '' }}">
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Comprovante de Renda</label>
                                    @if($crianca->anexo_comprovante_renda)
                                        <p class="text-[10px] text-green-600 font-bold mb-2 flex items-center justify-center">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                            JÁ ENVIADO
                                        </p>
                                    @endif
                                    <input type="file" name="anexo_comprovante_renda" style="width: 140px;" class="text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-multirao-roxo file:text-white hover:file:bg-opacity-90">
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-center mt-10">
                            <button type="submit" class="w-full md:w-auto bg-multirao-roxo hover:bg-opacity-90 text-white font-bold py-4 px-16 rounded-lg shadow-xl transform transition hover:scale-105 uppercase tracking-widest">
                                SALVAR ALTERAÇÕES
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let familiarIndex = {{ $crianca->familiares->count() > 0 ? $crianca->familiares->count() : 1 }};
            const container = document.getElementById('familiares-container');
            const addButton = document.getElementById('add-familiar');

            // Adicionar funcionalidade de remover aos que já existem
            document.querySelectorAll('.remove-familiar').forEach(button => {
                button.addEventListener('click', function() {
                    this.closest('.familiar-row').remove();
                });
            });

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