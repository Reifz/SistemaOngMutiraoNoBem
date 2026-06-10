<x-app-layout>
    <div class="max-w-8xl mx-auto sm:px-6 lg:px-8 py-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-t-8 border-multirao-roxo">
            <div class="p-8 text-gray-900">
                
                <div class="flex justify-between items-center mb-8 pb-4 border-b">
                    <div>
                        <h2 class="text-2xl font-bold text-multirao-roxo uppercase">Relatório de Evasão</h2>
                        <p class="text-gray-500 text-sm italic uppercase font-bold tracking-widest">Análise de retenção e motivos de desligamento</p>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="text-right">
                            <p class="text-xs font-bold text-gray-400 uppercase">Período Selecionado</p>
                            <p class="text-sm font-bold text-gray-600">{{ $dataInicio->format('d/m/Y') }} até {{ $dataFim->format('d/m/Y') }}</p>
                        </div>
                        <a href="{{ route('relatorios.evasao.pdf', request()->query()) }}" target="_blank" class="bg-multirao-amarelo text-multirao-roxo font-bold py-2 px-4 rounded shadow-sm hover:bg-opacity-90 transition uppercase text-xs flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm5 6a1 1 0 10-2 0v3.586l-1.293-1.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 11.586V8z" clip-rule="evenodd"></path></svg>
                            Exportar PDF
                        </a>
                    </div>
                </div>

                <!-- Filtros -->
                <div class="bg-gray-50 p-6 rounded-lg border mb-8">
                    <form action="{{ route('relatorios.evasao') }}" method="GET" class="grid grid-cols-1 md:grid-cols-5 gap-4 items-end">
                        <div>
                            <label class="block text-xs font-bold text-multirao-roxo uppercase mb-2">Data Início</label>
                            <input type="date" name="data_inicio" value="{{ $dataInicio->format('Y-m-d') }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo text-sm">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-multirao-roxo uppercase mb-2">Data Fim</label>
                            <input type="date" name="data_fim" value="{{ $dataFim->format('Y-m-d') }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo text-sm">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-multirao-roxo uppercase mb-2">Turma</label>
                            <select name="turma_id" class="w-full border-gray-300 rounded-md shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo text-sm">
                                <option value="">Todas as Turmas</option>
                                @foreach($turmas as $turma)
                                    <option value="{{ $turma->id }}" {{ $turmaId == $turma->id ? 'selected' : '' }}>
                                        {{ $turma->nome }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-multirao-roxo uppercase mb-2">Período</label>
                            <select name="periodo" class="w-full border-gray-300 rounded-md shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo text-sm">
                                <option value="">Todos</option>
                                <option value="Manhã" {{ $periodo == 'Manhã' ? 'selected' : '' }}>Manhã</option>
                                <option value="Tarde" {{ $periodo == 'Tarde' ? 'selected' : '' }}>Tarde</option>
                            </select>
                        </div>
                        <div class="flex gap-2">
                            <button type="submit" class="flex-1 bg-multirao-roxo text-white font-bold py-2 px-4 rounded shadow hover:bg-opacity-90 transition uppercase text-xs">
                                Filtrar
                            </button>
                            <a href="{{ route('relatorios.evasao') }}" class="bg-white text-gray-500 font-bold py-2 px-4 rounded shadow-sm border hover:bg-gray-50 transition uppercase text-xs flex items-center justify-center">
                                Limpar
                            </a>
                        </div>
                    </form>
                </div>

                <!-- Estatísticas (Cards) -->
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 mb-12">
                    <div class="bg-white p-4 rounded-xl border shadow-sm">
                        <p class="text-[10px] font-bold text-gray-400 uppercase mb-1 tracking-tighter">Total Matriculados</p>
                        <p class="text-2xl font-black text-multirao-roxo">{{ $totalMatriculados }}</p>
                    </div>
                    <div class="bg-white p-4 rounded-xl border shadow-sm border-l-4 border-l-multirao-roxo">
                        <p class="text-[10px] font-bold text-gray-400 uppercase mb-1 tracking-tighter">Total Evasões</p>
                        <p class="text-2xl font-black text-gray-800">{{ $totalEvadidos }}</p>
                    </div>
                    <div class="bg-indigo-50 p-4 rounded-xl border border-indigo-100 shadow-sm">
                        <p class="text-[10px] font-bold text-multirao-roxo uppercase mb-1 tracking-tighter">Evasão Manhã</p>
                        <p class="text-2xl font-black text-multirao-roxo">{{ $totalEvadidosManha }}</p>
                        <p class="text-[9px] text-multirao-roxo/60 font-bold truncate mt-1" title="Principal motivo: {{ $motivoPrincipalManha->motivo_evasao ?? 'N/A' }}">
                            M: {{ $motivoPrincipalManha->motivo_evasao ?? '---' }}
                        </p>
                    </div>
                    <div class="bg-indigo-50 p-4 rounded-xl border border-indigo-100 shadow-sm">
                        <p class="text-[10px] font-bold text-multirao-roxo uppercase mb-1 tracking-tighter">Evasão Tarde</p>
                        <p class="text-2xl font-black text-multirao-roxo">{{ $totalEvadidosTarde }}</p>
                        <p class="text-[9px] text-multirao-roxo/60 font-bold truncate mt-1" title="Principal motivo: {{ $motivoPrincipalTarde->motivo_evasao ?? 'N/A' }}">
                            M: {{ $motivoPrincipalTarde->motivo_evasao ?? '---' }}
                        </p>
                    </div>
                    <div class="bg-multirao-roxo p-4 rounded-xl border-2 border-multirao-roxo shadow-sm">
                        <p class="text-[10px] font-bold text-multirao-amarelo uppercase mb-1 tracking-tighter">Taxa de Evasão</p>
                        <p class="text-2xl font-black text-white">{{ number_format($taxaEvasao, 1) }}%</p>
                    </div>
                    <div class="bg-multirao-amarelo p-4 rounded-xl border-2 border-multirao-amarelo shadow-sm">
                        <p class="text-[10px] font-bold text-multirao-roxo uppercase mb-1 tracking-tighter">Principal Motivo</p>
                        <p class="text-xs font-bold text-multirao-roxo truncate" title="{{ $motivoPrincipal->motivo_evasao ?? 'N/A' }}">
                            {{ $motivoPrincipal->motivo_evasao ?? 'N/A' }}
                        </p>
                    </div>
                </div>

                <!-- Tabela de Detalhes -->
                <div class="bg-white border rounded-lg overflow-hidden">
                    <div class="bg-gray-50 px-6 py-4 border-b">
                        <h3 class="text-sm font-bold text-gray-700 uppercase">Listagem Detalhada de Evasões</h3>
                    </div>
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Criança</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Data Saída</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Permanência</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Motivo</th>
                                <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Ações</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($evadidos as $crianca)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-bold text-gray-900">{{ $crianca->nome }}</div>
                                        <div class="text-xs text-gray-500">Responsável: {{ $crianca->responsavel->nome ?? 'N/A' }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        {{ $crianca->data_evasao ? $crianca->data_evasao->format('d/m/Y') : '---' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-500">
                                        @if($crianca->data_matricula && $crianca->data_evasao)
                                            {{ $crianca->data_matricula->diffInMonths($crianca->data_evasao) }} meses
                                        @else
                                            <span class="italic">N/A</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 inline-flex text-[10px] leading-5 font-bold rounded-full bg-multirao-amarelo text-multirao-roxo uppercase tracking-wider">
                                            {{ $crianca->motivo_evasao }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="{{ route('matricula.historico', $crianca->id) }}" class="text-multirao-roxo hover:text-multirao-amarelo font-bold uppercase text-[10px] border border-multirao-roxo px-2 py-1 rounded">
                                            Ver Histórico
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center text-gray-400 italic">
                                        Nenhuma evasão registrada para o período e filtros selecionados.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-8 p-4 bg-gray-50 border rounded-lg text-xs text-gray-600 leading-relaxed">
                    <p class="font-bold mb-1 uppercase text-multirao-roxo">Como é calculada a Taxa de Evasão?</p>
                    <p>A taxa é o percentual de saídas em relação ao total de alunos que frequentaram a ONG no período. Fórmula: (Total Evadidos / Total Matriculados) * 100.</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
