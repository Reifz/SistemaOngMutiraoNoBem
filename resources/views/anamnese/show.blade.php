<x-app-layout>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-6">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-t-4 border-multirao-roxo">
            <div class="p-6">
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

                <div class="flex justify-between items-center mb-6 border-b pb-4">
                    <h2 class="text-2xl font-bold text-multirao-roxo uppercase">
                        Visualização de Anamnese
                    </h2>
                    <div class="flex gap-2">
                        <a href="{{ route('anamnese.pdf', $crianca->id) }}" class="bg-multirao-amarelo text-multirao-roxo font-bold py-2 px-4 rounded text-xs transition duration-300 shadow-sm uppercase flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm5 6a1 1 0 10-2 0v3.586l-1.293-1.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 11.586V8z" clip-rule="evenodd"></path></svg>
                            Exportar PDF
                        </a>
                        @if(!in_array($crianca->status, ['EM_TURMA', 'EVADIDA']))
                            <a href="{{ route('anamnese.edit', $crianca->id) }}" class="bg-amber-500 hover:bg-amber-600 text-white font-bold py-2 px-4 rounded text-xs transition duration-300 shadow-sm uppercase flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                Editar Dados
                            </a>
                        @endif
                    </div>
                </div>

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
                <div class="mb-8 bg-blue-50 p-6 rounded-xl border border-blue-100 shadow-sm">
                    <h3 class="text-lg font-bold text-multirao-roxo uppercase border-b-2 border-multirao-roxo/20 pb-1 mb-4 flex items-center gap-2">
                        Informação
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <span class="block text-xs font-bold text-gray-500 uppercase">Dados respondidos por:</span>
                            <p class="text-md font-semibold text-gray-800">{{ $dados['respondido_por'] ?? 'Não informado' }}</p>
                        </div>
                        <div>
                            <span class="block text-xs font-bold text-gray-500 uppercase">Data:</span>
                            <p class="text-md font-semibold text-gray-800">{{ isset($dados['data_preenchimento']) ? date('d/m/Y', strtotime($dados['data_preenchimento'])) : 'Não informado' }}</p>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-8">
                    <!-- Seção 1: Dados Pessoais -->
                    <div class="border rounded-lg p-6">
                        <h3 class="text-lg font-bold text-multirao-roxo uppercase border-b pb-2 mb-4">Dados Pessoais</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <span class="block text-xs font-bold text-gray-500 uppercase tracking-tight">Tem apelidos?</span>
                                <p class="text-gray-800 font-medium">{{ $dados['apelidos'] ?? 'Não informado' }}</p>
                            </div>
                            <div>
                                <span class="block text-xs font-bold text-gray-500 uppercase tracking-tight">Apelidos que não gosta:</span>
                                <p class="text-gray-800 font-medium">{{ $dados['apelidos_indesejados'] ?? 'Não informado' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Seção 2: Esquema Familiar -->
                    <div class="border rounded-lg p-6">
                        <h3 class="text-lg font-bold text-multirao-roxo uppercase border-b pb-2 mb-4">Esquema Familiar</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <span class="block text-xs font-bold text-gray-500 uppercase tracking-tight">Responsável pela rotina:</span>
                                <p class="text-gray-800 font-medium uppercase">{{ $dados['responsavel_rotina'] ?? 'Não informado' }}</p>
                            </div>
                            <div>
                                <span class="block text-xs font-bold text-gray-500 uppercase tracking-tight">Motivo:</span>
                                <p class="text-gray-800 font-medium">{{ $dados['motivo_responsavel_rotina'] ?? 'Não informado' }}</p>
                            </div>
                            <div>
                                <span class="block text-xs font-bold text-gray-500 uppercase tracking-tight">Parentes por perto?</span>
                                <p class="text-gray-800 font-medium uppercase">{{ $dados['parentes_proximos'] ?? 'Não informado' }}</p>
                            </div>
                            <div>
                                <span class="block text-xs font-bold text-gray-500 uppercase tracking-tight">Situação dos pais:</span>
                                <p class="text-gray-800 font-medium uppercase">{{ $dados['situacao_pais'] ?? 'Não informado' }}</p>
                            </div>
                        </div>
                        <div>
                            <span class="block text-xs font-bold text-gray-500 uppercase tracking-tight">Dinâmica de guarda e convivência:</span>
                            <p class="text-gray-800 font-medium italic">{{ $dados['dinamica_guarda_convivencia'] ?? 'Não informado' }}</p>
                        </div>
                    </div>

                    <!-- Seção 3: História Escolar -->
                    <div class="border rounded-lg p-6">
                        <h3 class="text-lg font-bold text-multirao-roxo uppercase border-b pb-2 mb-4">História Escolar</h3>
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
                            <div>
                                <span class="block text-xs font-bold text-gray-500 uppercase tracking-tight">Idade entrada:</span>
                                <p class="text-gray-800 font-medium">{{ $dados['idade_entrada_escola'] ?? 'Não informado' }}</p>
                            </div>
                            <div>
                                <span class="block text-xs font-bold text-gray-500 uppercase tracking-tight">Ed. Infantil?</span>
                                <p class="text-gray-800 font-medium uppercase">{{ $dados['frequentou_educacao_infantil'] ?? 'Não informado' }}</p>
                            </div>
                            <div>
                                <span class="block text-xs font-bold text-gray-500 uppercase tracking-tight">Reprovado?</span>
                                <p class="text-gray-800 font-medium uppercase">{{ $dados['reprovado'] ?? 'Não informado' }}</p>
                            </div>
                            <div>
                                <span class="block text-xs font-bold text-gray-500 uppercase tracking-tight">Reforço?</span>
                                <p class="text-gray-800 font-medium uppercase">{{ $dados['reforco'] ?? 'Não informado' }}</p>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <span class="block text-xs font-bold text-gray-500 uppercase tracking-tight">Dificuldade aprendizagem:</span>
                                <p class="text-gray-800 font-medium">{{ $dados['dificuldade_aprendizagem'] ?? 'Não informado' }}</p>
                            </div>
                            <div>
                                <span class="block text-xs font-bold text-gray-500 uppercase tracking-tight">Problemas com professores:</span>
                                <p class="text-gray-800 font-medium">{{ $dados['problema_professores'] ?? 'Não informado' }}</p>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <span class="block text-xs font-bold text-gray-500 uppercase tracking-tight">Comportamento na escola:</span>
                                <p class="text-gray-800 font-medium">{{ $dados['comportamento_escola'] ?? 'Não informado' }}</p>
                            </div>
                            <div>
                                <span class="block text-xs font-bold text-gray-500 uppercase tracking-tight">Queixas ou problemas:</span>
                                <p class="text-gray-800 font-medium">{{ $dados['queixas_problemas_escola'] ?? 'Não informado' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Seção 4: HISTÓRIA DE VIDA -->
                    <div class="border rounded-lg p-6">
                        <h3 class="text-lg font-bold text-multirao-roxo uppercase border-b pb-2 mb-4">História de Vida</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <span class="block text-xs font-bold text-gray-500 uppercase tracking-tight">Criança desejada?</span>
                                <p class="text-gray-800 font-medium uppercase">{{ $dados['desejada'] ?? 'Não informado' }}</p>
                            </div>
                            <div>
                                <span class="block text-xs font-bold text-gray-500 uppercase tracking-tight">Causou transtornos/perturbações?</span>
                                <p class="text-gray-800 font-medium">{{ $dados['causou_transtorno_pais'] ?? 'Não informado' }}</p>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <span class="block text-xs font-bold text-gray-500 uppercase tracking-tight">Problemas desenvolvimento:</span>
                                <p class="text-gray-800 font-medium">{{ $dados['problemas_desenvolvimento'] ?? 'Não informado' }}</p>
                            </div>
                            <div>
                                <span class="block text-xs font-bold text-gray-500 uppercase tracking-tight">Características:</span>
                                <p class="text-gray-800 font-medium">{{ $dados['caracteristicas_crianca'] ?? 'Não informado' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Seção 5: HISTÓRICO CLÍNICO -->
                    <div class="border rounded-lg p-6">
                        <h3 class="text-lg font-bold text-multirao-roxo uppercase border-b pb-2 mb-4">Histórico Clínico</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <span class="block text-xs font-bold text-gray-500 uppercase tracking-tight">Tratamento especializado:</span>
                                <p class="text-gray-800 font-medium">{{ $dados['tratamento_especializado'] ?? 'Não informado' }}</p>
                            </div>
                            <div>
                                <span class="block text-xs font-bold text-gray-500 uppercase tracking-tight">Dificuldades:</span>
                                <div class="flex flex-wrap gap-2 mt-1">
                                    @php $dificuldades = $dados['dificuldades_especificas'] ?? []; @endphp
                                    @forelse((array)$dificuldades as $dif)
                                        <span class="bg-multirao-roxo/10 text-multirao-roxo text-xs font-bold px-2 py-1 rounded">{{ $dif }}</span>
                                    @empty
                                        <span class="text-gray-500">Nenhuma dificuldade informada</span>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                        <div>
                            <span class="block text-xs font-bold text-gray-500 uppercase tracking-tight">Problemas de saúde específicos:</span>
                            <p class="text-gray-800 font-medium">{{ $dados['problemas_saude_especificos'] ?? 'Não informado' }}</p>
                        </div>
                    </div>

                    <!-- Seção 6: HISTÓRIA DA FAMÍLIA AMPLIADA -->
                    <div class="border rounded-lg p-6">
                        <h3 class="text-lg font-bold text-multirao-roxo uppercase border-b pb-2 mb-4">Família Ampliada e Relações</h3>
                        <div class="mb-4">
                            <span class="block text-xs font-bold text-gray-500 uppercase tracking-tight">Fator marcante/impactante:</span>
                            <p class="text-gray-800 font-medium italic">{{ $dados['fator_marcante'] ?? 'Não informado' }}</p>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <span class="block text-xs font-bold text-gray-500 uppercase tracking-tight">Relação com membros da família:</span>
                                <p class="text-gray-800 font-medium">{{ $dados['relacao_familiares'] ?? 'Não informado' }}</p>
                            </div>
                            <div>
                                <span class="block text-xs font-bold text-gray-500 uppercase tracking-tight">Atitude pais diante falta limites:</span>
                                <p class="text-gray-800 font-medium">{{ $dados['atitude_pais_limites'] ?? 'Não informado' }}</p>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <span class="block text-xs font-bold text-gray-500 uppercase tracking-tight">Reação da criança aos limites:</span>
                                <p class="text-gray-800 font-medium">{{ $dados['reacao_crianca_limites'] ?? 'Não informado' }}</p>
                            </div>
                            <div>
                                <span class="block text-xs font-bold text-gray-500 uppercase tracking-tight">Quem protege?</span>
                                <p class="text-gray-800 font-medium">{{ $dados['protege_crianca'] ?? 'Não informado' }}</p>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <span class="block text-xs font-bold text-gray-500 uppercase tracking-tight">Quem auxilia nos estudos?</span>
                                <p class="text-gray-800 font-medium">{{ $dados['auxilia_estudos'] ?? 'Não informado' }}</p>
                            </div>
                            <div>
                                <span class="block text-xs font-bold text-gray-500 uppercase tracking-tight">Responsabilidades em casa:</span>
                                <p class="text-gray-800 font-medium">{{ $dados['responsabilidades_casa'] ?? 'Não informado' }}</p>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <span class="block text-xs font-bold text-gray-500 uppercase tracking-tight">Relação com colegas:</span>
                                <p class="text-gray-800 font-medium">{{ $dados['relacao_colegas'] ?? 'Não informado' }}</p>
                            </div>
                            <div>
                                <span class="block text-xs font-bold text-gray-500 uppercase tracking-tight">O que mais gosta na criança:</span>
                                <p class="text-gray-800 font-medium">{{ $dados['gosta_na_crianca'] ?? 'Não informado' }}</p>
                            </div>
                        </div>
                        <div>
                            <span class="block text-xs font-bold text-gray-500 uppercase tracking-tight">O que desagrada/incomoda:</span>
                            <p class="text-gray-800 font-medium">{{ $dados['desagrada_na_crianca'] ?? 'Não informado' }}</p>
                        </div>
                    </div>
                </div>

                <div class="mt-8 border-t pt-6 flex gap-4">
                    <a href="{{ route('anamnese.index') }}" class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-4 rounded-lg transition duration-300 uppercase text-center">
                        Voltar para Lista
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>