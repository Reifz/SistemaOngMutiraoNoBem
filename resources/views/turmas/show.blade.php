<x-app-layout>
    <div class="max-w-8xl mx-auto sm:px-6 lg:px-8 py-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-t-8 border-multirao-roxo">
            <div class="p-8 text-gray-900">
                
                <div class="flex justify-between items-center mb-8 pb-4 border-b">
                    <div>
                        <h2 class="text-2xl font-bold text-multirao-roxo uppercase">{{ $turma->nome }}</h2>
                        <p class="text-gray-500 text-sm italic uppercase font-bold tracking-widest">Detalhes da Turma e Lista de Alunos</p>
                    </div>
                    <div class="flex gap-4">
                        <a href="{{ route('turmas.edit', $turma->id) }}" class="bg-multirao-amarelo text-multirao-roxo font-bold py-2 px-4 rounded shadow hover:bg-opacity-90 transition uppercase text-xs flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            Editar Turma
                        </a>
                        <a href="{{ route('turmas.index') }}" class="text-sm font-bold text-gray-400 hover:text-multirao-roxo transition flex items-center uppercase tracking-widest">
                            &larr; Voltar
                        </a>
                    </div>
                </div>

                @if(session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                        <p>{{ session('success') }}</p>
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                        <p>{{ session('error') }}</p>
                    </div>
                @endif

                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-12">
                    <div class="bg-gray-50 p-4 rounded-lg border">
                        <label class="block text-[10px] font-bold text-gray-400 uppercase mb-1">Turno</label>
                        <p class="text-lg font-bold text-multirao-roxo">{{ $turma->turno }}</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg border">
                        <label class="block text-[10px] font-bold text-gray-400 uppercase mb-1">Capacidade</label>
                        <p class="text-lg font-bold text-multirao-roxo">{{ $turma->criancas->count() }} / {{ $turma->capacidade }} Alunos</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg border">
                        <label class="block text-[10px] font-bold text-gray-400 uppercase mb-1">Faixa Etária</label>
                        <p class="text-lg font-bold text-multirao-roxo">{{ $turma->idade_minima ?? 0 }} a {{ $turma->idade_maxima ?? 'N/A' }} anos</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg border">
                        <label class="block text-[10px] font-bold text-gray-400 uppercase mb-1">Status</label>
                        <span class="inline-block px-3 py-1 rounded text-xs font-bold uppercase {{ $turma->ativa ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            {{ $turma->ativa ? 'Ativa' : 'Inativa' }}
                        </span>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Lista de Alunos Alocados -->
                    <div class="lg:col-span-2">
                        <h3 class="text-lg font-bold text-multirao-roxo mb-6 flex items-center uppercase border-b pb-2">
                            <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            Alunos Alocados ({{ $turma->criancas->count() }})
                        </h3>
                        
                        <div class="bg-white border rounded-lg overflow-hidden">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Criança</th>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Responsável</th>
                                        <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Ações</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse($turma->criancas as $crianca)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-bold text-gray-900">{{ $crianca->nome }}</div>
                                                <div class="text-xs text-gray-500">{{ $crianca->data_nascimento->format('d/m/Y') }} ({{ $crianca->data_nascimento->age }} anos)</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-600">{{ $crianca->responsavel->nome ?? 'N/A' }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                                <a href="{{ route('matricula.historico', $crianca->id) }}" class="text-multirao-roxo hover:text-multirao-amarelo font-bold uppercase text-[10px] border border-multirao-roxo px-2 py-1 rounded transition">
                                                    Ver Histórico
                                                </a>
                                                <form action="{{ route('turmas.remover-crianca', $turma->id) }}" method="POST" onsubmit="return confirm('Remover esta criança da turma?')" class="inline">
                                                    @csrf
                                                    <input type="hidden" name="crianca_id" value="{{ $crianca->id }}">
                                                    <button type="submit" class="text-red-600 hover:bg-red-600 hover:text-white font-bold uppercase text-[10px] border border-red-600 px-2 py-1 rounded transition">Remover</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="px-6 py-12 text-center text-gray-400 italic">
                                                Nenhum aluno alocado nesta turma ainda.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Sidebar de Alocação -->
                    <div>
                        <h3 class="text-lg font-bold text-multirao-roxo mb-6 flex items-center uppercase border-b pb-2">
                            Alocar Criança
                        </h3>
                        
                        <div class="bg-gray-50 p-6 rounded-lg border">
                            @if($turma->criancas->count() >= $turma->capacidade)
                                <div class="bg-amber-50 border-l-4 border-amber-400 p-4 mb-4">
                                    <p class="text-sm text-amber-700 font-bold">Turma Lotada!</p>
                                    <p class="text-xs text-amber-600">Remova um aluno ou aumente a capacidade para alocar novos.</p>
                                </div>
                            @elseif($criancasDisponiveis->isEmpty())
                                <p class="text-sm text-gray-500 italic">Não há crianças disponíveis (com Anamnese concluída) para alocação.</p>
                            @else
                                <form action="{{ route('turmas.alocar', $turma->id) }}" method="POST">
                                    @csrf
                                    <div class="mb-4">
                                        <label class="block text-xs font-bold text-multirao-roxo uppercase mb-2">Selecionar Criança</label>
                                        <select name="crianca_id" id="select-crianca" class="w-full border-gray-300 rounded-md shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo text-sm" required>
                                            <option value="">Selecione...</option>
                                            @foreach($criancasDisponiveis as $disponivel)
                                                <option value="{{ $disponivel->id }}">{{ $disponivel->nome }} ({{ $disponivel->data_nascimento->age }} anos)</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <button type="submit" class="w-full bg-multirao-roxo text-white font-bold py-3 rounded shadow hover:bg-opacity-90 transition uppercase text-xs">
                                        Confirmar Alocação
                                    </button>
                                </form>
                            @endif
                        </div>

                        @push('styles')
                        <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
                        <style>
                            .ts-control { border-radius: 0.375rem !important; border-color: #d1d5db !important; }
                            .ts-wrapper.focus .ts-control { border-color: #6366f1 !important; ring: 2px !important; ring-color: #6366f1 !important; }
                        </style>
                        @endpush

                        @push('scripts')
                        <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
                        <script>
                            new TomSelect("#select-crianca",{
                                create: false,
                                sortField: {
                                    field: "text",
                                    direction: "asc"
                                },
                                placeholder: "Pesquise pelo nome da criança...",
                            });
                        </script>
                        @endpush

                        <div class="mt-8 bg-blue-50 p-4 rounded-lg border border-blue-100">
                            <h4 class="text-xs font-bold text-blue-700 uppercase mb-2">Regras de Alocação</h4>
                            <ul class="text-[10px] text-blue-600 space-y-2 list-disc pl-4">
                                <li>Apenas crianças com <b>Anamnese Concluída</b> aparecem na lista.</li>
                                <li>Ao alocar, o status da criança muda automaticamente para <b>EM_TURMA</b>.</li>
                                <li>O sistema respeita a capacidade máxima definida para a turma.</li>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
