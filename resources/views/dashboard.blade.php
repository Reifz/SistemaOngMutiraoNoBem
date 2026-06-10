<x-app-layout>

    <div class="max-w-8xl mx-auto sm:px-7 lg:px-9 pt-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <!-- Aniversariantes -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-l-8 border-multirao-amarelo">
                <div class="p-6">
                    <h3 class="text-sm font-bold text-multirao-roxo uppercase flex items-center mb-4">
                        <svg class="w-5 h-5 mr-2 text-multirao-amarelo" fill="currentColor" viewBox="0 0 20 20"><path d="M11 3a1 1 0 10-2 0v1a1 1 0 102 0V3zM15.657 5.757a1 1 0 00-1.414-1.414l-.707.707a1 1 0 001.414 1.414l.707-.707zM18 10a1 1 0 01-1 1h-1a1 1 0 110-2h1a1 1 0 011 1zM5.05 6.464A1 1 0 106.464 5.05l-.707-.707a1 1 0 00-1.414 1.414l.707.707zM5 10a1 1 0 01-1 1H3a1 1 0 110-2h1a1 1 0 011 1zM8 16v-1a1 1 0 112 0v1a1 1 0 11-2 0zM13 16v-1a1 1 0 112 0v1a1 1 0 11-2 0zM16 10a1 1 0 01-1 1h-1a1 1 0 110-2h1a1 1 0 011 1z"></path><path fill-rule="evenodd" d="M5 5a3 3 0 015-2.236A3 3 0 0114.83 6H16a2 2 0 110 4h-5V9a1 1 0 10-2 0v1H4a2 2 0 110-4h1.17C5.06 5.687 5 5.35 5 5zm3.354 8.854a.5.5 0 11-.708-.708L13 7.793V6.5a.5.5 0 011 0v1.5a.5.5 0 01-.146.354l-5.5 5.5z" clip-rule="evenodd"></path></svg>
                        Aniversariantes de Hoje
                    </h3>
                    @forelse($aniversariantes as $niver)
                        <div class="flex justify-between items-center p-2 hover:bg-gray-50 rounded border-b last:border-0">
                            <span class="text-sm font-bold text-gray-700">{{ $niver->nome }}</span>
                            <span class="text-[10px] bg-multirao-amarelo text-multirao-roxo font-black px-2 py-1 rounded-full uppercase">{{ $niver->data_nascimento->age }} Anos</span>
                        </div>
                    @empty
                        <p class="text-xs text-gray-400 italic">Nenhum aniversariante hoje.</p>
                    @endforelse
                </div>
            </div>

            <!-- Alertas de Triagem -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-l-8 border-red-500">
                <div class="p-6">
                    <h3 class="text-sm font-bold text-red-600 uppercase flex items-center mb-4">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Alertas de Triagem (> 7 dias)
                    </h3>
                    @forelse($alertasTriagem as $alerta)
                        <div class="flex justify-between items-center p-2 hover:bg-gray-50 rounded border-b last:border-0">
                            <div class="flex flex-col">
                                <span class="text-sm font-bold text-gray-700">{{ $alerta->nome }}</span>
                                <span class="text-[9px] text-red-400 font-bold uppercase">Parado há {{ $alerta->created_at->diffInDays() }} dias</span>
                            </div>
                            <a href="{{ route('triagem.show', $alerta->id) }}" class="text-[10px] bg-red-100 text-red-700 font-bold px-3 py-1 rounded hover:bg-red-600 hover:text-white transition uppercase">
                                Ir para Triagem
                            </a>
                        </div>
                    @empty
                        <p class="text-xs text-gray-400 italic">Nenhum alerta pendente.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-8xl mx-auto sm:px-7 lg:px-9">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <div class="mb-4">
                    <h2 class="font-semibold text-xl text-multirao-roxo leading-tight mb-4 border-b pb-2">
                        {{ __('Filtrar as inscrições recebidas') }}
                    </h2>
                    
                    <form action="{{ route('dashboard') }}" method="POST" class="flex flex-wrap items-end gap-3">
                        @csrf
                        <div class="flex-1 min-w-[200px]">
                            <label for="nome" class="block text-xs font-bold text-multirao-roxo uppercase tracking-wider mb-1">Criança</label>
                            <input type="text" name="nome" id="nome" value="{{ $nome }}" placeholder="Nome..." class="w-full rounded-md border-gray-300 shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo text-sm">
                        </div>
                        
                        <div class="w-full sm:w-40">
                            <label for="data_inicio" class="block text-xs font-bold text-multirao-roxo uppercase tracking-wider mb-1">Início</label>
                            <input type="date" name="data_inicio" id="data_inicio" value="{{ $data_inicio }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo text-sm">
                        </div>
                        
                        <div class="w-full sm:w-40">
                            <label for="data_fim" class="block text-xs font-bold text-multirao-roxo uppercase tracking-wider mb-1">Fim</label>
                            <input type="date" name="data_fim" id="data_fim" value="{{ $data_fim }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo text-sm">
                        </div>

                        <div class="w-full sm:w-44">
                            <label for="status" class="block text-xs font-bold text-multirao-roxo uppercase tracking-wider mb-1">Status</label>
                            <select name="status" id="status" class="w-full rounded-md border-gray-300 shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo text-sm">
                                <option value="TODOS" {{ $status == 'TODOS' ? 'selected' : '' }}>Todos</option>
                                <option value="PREENCHER" {{ $status == 'PREENCHER' ? 'selected' : '' }}>Triagem</option>
                                <option value="PENDENTE_MATRICULA" {{ $status == 'PENDENTE_MATRICULA' ? 'selected' : '' }}>Pendente de Matrícula</option>
                                <option value="PENDENTE_APROVACAO" {{ $status == 'PENDENTE_APROVACAO' ? 'selected' : '' }}>Pendente de Aprovação</option>
                                <option value="APROVADA" {{ $status == 'APROVADA' ? 'selected' : '' }}>Matriculada</option>
                                <option value="REJEITADA" {{ $status == 'REJEITADA' ? 'selected' : '' }}>Rejeitadas</option>
                            </select>
                        </div>

                        <div class="block mt-1 w-full flex gap-2">
                            <button type="submit" class="flex-1 text-center bg-multirao-roxo hover:bg-opacity-90 text-white px-6 py-2 rounded-md text-sm font-bold shadow-sm transition duration-300">
                                Filtrar
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
                        @if($status == 'PREENCHER') Fila de Triagem 
                        @elseif($status == 'PENDENTE_MATRICULA') Aguardando Matrícula 
                        @elseif($status == 'PENDENTE_APROVACAO') Revisão de Documentos 
                        @elseif($status == 'APROVADA') Matriculadas 
                        @elseif($status == 'REJEITADA') Inscrições Rejeitadas 
                        @else Todas as Inscrições @endif
                        @if($nome) <span class="text-sm font-normal text-gray-500"> - filtrando por: "{{ $nome }}"</span> @endif
                    </h3>

                    @if(session('success'))
                        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 shadow-sm" role="alert">
                            <p>{{ session('success') }}</p>
                        </div>
                    @endif

                    @if($triagem->isEmpty())
                        <div class="bg-blue-50 border-l-4 border-blue-400 text-blue-700 p-4 shadow-sm" role="alert">
                            <p>Nenhum registro encontrado com os filtros aplicados.</p>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white border border-gray-200 rounded-lg overflow-hidden">
                                <thead>
                                    <tr class="bg-gray-50 text-gray-600 uppercase text-xs leading-normal">
                                        <th class="py-3 px-6 text-left whitespace-nowrap"><b>Criança</b></th>
                                        <th class="py-3 px-6 text-center"><b>Idade</b></th>
                                        <th class="py-3 px-6 text-left"><b>Escola / Série</b></th>
                                        <th class="py-3 px-6 text-left"><b>Responsável</b></th>
                                        <th class="py-3 px-6 text-center"><b>Status</b></th>
                                        <th class="py-3 px-6 text-center"><b>Ações</b></th>
                                    </tr>
                                </thead>
                                <tbody class="text-gray-600 text-sm font-light">
                                    @foreach($triagem as $crianca)
                                        <tr class="border-b border-gray-200 hover:bg-gray-50 transition duration-150">
                                            <td class="py-3 px-6 text-left whitespace-nowrap">
                                                <div class="font-bold text-gray-800">{{ $crianca->nome }}</div>
                                                <div class="text-[12px] text-gray-400">Inscrito em: {{ $crianca->created_at->format('d/m/Y H:i') }}</div>
                                            </td>
                                            <td class="py-3 px-6 text-center">
                                                {{ $crianca->idade }} anos
                                            </td>
                                            <td class="py-3 px-6 text-left">
                                                <div class="text-xs">{{ $crianca->escola }}</div>
                                                <div class="font-semibold text-multirao-roxo">{{ $crianca->serie }} - {{ $crianca->periodo_escolar }}</div>
                                            </td>
                                            <td class="py-3 px-6 text-left">
                                                <div class="font-medium text-gray-800">{{ $crianca->responsavel->nome }}</div>
                                                <div class="text-[12px] text-gray-400">{{ $crianca->responsavel->telefone }}</div>
                                            </td>
                                            <td class="py-3 px-6 text-center">
                                                @if($crianca->status == 'PREENCHER')
                                                    <span class="bg-indigo-100 text-indigo-700 py-1 px-3 rounded-full text-[10px] font-bold uppercase tracking-wider">Triagem</span>
                                                @elseif($crianca->status == 'PENDENTE_MATRICULA')
                                                    <span class="bg-yellow-100 text-yellow-700 py-1 px-3 rounded-full text-[10px] font-bold uppercase tracking-wider">Pendente Matrícula</span>
                                                @elseif($crianca->status == 'PENDENTE_APROVACAO')
                                                    <span class="bg-blue-100 text-blue-700 py-1 px-3 rounded-full text-[10px] font-bold uppercase tracking-wider">Revisão Documentos</span>
                                                @elseif($crianca->status == 'APROVADA')
                                                    <span class="bg-green-100 text-green-700 py-1 px-3 rounded-full text-[10px] font-bold uppercase tracking-wider">Matriculada</span>
                                                @else
                                                    <span class="bg-red-100 text-red-700 py-1 px-3 rounded-full text-[10px] font-bold uppercase tracking-wider">Rejeitada</span>
                                                @endif
                                            </td>
                                            <td class="py-3 px-6 text-center">
                                                <div class="flex gap-2 justify-center">
                                                    <a href="{{ route('triagem.show', $crianca->id) }}" class="bg-multirao-roxo hover:bg-opacity-90 text-white font-bold py-1 px-3 rounded text-xs transition duration-300 shadow-sm">
                                                        Visualizar
                                                    </a>
                                                    @if($crianca->status == 'APROVADA')
                                                        <a href="{{ route('triagem.pdf', $crianca->id) }}" target="_blank" class="bg-multirao-amarelo text-multirao-roxo font-bold py-1 px-3 rounded text-xs transition duration-300 shadow-sm">
                                                            PDF
                                                        </a>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4">
                            {{ $triagem->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
