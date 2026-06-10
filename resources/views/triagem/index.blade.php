<x-app-layout>
    <div class="max-w-8xl mx-auto sm:px-7 lg:px-9">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <div class="mb-4">
                    <h2 class="font-semibold text-xl text-multirao-roxo leading-tight mb-4 border-b pb-2 uppercase">
                        Triagem (Pré-Inscrições Recebidas)
                    </h2>
                    
                    <form action="{{ route('triagem.index') }}" method="POST" class="flex flex-wrap items-end gap-3">
                        @csrf
                        <div class="flex-1 min-w-[140px]">
                            <label for="nome" class="block text-xs font-bold text-multirao-roxo uppercase tracking-wider mb-1">Criança</label>
                            <input type="text" name="nome" id="nome" value="{{ $nome }}" placeholder="Nome..." class="w-full rounded-md border-gray-300 shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo text-sm">
                        </div>
                        
                        <div class="flex-1 min-w-[140px]">
                            <label for="data_inicio" class="block text-xs font-bold text-multirao-roxo uppercase tracking-wider mb-1">Início</label>
                            <input type="date" name="data_inicio" id="data_inicio" value="{{ $data_inicio }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo text-sm">
                        </div>
                        
                        <div class="flex-1 min-w-[140px]">
                            <label for="data_fim" class="block text-xs font-bold text-multirao-roxo uppercase tracking-wider mb-1">Fim</label>
                            <input type="date" name="data_fim" id="data_fim" value="{{ $data_fim }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo text-sm">
                        </div>

                        <div class="flex-1 min-w-[160px]">
                            <label for="status" class="block text-xs font-bold text-multirao-roxo uppercase tracking-wider mb-1">Status</label>
                            <select name="status" id="status" class="w-full rounded-md border-gray-300 shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo text-sm">
                                <option value="PREENCHER" {{ $status == 'PREENCHER' ? 'selected' : '' }}>Triagem (Pendente)</option>
                                <option value="PENDENTE_MATRICULA" {{ $status == 'PENDENTE_MATRICULA' ? 'selected' : '' }}>Aprovadas</option>
                                <option value="REJEITADO" {{ $status == 'REJEITADO' ? 'selected' : '' }}>Rejeitadas</option>
                                <option value="TODOS" {{ $status == 'TODOS' ? 'selected' : '' }}>Todos</option>
                            </select>
                        </div>

                        <div class="block mt-1 w-full flex gap-2">
                            <button type="submit" class="flex-1 text-center bg-multirao-roxo hover:bg-opacity-90 text-white px-6 py-2 rounded-md text-sm font-bold shadow-sm transition duration-300">
                                Filtrar Triagem
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
                        Fila de Triagem Inicial
                    </h3>

                    @if(session('success'))
                        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 shadow-sm" role="alert">
                            <p>{{ session('success') }}</p>
                        </div>
                    @endif

                    @if($triagem->isEmpty())
                        <div class="bg-blue-50 border-l-4 border-blue-400 text-blue-700 p-4 shadow-sm" role="alert">
                            <p>Nenhuma pré-inscrição aguardando triagem no momento.</p>
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
                                        <th class="py-3 px-6 text-center"><b>Ações</b></th>
                                    </tr>
                                </thead>
                                <tbody class="text-gray-600 text-sm font-light">
                                    @foreach($triagem as $crianca)
                                        <tr class="border-b border-gray-200 hover:bg-gray-50 transition duration-150">
                                            <td class="py-3 px-6 text-left whitespace-nowrap">
                                                <div class="font-bold text-gray-800">{{ $crianca->nome }}</div>
                                                <div class="text-[12px] text-gray-400">Recebido em: {{ $crianca->created_at->format('d/m/Y H:i') }}</div>
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
                                                <div class="flex gap-2 justify-center">

                                                    @if($crianca->status !== 'REJEITADO' && $crianca->status !== 'PENDENTE_MATRICULA')
                                                    <a href="{{ route('triagem.show', $crianca->id) }}" class="bg-multirao-roxo hover:bg-opacity-90 text-white font-bold py-1 px-3 rounded text-xs transition duration-300 shadow-sm">
                                                        Realizar Triagems
                                                    </a>
                                                    @endif

                                                    @if($crianca->status == 'REJEITADO' && $crianca->status == 'PENDENTE_MATRICULA')
                                                    <a href="{{ route('triagem.onlyRead', $crianca->id) }}" class="bg-multirao-roxo hover:bg-opacity-90 text-white font-bold py-1 px-3 rounded text-xs transition duration-300 shadow-sm">
                                                        Visualizar Triagem
                                                    </a>
                                                    @endif

                                                    @if($crianca->status == 'REJEITADO')
                                                        <span class="bg-red-600 text-white font-bold py-1 px-3 rounded text-xs uppercase">Rejeitado</span>
                                                    @endif
                                                    @if($crianca->status == 'PENDENTE_MATRICULA')
                                                       <span class="bg-green-600 text-white font-bold py-1 px-3 rounded text-xs uppercase">Aprovado</span>
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
