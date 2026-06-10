<x-app-layout>
    <div class="max-w-8xl mx-auto sm:px-7 lg:px-9">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <div class="mb-4">
                    <div class="flex justify-between items-center mb-4 border-b pb-2">
                        <h2 class="font-semibold text-xl text-multirao-roxo leading-tight uppercase">
                            Gestão de Matrículas
                        </h2>
                        <a href="{{ route('matricula.download_ficha_mae') }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-bold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            
                            Baixar Ficha Mãe (Excel)
                        </a>
                    </div>
                    
                    <form action="{{ route('matricula.index') }}" method="POST" class="flex flex-wrap items-end gap-3">
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
                            <label for="status" class="block text-xs font-bold text-multirao-roxo uppercase tracking-wider mb-1">Fase da Matrícula</label>
                            <select name="status" id="status" class="w-full rounded-md border-gray-300 shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo text-sm">
                                <option value="TODOS" {{ $status == 'TODOS' ? 'selected' : '' }}>Todas</option>
                                <option value="PENDENTE_MATRICULA" {{ $status == 'PENDENTE_MATRICULA' ? 'selected' : '' }}>Aguardando Preenchimento</option>
                                <option value="PENDENTE_APROVACAO" {{ $status == 'PENDENTE_APROVACAO' ? 'selected' : '' }}>Aguardando Aprovação</option>
                                <option value="APROVADA" {{ $status == 'APROVADA' ? 'selected' : '' }}>Matrícula Aprovada</option>
                            </select>
                        </div>

                        <div class="block mt-1 w-full flex gap-2">
                            <button type="submit" class="flex-1 text-center bg-multirao-roxo hover:bg-opacity-90 text-white px-6 py-2 rounded-md text-sm font-bold shadow-sm transition duration-300">
                                Filtrar Matrículas
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
                        @if($status == 'PENDENTE_MATRICULA') Aguardando Preenchimento Interno
                        @elseif($status == 'PENDENTE_APROVACAO') Revisão de Dados e Documentos
                        @elseif($status == 'APROVADA') Matrículas Finalizadas
                        @else Gestão Geral de Matrícula @endif
                    </h3>

                    @if(session('success'))
                        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 shadow-sm" role="alert">
                            <p>{{ session('success') }}</p>
                        </div>
                    @endif

                    @if($matriculas->isEmpty())
                        <div class="bg-blue-50 border-l-4 border-blue-400 text-blue-700 p-4 shadow-sm" role="alert">
                            <p>Nenhum registro encontrado nesta fase.</p>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white border border-gray-200 rounded-lg overflow-hidden">
                                <thead>
                                    <tr class="bg-gray-50 text-gray-600 uppercase text-xs leading-normal">
                                        <th class="py-3 px-6 text-left whitespace-nowrap"><b>Criança</b></th>
                                        <th class="py-3 px-6 text-left"><b>Responsável</b></th>
                                        <th class="py-3 px-6 text-center"><b>Status</b></th>
                                        <th class="py-3 px-6 text-center"><b>Ações</b></th>
                                    </tr>
                                </thead>
                                <tbody class="text-gray-600 text-sm font-light">
                                    @foreach($matriculas as $crianca)
                                        <tr class="border-b border-gray-200 hover:bg-gray-50 transition duration-150">
                                            <td class="py-3 px-6 text-left whitespace-nowrap">
                                                <div class="font-bold text-gray-800">{{ $crianca->nome }}</div>
                                                <div class="text-[12px] text-gray-400">Última atualização: {{ $crianca->updated_at->format('d/m/Y H:i') }}</div>
                                            </td>
                                            <td class="py-3 px-6 text-left">
                                                <div class="font-medium text-gray-800">{{ $crianca->responsavel->nome }}</div>
                                                <div class="text-[12px] text-gray-400">{{ $crianca->responsavel->telefone }}</div>
                                            </td>
                                            <td class="py-3 px-6 text-center">
                                                @if($crianca->status == 'PENDENTE_MATRICULA')
                                                    <span class="bg-yellow-100 text-yellow-700 py-1 px-3 rounded-full text-[10px] font-bold uppercase tracking-wider">Aguardando Preenchimento</span>
                                                @elseif($crianca->status == 'PENDENTE_APROVACAO')
                                                    <span class="bg-blue-100 text-blue-700 py-1 px-3 rounded-full text-[10px] font-bold uppercase tracking-wider">Aguardando Aprovação</span>
                                                @elseif($crianca->status == 'APROVADA')
                                                    <span class="bg-green-100 text-green-700 py-1 px-3 rounded-full text-[10px] font-bold uppercase tracking-wider">Aprovada</span>
                                                @elseif($crianca->status == 'EM_TURMA')
                                                    <span class="bg-purple-100 text-purple-700 py-1 px-3 rounded-full text-[10px] font-bold uppercase tracking-wider">Matriculada / Em Turma</span>
                                                @elseif($crianca->status == 'EVADIDA')
                                                    <span class="bg-red-100 text-red-700 py-1 px-3 rounded-full text-[10px] font-bold uppercase tracking-wider">Evasão / Saída</span>
                                                @endif
                                            </td>
                                            <td class="py-3 px-6 text-center">
                                                <div class="flex gap-2 justify-center">
                                                    <a href="{{ route('triagem.onlyRead', $crianca->id) }}" class="text-multirao-roxo hover:bg-multirao-amarelo font-bold py-1 px-3 rounded text-[10px] border border-multirao-roxo transition duration-300 shadow-sm uppercase">
                                                            Pré inscrição
                                                    </a>
                                                    @if($crianca->status == 'PENDENTE_MATRICULA')
                                                        <a href="{{ route('matricula.formulario', $crianca->id) }}" class="bg-multirao-roxo hover:bg-opacity-90 text-white font-bold py-1 px-3 rounded text-xs transition duration-300 shadow-sm uppercase">
                                                            Preencher Dados
                                                        </a>
                                                    @else
                                                        <a href="{{ route('matricula.show', $crianca->id) }}" class="bg-multirao-roxo hover:bg-opacity-90 text-white font-bold py-1 px-3 rounded text-xs transition duration-300 shadow-sm uppercase">
                                                            @if(in_array($crianca->status, ['PENDENTE_APROVACAO']))
                                                                Visualizar / Editar
                                                            @else
                                                                Visualizar
                                                            @endif
                                                        </a>
                                                        <a href="{{ route('matricula.pdf', $crianca->id) }}" target="_blank" class="bg-multirao-amarelo text-multirao-roxo font-bold py-1 px-3 rounded text-xs transition duration-300 shadow-sm uppercase">
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
                            {{ $matriculas->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
