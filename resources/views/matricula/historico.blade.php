<x-app-layout>
    <div class="max-w-8xl mx-auto sm:px-6 lg:px-8 py-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-t-8 border-multirao-roxo">
            <div class="p-8 text-gray-900">
                
                <div class="flex justify-between items-center mb-8 pb-4 border-b">
                    <div>
                        <h2 class="text-2xl font-bold text-multirao-roxo uppercase">Histórico Prontuário</h2>
                        <p class="text-gray-500 text-sm italic uppercase font-bold tracking-widest">Linha do tempo e registros de <b>{{ $crianca->nome }}</b></p>
                    </div>
                    <a href="javascript:history.back()" class="text-sm font-bold text-gray-400 hover:text-multirao-roxo transition flex items-center uppercase tracking-widest">
                        &larr; Voltar
                    </a>
                </div>

                <!-- Botões de Atalho para as Etapas -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-10">
                    <a href="{{ route('triagem.onlyRead', $crianca->id) }}" class="flex items-center justify-center p-4 bg-gray-50 border-2 border-dashed border-multirao-roxo/20 rounded-xl hover:bg-multirao-roxo hover:text-white transition group">
                        <div class="text-center">
                            <p class="text-[10px] font-black uppercase tracking-widest opacity-60 group-hover:text-white">Etapa 1</p>
                            <p class="font-bold uppercase">Ver Pré-Inscrição</p>
                        </div>
                    </a>
                    <a href="{{ route('matricula.show', $crianca->id) }}" class="flex items-center justify-center p-4 bg-gray-50 border-2 border-dashed border-multirao-roxo/20 rounded-xl hover:bg-multirao-roxo hover:text-white transition group">
                        <div class="text-center">
                            <p class="text-[10px] font-black uppercase tracking-widest opacity-60 group-hover:text-white">Etapa 2</p>
                            <p class="font-bold uppercase">Ver Matrícula</p>
                        </div>
                    </a>
                    @if($crianca->anamnese)
                        <a href="{{ route('anamnese.show', $crianca->id) }}" class="flex items-center justify-center p-4 bg-gray-50 border-2 border-dashed border-multirao-roxo/20 rounded-xl hover:bg-multirao-roxo hover:text-white transition group">
                            <div class="text-center">
                                <p class="text-[10px] font-black uppercase tracking-widest opacity-60 group-hover:text-white">Etapa 3</p>
                                <p class="font-bold uppercase">Ver Anamnese</p>
                            </div>
                        </a>
                    @else
                        <div class="flex items-center justify-center p-4 bg-gray-100 border-2 border-dashed border-gray-200 rounded-xl cursor-not-allowed opacity-50">
                            <div class="text-center">
                                <p class="text-[10px] font-black uppercase tracking-widest opacity-60">Etapa 3</p>
                                <p class="font-bold uppercase text-gray-400">Anamnese não realizada</p>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Linha do Tempo (Logs) -->
                <div class="relative">
                    <div class="absolute left-4 top-0 bottom-0 w-0.5 bg-multirao-roxo/10"></div>
                    
                    <div class="space-y-8">
                        @forelse($crianca->logsAuditoria->sortByDesc('data_hora') as $log)
                            <div class="relative pl-12">
                                <div class="absolute left-2.5 top-1.5 w-3.5 h-3.5 rounded-full bg-multirao-roxo border-4 border-white shadow-sm"></div>
                                <div class="bg-gray-50 p-6 rounded-xl border border-gray-100 shadow-sm hover:shadow-md transition">
                                    <div class="flex justify-between items-start mb-2">
                                        <span class="text-[10px] font-black text-multirao-roxo uppercase tracking-widest bg-multirao-roxo/5 px-2 py-1 rounded">
                                            {{ $log->data_hora->format('d/m/Y H:i') }}
                                        </span>
                                        <span class="text-sm font-bold text-gray-400 uppercase">
                                            Por: {{ $log->usuario->name ?? 'Sistema' }}
                                        </span>
                                    </div>
                                    <h4 class="text-md font-black text-gray-800 uppercase mb-2">{{ $log->acao }}</h4>
                                    <p class="text-sm text-gray-600 italic">"{{ $log->detalhes }}"</p>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-20 bg-gray-50 rounded-xl border border-dashed border-gray-200">
                                <p class="text-gray-400 italic">Nenhum registro de atividade encontrado para esta criança.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>