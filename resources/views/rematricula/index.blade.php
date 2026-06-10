<x-app-layout>
    <div class="max-w-8xl mx-auto sm:px-7 lg:px-9">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <div class="mb-4">
                    <div class="flex justify-between items-center mb-4 border-b pb-2">
                        <h2 class="font-semibold text-xl text-multirao-roxo leading-tight uppercase">
                            Arquitetura de Rematrícula (Histórico Anual)
                        </h2>
                        <div class="flex gap-2">
                            <a href="{{ route('rematricula.anos.index') }}" class="inline-flex items-center px-4 py-2 bg-multirao-amarelo border border-transparent rounded-md font-bold text-xs text-multirao-roxo uppercase tracking-widest hover:bg-opacity-90 transition shadow-sm">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                Gerenciar Períodos
                            </a>
                            <span class="inline-flex items-center px-4 py-2 bg-multirao-roxo border border-transparent rounded-md font-bold text-xs text-white uppercase tracking-widest">
                                Ano Ativo: {{ $anoAtual->ano ?? 'Nenhum' }}
                            </span>
                        </div>
                    </div>
                    
                    <form action="{{ route('rematricula.index') }}" method="POST" class="flex flex-wrap items-end gap-3">
                        @csrf
                        <div class="flex-1 min-w-[200px]">
                            <label for="nome" class="block text-xs font-bold text-multirao-roxo uppercase tracking-wider mb-1">Criança</label>
                            <input type="text" name="nome" id="nome" value="{{ $nome }}" placeholder="Buscar por nome..." class="w-full rounded-md border-gray-300 shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo text-sm">
                        </div>

                        <div class="flex-1 min-w-[200px]">
                            <label for="status" class="block text-xs font-bold text-multirao-roxo uppercase tracking-wider mb-1">Status no Ano ({{ $anoAtual->ano ?? '' }})</label>
                            <select name="status" id="status" class="w-full rounded-md border-gray-300 shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo text-sm">
                                <option value="TODOS" {{ $status == 'TODOS' ? 'selected' : '' }}>Todos os Status</option>
                                <option value="PENDENTE_REMATRICULA_MATRICULA" {{ $status == 'PENDENTE_REMATRICULA_MATRICULA' ? 'selected' : '' }}>Pendente Matrícula</option>
                                <option value="PENDENTE_REMATRICULA_ANAMNESE" {{ $status == 'PENDENTE_REMATRICULA_ANAMNESE' ? 'selected' : '' }}>Pendente Anamnese</option>
                                <option value="REMATRICULADA" {{ $status == 'REMATRICULADA' ? 'selected' : '' }}>Rematriculada (Pronta)</option>
                                <option value="EM_TURMA" {{ $status == 'EM_TURMA' ? 'selected' : '' }}>Em Turma</option>
                                <option value="EVADIDA" {{ $status == 'EVADIDA' ? 'selected' : '' }}>Evasão</option>
                            </select>
                        </div>

                        <div class="block mt-1 w-full flex gap-2">
                            <button type="submit" class="flex-1 text-center bg-multirao-roxo hover:bg-opacity-90 text-white px-6 py-2 rounded-md text-sm font-bold shadow-sm transition duration-300">
                                Filtrar Histórico
                            </button>
                            
                            <button type="submit" name="clear" value="1" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-md text-sm font-bold transition duration-300">
                                Limpar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="py-4">
        <div class="max-w-8xl mx-auto sm:px-7 lg:px-9">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold text-multirao-roxo mb-4 border-b pb-2">
                        Listagem de Crianças e Ciclos Anuais
                    </h3>

                    @if(session('success'))
                        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 shadow-sm" role="alert">
                            <p>{{ session('success') }}</p>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 shadow-sm" role="alert">
                            <p>{{ session('error') }}</p>
                        </div>
                    @endif

                    @if($criancas->isEmpty())
                        <div class="bg-blue-50 border-l-4 border-blue-400 text-blue-700 p-4 shadow-sm" role="alert">
                            <p>Nenhuma criança encontrada para os filtros aplicados.</p>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white border border-gray-200 rounded-lg overflow-hidden">
                                <thead>
                                    <tr class="bg-gray-50 text-gray-600 uppercase text-xs leading-normal">
                                        <th class="py-3 px-6 text-left whitespace-nowrap"><b>Criança</b></th>
                                        <th class="py-3 px-6 text-center"><b>Status Atual ({{ $anoAtual->ano ?? '-' }})</b></th>
                                        <th class="py-3 px-6 text-center"><b>Turma ({{ $anoAtual->ano ?? '-' }})</b></th>
                                        <th class="py-3 px-6 text-center"><b>Ações de Rematrícula</b></th>
                                    </tr>
                                </thead>
                                <tbody class="text-gray-600 text-sm font-light">
                                    @foreach($criancas as $crianca)
                                        @php $matricula = $crianca->matriculas->first(); @endphp
                                        <tr class="border-b border-gray-200 hover:bg-gray-50 transition duration-150">
                                            <td class="py-3 px-6 text-left whitespace-nowrap">
                                                <div class="font-bold text-gray-800">{{ $crianca->nome }}</div>
                                                <div class="text-[12px] text-gray-400">Responsável: {{ $crianca->responsavel->nome }}</div>
                                            </td>
                                            <td class="py-3 px-6 text-center">
                                                @if($matricula)
                                                    @if($matricula->status == 'PENDENTE_REMATRICULA_MATRICULA')
                                                        <span class="bg-yellow-100 text-yellow-700 py-1 px-3 rounded-full text-[10px] font-bold uppercase tracking-wider">Pendente Matrícula</span>
                                                    @elseif($matricula->status == 'PENDENTE_REMATRICULA_ANAMNESE')
                                                        <span class="bg-blue-100 text-blue-700 py-1 px-3 rounded-full text-[10px] font-bold uppercase tracking-wider">Pendente Anamnese</span>
                                                    @elseif($matricula->status == 'REMATRICULADA' || $matricula->status == 'APROVADA')
                                                        <span class="bg-green-100 text-green-700 py-1 px-3 rounded-full text-[10px] font-bold uppercase tracking-wider">Apta / Rematriculada</span>
                                                    @elseif($matricula->status == 'EM_TURMA')
                                                        <span class="bg-purple-100 text-purple-700 py-1 px-3 rounded-full text-[10px] font-bold uppercase tracking-wider">Em Turma</span>
                                                    @elseif($matricula->status == 'EVADIDA')
                                                        <span class="bg-red-100 text-red-700 py-1 px-3 rounded-full text-[10px] font-bold uppercase tracking-wider">Evasão</span>
                                                    @else
                                                        <span class="bg-gray-100 text-gray-700 py-1 px-3 rounded-full text-[10px] font-bold uppercase tracking-wider">{{ $matricula->status }}</span>
                                                    @endif
                                                @else
                                                    <span class="bg-gray-100 text-gray-400 py-1 px-3 rounded-full text-[10px] font-bold uppercase tracking-wider italic">Sem Matrícula</span>
                                                @endif
                                            </td>
                                            <td class="py-3 px-6 text-center">
                                                @if($matricula && $matricula->turma)
                                                    <div class="font-bold text-multirao-roxo">{{ $matricula->turma->nome }}</div>
                                                @else
                                                    <div class="text-gray-400 italic text-xs">Não alocada</div>
                                                @endif
                                            </td>
                                            <td class="py-3 px-6 text-center">
                                                <div class="flex gap-2 justify-center">
                                                    @if(!$matricula)
                                                        <form action="{{ route('rematricula.iniciar', $crianca->id) }}" method="POST">
                                                            @csrf
                                                            <input type="hidden" name="ano_letivo_id" value="{{ $anoAtual->id }}">
                                                            <button type="submit" class="bg-multirao-roxo hover:bg-opacity-90 text-white font-bold py-1 px-4 rounded text-[10px] transition duration-300 shadow-sm uppercase">
                                                                Iniciar Matrícula {{ $anoAtual->ano }}
                                                            </button>
                                                        </form>
                                                    @else
                                                        <a href="{{ route('matricula.show', $crianca->id) }}" class="text-multirao-roxo hover:bg-multirao-amarelo font-bold py-1 px-3 rounded text-[10px] border border-multirao-roxo transition duration-300 shadow-sm uppercase">
                                                            Ver Prontuário Anual
                                                        </a>
                                                        
                                                        {{-- Botão para futuro ano --}}
                                                        @php $proximoAno = $anosLetivos->where('ano', '>', $anoAtual->ano)->first(); @endphp
                                                        @if($proximoAno)
                                                            <form action="{{ route('rematricula.iniciar', $crianca->id) }}" method="POST">
                                                                @csrf
                                                                <input type="hidden" name="ano_letivo_id" value="{{ $proximoAno->id }}">
                                                                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-1 px-3 rounded text-[10px] transition duration-300 shadow-sm uppercase">
                                                                    Preparar {{ $proximoAno->ano }}
                                                                </button>
                                                            </form>
                                                        @endif
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4">
                            {{ $criancas->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
