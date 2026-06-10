<x-app-layout>
    <div class="max-w-8xl mx-auto sm:px-7 lg:px-9">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <div class="mb-4">
                    <h2 class="font-semibold text-xl text-multirao-roxo leading-tight mb-4 border-b pb-2 uppercase">
                        Anamnese
                    </h2>
                    
                    <form action="{{ route('anamnese.index') }}" method="POST" class="flex flex-wrap items-end gap-3">
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
                            <label for="status" class="block text-xs font-bold text-multirao-roxo uppercase tracking-wider mb-1">Status Saúde</label>
                            <select name="status" id="status" class="w-full rounded-md border-gray-300 shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo text-sm">
                                <option value="APROVADA" {{ $status == 'APROVADA' ? 'selected' : '' }}>Aguardando Anamnese</option>
                                <option value="ANAMNESE_CONCLUIDA" {{ $status == 'ANAMNESE_CONCLUIDA' ? 'selected' : '' }}>Anamnese Concluída</option>
                                <option value="EM_TURMA" {{ $status == 'EM_TURMA' ? 'selected' : '' }}>Matriculada (Em Turma)</option>
                                <option value="EVADIDA" {{ $status == 'EVADIDA' ? 'selected' : '' }}>Evasão / Saída</option>
                                <option value="TODOS" {{ $status == 'TODOS' ? 'selected' : '' }}>Todos</option>
                            </select>
                        </div>
                        
                        <div class="block mt-1 w-full flex gap-2">
                            <button type="submit" class="flex-1 text-center bg-multirao-roxo hover:bg-opacity-90 text-white px-6 py-2 rounded-md text-sm font-bold shadow-sm transition duration-300">
                                Filtrar Anamnese
                            </button>
                            
                            <button type="submit" name="clear" value="1" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-md text-sm font-bold transition duration-300">
                                Limpar
                            </button>
                        </div>
                    </form>
                </div>

                @if(session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                        <p class="font-bold">Sucesso!</p>
                        <p>{{ session('success') }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="py-4">
        <div class="max-w-8xl mx-auto sm:px-7 lg:px-9">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold text-multirao-roxo mb-4 border-b pb-2">
                        Fila de Saúde e Desenvolvimento
                    </h3>

                    @if($anamneses->isEmpty())
                        <div class="bg-blue-50 border-l-4 border-blue-400 text-blue-700 p-4 shadow-sm" role="alert">
                            <p>Nenhuma criança aguardando anamnese no momento. (Apenas crianças com matrícula aprovada aparecem aqui).</p>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white border border-gray-200 rounded-lg overflow-hidden">
                                <thead>
                                    <tr class="bg-gray-50 text-gray-600 uppercase text-xs leading-normal">
                                        <th class="py-3 px-6 text-left whitespace-nowrap"><b>Criança</b></th>
                                        <th class="py-3 px-6 text-left"><b>Responsável</b></th>
                                        <th class="py-3 px-6 text-left"><b>Status</b></th>
                                        <th class="py-3 px-6 text-center"><b>Ações</b></th>
                                    </tr>
                                </thead>
                                <tbody class="text-gray-600 text-sm font-light">
                                    @foreach($anamneses as $crianca)
                                        <tr class="border-b border-gray-200 hover:bg-gray-50 transition duration-150">
                                            <td class="py-3 px-6 text-left whitespace-nowrap">
                                                <div class="font-bold text-gray-800">{{ $crianca->nome }}</div>
                                            </td>
                                            <td class="py-3 px-6 text-left">
                                                <div class="font-medium text-gray-800">{{ $crianca->responsavel->nome }}</div>
                                            </td>
                                            <td class="py-3 px-6 text-left">
                                                @if($crianca->status == 'APROVADA')
                                                    <span class="bg-yellow-100 text-yellow-800 py-1 px-3 rounded-full text-xs font-bold uppercase">Aguardando</span>
                                                @elseif($crianca->status == 'ANAMNESE_CONCLUIDA')
                                                    <span class="bg-green-100 text-green-800 py-1 px-3 rounded-full text-xs font-bold uppercase">Concluída</span>
                                                @elseif($crianca->status == 'EVADIDA')
                                                    <span class="bg-red-100 text-red-800 py-1 px-3 rounded-full text-xs font-bold uppercase">Evasão / Saída</span>
                                                @else
                                                    <span class="bg-gray-100 text-gray-800 py-1 px-3 rounded-full text-xs font-bold uppercase">{{ $crianca->status }}</span>
                                                @endif
                                            </td>
                                            <td class="py-3 px-6 text-center">
                                                <div class="flex gap-2 justify-center">
                                                    @if($crianca->status == 'APROVADA')
                                                        <a href="{{ route('anamnese.formulario', $crianca->id) }}" class="bg-multirao-roxo hover:bg-opacity-90 text-white font-bold py-1 px-3 rounded text-xs transition duration-300 shadow-sm">
                                                            Iniciar Anamnese
                                                        </a>
                                                    @else
                                                        <a href="{{ route('anamnese.show', $crianca->id) }}" class="bg-multirao-roxo hover:bg-opacity-90 text-white font-bold py-1 px-3 rounded text-xs transition duration-300 shadow-sm uppercase">
                                                            Visualizar
                                                        </a>
                                                        @if(!in_array($crianca->status, ['EM_TURMA', 'EVADIDA']))
                                                            <a href="{{ route('anamnese.edit', $crianca->id) }}" class="bg-amber-500 hover:bg-amber-600 text-white font-bold py-1 px-3 rounded text-xs transition duration-300 shadow-sm uppercase">
                                                                Editar
                                                            </a>
                                                        @endif
                                                        <a href="{{ route('anamnese.pdf', $crianca->id) }}" class="bg-multirao-amarelo text-multirao-roxo font-bold py-1 px-3 rounded text-xs transition duration-300 shadow-sm">
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
                            {{ $anamneses->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
