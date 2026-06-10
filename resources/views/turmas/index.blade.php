<x-app-layout>
    <div class="max-w-8xl mx-auto sm:px-6 lg:px-8 py-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-8 text-gray-900">
                
                <div class="flex justify-between items-center mb-8 pb-4 border-b">
                    <div>
                        <h2 class="text-xl font-bold text-multirao-roxo uppercase">Gestão de Turmas</h2>
                    </div>
                    <a href="{{ route('turmas.create') }}" class="bg-multirao-roxo text-white font-bold py-2 px-6 rounded-md shadow hover:bg-opacity-90 transition flex items-center uppercase text-sm">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                        Nova Turma
                    </a>
                </div>

                @if(session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                        <p class="font-bold">Sucesso!</p>
                        <p>{{ session('success') }}</p>
                    </div>
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse($turmas as $turma)
                        <div class="border rounded-lg p-6 bg-gray-50 hover:shadow-md transition relative border-l-8 {{ $turma->ativa ? 'border-green-500' : 'border-red-500' }}">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <h4 class="text-lg font-bold text-multirao-roxo uppercase leading-tight">{{ $turma->nome }}</h4>
                                    <span class="inline-block bg-multirao-amarelo text-multirao-roxo text-[10px] font-bold px-2 py-1 rounded mt-1 uppercase">
                                        {{ $turma->turno }}
                                    </span>
                                </div>
                                <div class="text-right">
                                    <span class="text-xs font-bold text-gray-400 uppercase block">Capacidade</span>
                                    <span class="text-xl font-black text-multirao-roxo">{{ $turma->capacidade }}</span>
                                </div>
                            </div>

                            <div class="space-y-2 mb-6 text-sm text-gray-600">
                                <p class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    Faixa Etária: <b>{{ $turma->idade_minima ?? 0 }} a {{ $turma->idade_maxima ?? 'N/A' }} anos</b>
                                </p>
                                <p class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                    Alunos Alocados: <b>{{ $turma->criancas_count }}</b>
                                </p>
                            </div>

                            <div class="flex gap-2 pt-4 border-t">
                                <a href="{{ route('turmas.show', $turma->id) }}" class="flex-1 bg-multirao-amarelo text-multirao-roxo text-center font-bold py-2 px-2 rounded hover:bg-opacity-90 transition uppercase text-[10px]">
                                    Detalhes
                                </a>
                                <a href="{{ route('turmas.edit', $turma->id) }}" class="flex-1 bg-multirao-roxo text-white text-center font-bold py-2 px-2 rounded hover:bg-opacity-90 transition uppercase text-[10px]">
                                    Editar
                                </a>
                                <form action="{{ route('turmas.destroy', $turma->id) }}" method="POST" class="flex-1" onsubmit="return confirm('Excluir esta turma permanentemente?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-full bg-red-50 text-red-600 font-bold py-2 px-2 rounded hover:bg-red-600 hover:text-white transition uppercase text-[10px] border border-red-100">
                                        Excluir
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full py-12 text-center bg-gray-50 rounded-lg border-2 border-dashed border-gray-300">
                            <p class="text-gray-500 italic">Nenhuma turma cadastrada. Clique em "Nova Turma" para começar.</p>
                        </div>
                    @endforelse
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
