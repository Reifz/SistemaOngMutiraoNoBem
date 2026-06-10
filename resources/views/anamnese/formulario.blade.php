<x-app-layout>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-6">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-t-4 border-multirao-roxo">
            <div class="p-6">
                <div class="flex justify-between items-center mb-6 border-b pb-4">
                    <h2 class="text-2xl font-bold text-multirao-roxo uppercase">
                        Formulário de Anamnese (Saúde e Histórico)
                    </h2>
                    <span class="text-xs bg-red-100 text-red-700 px-3 py-1 rounded-full font-bold uppercase">Dados Sensíveis - LGPD</span>
                </div>

                <form action="{{ route('anamnese.store', $crianca->id) }}" method="POST">
                    @csrf
                    
                    <div class="mb-8 p-4 bg-gray-50 rounded-lg border border-gray-200 flex justify-between items-center">
                        <div>
                            <h3 class="text-sm font-bold text-gray-700 uppercase mb-2">Paciente:</h3>
                            <p class="text-lg font-bold text-multirao-roxo">{{ $crianca->nome }}</p>
                        </div>
                        <div class="text-right">
                            <h3 class="text-sm font-bold text-gray-700 uppercase mb-2">Responsável:</h3>
                            <p class="text-md font-bold text-gray-600">{{ $crianca->responsavel->nome }}</p>
                        </div>
                    </div>

                    <!-- Seção 0: Informação -->
                    <div class="space-y-6 mb-8 bg-blue-50 p-6 rounded-xl border border-blue-100 shadow-sm">
                        <h3 class="text-lg font-bold text-multirao-roxo uppercase border-b-2 border-multirao-roxo/20 pb-1 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                            </svg>
                            Informação
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1 tracking-tight">Dados respondidos por:</label>
                                <input type="text" name="respondido_por" value="{{ $dados['respondido_por'] ?? '' }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo" placeholder="Nome de quem prestou as informações">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1 tracking-tight">Data:</label>
                                <input type="date" name="data_preenchimento" value="{{ $dados['data_preenchimento'] ?? date('Y-m-d') }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo">
                            </div>
                        </div>
                    </div>

                    <!-- Seção 1: Dados Pessoais -->
                    <div class="space-y-6 mb-8">
                        <h3 class="text-lg font-bold text-multirao-roxo uppercase border-b-2 border-multirao-roxo/20 pb-1">Dados Pessoais</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1 tracking-tight">Tem apelidos?</label>
                                <input type="text" name="apelidos" value="{{ $dados['apelidos'] ?? '' }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo" placeholder="Liste os apelidos...">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1 tracking-tight">Tem algum apelido que não gosta de ser chamado?</label>
                                <input type="text" name="apelidos_indesejados" value="{{ $dados['apelidos_indesejados'] ?? '' }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo" placeholder="Qual apelido desagrada?">
                            </div>
                        </div>
                    </div>

                    <!-- Seção 2: Esquema Familiar -->
                    <div class="space-y-6 mb-8">
                        <h3 class="text-lg font-bold text-multirao-roxo uppercase border-b-2 border-multirao-roxo/20 pb-1">Esquema Familiar</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1 tracking-tight">Quem é o responsável que está a frente da rotina da criança?</label>
                                <select name="responsavel_rotina" class="w-full rounded-md border-gray-300 shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo">
                                    <option value="">Selecione...</option>
                                    <option value="mae" {{ ($dados['responsavel_rotina'] ?? '') == 'mae' ? 'selected' : '' }}>Mãe</option>
                                    <option value="pai" {{ ($dados['responsavel_rotina'] ?? '') == 'pai' ? 'selected' : '' }}>Pai</option>
                                    <option value="mae e pai" {{ ($dados['responsavel_rotina'] ?? '') == 'mae e pai' ? 'selected' : '' }}>Mãe e Pai</option>
                                    <option value="outros" {{ ($dados['responsavel_rotina'] ?? '') == 'outros' ? 'selected' : '' }}>Outros</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1 tracking-tight">Qual motivo?</label>
                                <input type="text" name="motivo_responsavel_rotina" value="{{ $dados['motivo_responsavel_rotina'] ?? '' }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo" placeholder="Justificativa...">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1 tracking-tight">Tem avós, tios ou parentes por perto?</label>
                                <select name="parentes_proximos" class="w-full rounded-md border-gray-300 shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo">
                                    <option value="">Selecione...</option>
                                    <option value="sim" {{ ($dados['parentes_proximos'] ?? '') == 'sim' ? 'selected' : '' }}>Sim</option>
                                    <option value="nao" {{ ($dados['parentes_proximos'] ?? '') == 'nao' ? 'selected' : '' }}>Não</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1 tracking-tight">Situação dos pais?</label>
                                <select name="situacao_pais" class="w-full rounded-md border-gray-300 shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo">
                                    <option value="">Selecione...</option>
                                    <option value="casados" {{ ($dados['situacao_pais'] ?? '') == 'casados' ? 'selected' : '' }}>Casados</option>
                                    <option value="união estável" {{ ($dados['situacao_pais'] ?? '') == 'união estável' ? 'selected' : '' }}>União Estável</option>
                                    <option value="separados" {{ ($dados['situacao_pais'] ?? '') == 'separados' ? 'selected' : '' }}>Separados</option>
                                    <option value="outro" {{ ($dados['situacao_pais'] ?? '') == 'outro' ? 'selected' : '' }}>Outro</option>
                                </select>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1 tracking-tight">Como é a dinâmica da família em relação à guarda da criança e convivência com cada um dos pais?</label>
                            <textarea name="dinamica_guarda_convivencia" rows="3" class="w-full rounded-md border-gray-300 shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo" placeholder="Descreva a dinâmica familiar...">{{ $dados['dinamica_guarda_convivencia'] ?? '' }}</textarea>
                        </div>
                    </div>

                    <!-- Seção 3: História Escolar -->
                    <div class="space-y-6 mb-8">
                        <h3 class="text-lg font-bold text-multirao-roxo uppercase border-b-2 border-multirao-roxo/20 pb-1">História Escolar</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1 tracking-tight">Entrou com que idade na escola?</label>
                                <input type="text" name="idade_entrada_escola" value="{{ $dados['idade_entrada_escola'] ?? '' }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1 tracking-tight">Frequentou a Educação Infantil?</label>
                                <select name="frequentou_educacao_infantil" class="w-full rounded-md border-gray-300 shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo">
                                    <option value="">Selecione...</option>
                                    <option value="sim" {{ ($dados['frequentou_educacao_infantil'] ?? '') == 'sim' ? 'selected' : '' }}>Sim</option>
                                    <option value="nao" {{ ($dados['frequentou_educacao_infantil'] ?? '') == 'nao' ? 'selected' : '' }}>Não</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1 tracking-tight">Já foi Reprovado?</label>
                                <select name="reprovado" class="w-full rounded-md border-gray-300 shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo">
                                    <option value="">Selecione...</option>
                                    <option value="sim" {{ ($dados['reprovado'] ?? '') == 'sim' ? 'selected' : '' }}>Sim</option>
                                    <option value="nao" {{ ($dados['reprovado'] ?? '') == 'nao' ? 'selected' : '' }}>Não</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1 tracking-tight">Já fez reforço?</label>
                                <select name="reforco" class="w-full rounded-md border-gray-300 shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo">
                                    <option value="">Selecione...</option>
                                    <option value="sim" {{ ($dados['reforco'] ?? '') == 'sim' ? 'selected' : '' }}>Sim</option>
                                    <option value="nao" {{ ($dados['reforco'] ?? '') == 'nao' ? 'selected' : '' }}>Não</option>
                                </select>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1 tracking-tight">Apresenta alguma dificuldade de aprendizagem?</label>
                                <textarea name="dificuldade_aprendizagem" rows="2" class="w-full rounded-md border-gray-300 shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo">{{ $dados['dificuldade_aprendizagem'] ?? '' }}</textarea>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1 tracking-tight">Houve algum problema com professor(es)?</label>
                                <textarea name="problema_professores" rows="2" class="w-full rounded-md border-gray-300 shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo">{{ $dados['problema_professores'] ?? '' }}</textarea>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1 tracking-tight">Como a criança é na escola?</label>
                                <textarea name="comportamento_escola" rows="2" class="w-full rounded-md border-gray-300 shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo">{{ $dados['comportamento_escola'] ?? '' }}</textarea>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1 tracking-tight">Enfrentou ou enfrenta alguma queixa ou problema aparente em relação a escola?</label>
                                <textarea name="queixas_problemas_escola" rows="2" class="w-full rounded-md border-gray-300 shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo">{{ $dados['queixas_problemas_escola'] ?? '' }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Seção 4: HISTÓRIA DE VIDA -->
                    <div class="space-y-6 mb-8">
                        <h3 class="text-lg font-bold text-multirao-roxo uppercase border-b-2 border-multirao-roxo/20 pb-1">HISTÓRIA DE VIDA</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1 tracking-tight">A criança foi desejada?</label>
                                <select name="desejada" class="w-full rounded-md border-gray-300 shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo">
                                    <option value="">Selecione...</option>
                                    <option value="sim" {{ ($dados['desejada'] ?? '') == 'sim' ? 'selected' : '' }}>Sim</option>
                                    <option value="nao" {{ ($dados['desejada'] ?? '') == 'nao' ? 'selected' : '' }}>Não</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1 tracking-tight">Perturbou ou causou transtornos na vida de um dos pais?</label>
                                <input type="text" name="causou_transtorno_pais" value="{{ $dados['causou_transtorno_pais'] ?? '' }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo">
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1 tracking-tight">Houve algum problema no processo de desenvolvimento (Fala, alimentação e andar)?</label>
                                <textarea name="problemas_desenvolvimento" rows="2" class="w-full rounded-md border-gray-300 shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo">{{ $dados['problemas_desenvolvimento'] ?? '' }}</textarea>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1 tracking-tight">Qual dessas características você enxerga na criança?</label>
                                <textarea name="caracteristicas_crianca" rows="2" class="w-full rounded-md border-gray-300 shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo">{{ $dados['caracteristicas_crianca'] ?? '' }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Seção 5: HISTÓRICO CLÍNICO -->
                    <div class="space-y-6 mb-8">
                        <h3 class="text-lg font-bold text-multirao-roxo uppercase border-b-2 border-multirao-roxo/20 pb-1">HISTÓRICO CLÍNICO</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1 tracking-tight">Realiza ou já realizou algum tratamento especializado? (Fonoaudiólogo, psicólogo, outros)?</label>
                                <textarea name="tratamento_especializado" rows="2" class="w-full rounded-md border-gray-300 shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo">{{ $dados['tratamento_especializado'] ?? '' }}</textarea>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1 tracking-tight">Apresenta alguma dessas dificuldades?</label>
                                <div class="grid grid-cols-2 gap-2 mt-2">
                                    @php $dificuldades = $dados['dificuldades_especificas'] ?? []; @endphp
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" name="dificuldades_especificas[]" value="Motora" {{ in_array('Motora', (array)$dificuldades) ? 'checked' : '' }} class="rounded border-gray-300 text-multirao-roxo focus:ring-multirao-roxo">
                                        <span class="ml-2 text-sm text-gray-700">Motora</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" name="dificuldades_especificas[]" value="Fala" {{ in_array('Fala', (array)$dificuldades) ? 'checked' : '' }} class="rounded border-gray-300 text-multirao-roxo focus:ring-multirao-roxo">
                                        <span class="ml-2 text-sm text-gray-700">Fala</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" name="dificuldades_especificas[]" value="visao" {{ in_array('visao', (array)$dificuldades) ? 'checked' : '' }} class="rounded border-gray-300 text-multirao-roxo focus:ring-multirao-roxo">
                                        <span class="ml-2 text-sm text-gray-700">Visão</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" name="dificuldades_especificas[]" value="Audição" {{ in_array('Audição', (array)$dificuldades) ? 'checked' : '' }} class="rounded border-gray-300 text-multirao-roxo focus:ring-multirao-roxo">
                                        <span class="ml-2 text-sm text-gray-700">Audição</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1 tracking-tight">Tem algum problema de saúde que requer acompanhamento especifico?</label>
                            <textarea name="problemas_saude_especificos" rows="2" class="w-full rounded-md border-gray-300 shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo">{{ $dados['problemas_saude_especificos'] ?? '' }}</textarea>
                        </div>
                    </div>

                    <!-- Seção 6: HISTÓRIA DA FAMÍLIA AMPLIADA -->
                    <div class="space-y-6 mb-8">
                        <h3 class="text-lg font-bold text-multirao-roxo uppercase border-b-2 border-multirao-roxo/20 pb-1">HISTÓRIA DA "FAMÍLIA AMPLIADA"</h3>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1 tracking-tight">Descreva algum fator relevante que a criança presenciou ou passou, que pode ter sido marcante/impactante:</label>
                            <textarea name="fator_marcante" rows="3" class="w-full rounded-md border-gray-300 shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo">{{ $dados['fator_marcante'] ?? '' }}</textarea>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1 tracking-tight">Como é a relação com os membros da família?</label>
                                <textarea name="relacao_familiares" rows="2" class="w-full rounded-md border-gray-300 shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo">{{ $dados['relacao_familiares'] ?? '' }}</textarea>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1 tracking-tight">Qual é a atitude dos pais/responsáveis diante da falta de limite da criança?</label>
                                <textarea name="atitude_pais_limites" rows="2" class="w-full rounded-md border-gray-300 shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo">{{ $dados['atitude_pais_limites'] ?? '' }}</textarea>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1 tracking-tight">Como a criança reage?</label>
                                <input type="text" name="reacao_crianca_limites" value="{{ $dados['reacao_crianca_limites'] ?? '' }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1 tracking-tight">Tem alguém que protege?</label>
                                <input type="text" name="protege_crianca" value="{{ $dados['protege_crianca'] ?? '' }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo">
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1 tracking-tight">Quem a auxilia nas lições de casa e estudos?</label>
                                <input type="text" name="auxilia_estudos" value="{{ $dados['auxilia_estudos'] ?? '' }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1 tracking-tight">A criança possui alguma responsabilidade/tarefa em casa?</label>
                                <input type="text" name="responsabilidades_casa" value="{{ $dados['responsabilidades_casa'] ?? '' }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo">
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1 tracking-tight">Como se relaciona com os colegas?</label>
                                <input type="text" name="relacao_colegas" value="{{ $dados['relacao_colegas'] ?? '' }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1 tracking-tight">O que você mais gosta na criança?</label>
                                <input type="text" name="gosta_na_crianca" value="{{ $dados['gosta_na_crianca'] ?? '' }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1 tracking-tight">O que te desagrada ou incomoda na criança?</label>
                            <input type="text" name="desagrada_na_crianca" value="{{ $dados['desagrada_na_crianca'] ?? '' }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo">
                        </div>
                    </div>

                    <div class="flex gap-4 mt-12 border-t pt-8">
                        <a href="{{ route('anamnese.index') }}" class="px-6 py-4 bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold rounded-lg transition duration-300 uppercase tracking-widest text-center flex-1">
                            Cancelar
                        </a>
                        <button type="submit" class="flex-[2] bg-multirao-roxo hover:bg-opacity-90 text-white font-bold py-4 rounded-lg shadow-lg transition duration-300 uppercase tracking-widest">
                            Salvar Anamnese
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>