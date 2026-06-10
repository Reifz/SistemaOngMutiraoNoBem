<x-app-layout>
    <div class="max-w-8xl mx-auto sm:px-7 lg:px-9">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-8 text-gray-900">
                
                <div class="flex justify-between items-center mb-8 pb-4 border-b">
                    <div>
                        <h2 class="text-xl font-bold text-multirao-roxo uppercase">Pesquisar Crianças</h2>
                        <p class="text-gray-500 text-sm italic uppercase font-bold tracking-widest"></p>
                    </div>
                </div>

                <!-- Filtros -->
                <div class="bg-indigo-50 p-6 rounded-lg border-2 border-indigo-100 mb-8">
                    <form action="{{ route('pesquisa.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-6 items-end">
                        <div>
                            <label class="block text-xs font-bold text-multirao-roxo uppercase mb-2">Filtrar por Nome</label>
                            <input type="text" name="nome" value="{{ $nome }}" placeholder="Ex: João Silva..." class="w-full border-gray-300 rounded-md shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo text-sm">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-multirao-roxo uppercase mb-2">Filtrar por Turma</label>
                            <select name="turma_id" class="w-full border-gray-300 rounded-md shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo text-sm">
                                <option value="">Todas as Turmas</option>
                                @foreach($turmas as $turma)
                                    <option value="{{ $turma->id }}" {{ $turma_id == $turma->id ? 'selected' : '' }}>
                                        {{ $turma->nome }} ({{ $turma->turno }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex gap-2">
                            <button type="submit" class="flex-1 bg-multirao-roxo text-white font-bold py-2 px-4 rounded shadow hover:bg-opacity-90 transition uppercase text-xs flex items-center justify-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                Buscar
                            </button>
                            <button type="submit" formaction="{{ route('pesquisa.pdf') }}" class="flex-1 bg-multirao-amarelo text-multirao-roxo font-bold py-2 px-4 rounded shadow hover:bg-opacity-90 transition uppercase text-xs flex items-center justify-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                Exportar PDF
                            </button>
                            <a href="{{ route('pesquisa.index') }}" class="bg-white text-gray-500 font-bold py-2 px-4 rounded shadow-sm border hover:bg-gray-50 transition uppercase text-xs flex items-center justify-center">
                                Limpar
                            </a>
                        </div>
                    </form>
                </div>

                <!-- Resultados -->
                <div class="bg-white border rounded-lg overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Criança</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Turma</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Responsável</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Contato</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Ações</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($criancas as $crianca)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-bold text-gray-900">{{ $crianca->nome }}</div>
                                        <div class="text-xs text-gray-500">{{ $crianca->data_nascimento ? $crianca->data_nascimento->format('d/m/Y') : '---' }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($crianca->turma)
                                            <span class="text-sm font-bold text-multirao-roxo">{{ $crianca->turma->nome }}</span>
                                            <div class="text-[10px] text-gray-400 uppercase tracking-tighter">{{ $crianca->turma->turno }}</div>
                                        @else
                                            <span class="text-xs text-gray-400 italic">Sem Turma</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-bold text-gray-800">{{ $crianca->responsavel->nome ?? 'N/A' }}</div>
                                        <div class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">{{ $crianca->responsavel->email ?? '---' }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($crianca->responsavel && $crianca->responsavel->telefone)
                                            @php
                                                $tel = preg_replace('/[^0-9]/', '', $crianca->responsavel->telefone);
                                            @endphp
                                            <a href="https://wa.me/55{{ $tel }}" target="_blank" class="text-green-600 hover:text-green-700 flex items-center gap-1 font-bold text-xs uppercase transition-all hover:scale-105">
                                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.588-5.946 0-6.556 5.332-11.888 11.888-11.888 3.176 0 6.161 1.237 8.404 3.48s3.481 5.228 3.481 8.404c0 6.556-5.332 11.889-11.887 11.889-2.012 0-3.991-.511-5.741-1.482l-6.244 1.706zm6.357-3.665l.455.27c1.442.858 3.1 1.312 4.805 1.312 5.093 0 9.237-4.144 9.237-9.237s-4.144-9.237-9.237-9.237-9.237 4.144-9.237 9.237c0 1.83.541 3.618 1.564 5.16l.297.456-1.002 3.662 3.753-.996zM17.472 14.382c-.301-.15-1.782-.879-2.057-.979-.275-.1-.475-.15-.675.15-.199.299-.775.979-.95 1.178-.175.199-.35.224-.65.075-.3-.15-1.268-.467-2.414-1.49-.893-.795-1.496-1.776-1.671-2.075-.175-.3-.019-.462.13-.611.135-.134.3-.349.45-.524.15-.175.199-.299.299-.499.1-.199.05-.374-.025-.524-.075-.15-.675-1.623-.925-2.221-.244-.582-.493-.503-.675-.512-.174-.008-.375-.01-.575-.01-.2 0-.524.075-.799.374-.275.299-1.049 1.023-1.049 2.495 0 1.472 1.073 2.894 1.223 3.094.15.2 2.112 3.224 5.116 4.522.715.309 1.274.494 1.709.633.717.227 1.369.196 1.885.119.574-.085 1.782-.728 2.032-1.429.25-.701.25-1.3.175-1.429-.075-.13-.275-.205-.575-.355z"/></svg>
                                                {{ $crianca->responsavel->telefone }}
                                            </a>
                                        @else
                                            <span class="text-[10px] text-gray-400 italic font-bold uppercase">N/I</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $statusClasses = [
                                                'PREENCHER' => 'bg-gray-100 text-gray-800',
                                                'PENDENTE_MATRICULA' => 'bg-orange-100 text-orange-800',
                                                'PENDENTE_APROVACAO' => 'bg-blue-100 text-blue-800',
                                                'APROVADA' => 'bg-green-100 text-green-800',
                                                'EM_TURMA' => 'bg-purple-100 text-purple-800',
                                                'REJEITADO' => 'bg-red-100 text-red-800',
                                            ];
                                            $class = $statusClasses[$crianca->status] ?? 'bg-gray-100 text-gray-800';
                                        @endphp
                                        <span class="px-3 py-1 inline-flex text-[10px] leading-5 font-bold rounded-full {{ $class }} uppercase tracking-wider">
                                            {{ str_replace('_', ' ', $crianca->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                        <a href="{{ route('matricula.historico', $crianca->id) }}" class="text-multirao-roxo hover:text-multirao-amarelo font-bold uppercase text-[10px] border border-multirao-roxo px-2 py-1 rounded transition">
                                            Ver Histórico
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center text-gray-400 italic">
                                        Nenhuma criança encontrada com os filtros informados.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-6">
                    {{ $criancas->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
