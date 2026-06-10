<x-app-layout>
    <div class="max-w-8xl mx-auto sm:px-6 lg:px-8 py-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-8 text-gray-900">
                
                <div class="flex justify-between items-center mb-8 pb-4 border-b">
                    <div>
                        <h2 class="text-xl font-bold text-multirao-roxo uppercase">Visualizar Mensagem</h2>
                        <p class="text-sm text-gray-500">Detalhes da comunicação interna</p>
                    </div>
                    <a href="{{ route('mensagens.index') }}" class="text-multirao-roxo font-bold hover:underline uppercase text-sm flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Voltar
                    </a>
                </div>

                <div class="bg-gray-50 rounded-lg p-6 border mb-8">
                    <div class="flex justify-between items-start mb-6 border-b pb-4">
                        <div class="space-y-1">
                            <p class="text-xs font-bold text-multirao-roxo uppercase tracking-wider">De:</p>
                            <p class="text-sm font-bold text-gray-900">{{ $mensagem->remetente->name }}</p>
                            
                            <p class="text-xs font-bold text-multirao-roxo uppercase tracking-wider mt-4">Para:</p>
                            <p class="text-sm font-bold text-gray-900">{{ $mensagem->destinatario->name }}</p>
                        </div>
                        <div class="text-right space-y-1">
                            <p class="text-xs font-bold text-multirao-roxo uppercase tracking-wider">Data/Hora:</p>
                            <p class="text-sm text-gray-600">{{ $mensagem->created_at->format('d/m/Y H:i:s') }}</p>
                            
                            @if($mensagem->crianca)
                                <p class="text-xs font-bold text-multirao-roxo uppercase tracking-wider mt-4">Sobre a Criança:</p>
                                <a href="{{ route('matricula.show', $mensagem->crianca_id) }}" class="text-sm font-bold text-multirao-roxo hover:underline uppercase">
                                    {{ $mensagem->crianca->nome }}
                                </a>
                            @endif
                        </div>
                    </div>

                    <div class="prose max-w-none">
                        <p class="text-xs font-bold text-multirao-roxo uppercase tracking-wider mb-2">Conteúdo:</p>
                        <div class="bg-white p-4 rounded border text-gray-800 whitespace-pre-wrap leading-relaxed">
                            {{ $mensagem->mensagem }}
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-between mt-8 pt-6 border-t">
                    @if($mensagem->destinatario_id === Auth::id())
                        <a href="{{ route('mensagens.create', ['destinatario_id' => $mensagem->remetente_id, 'crianca_id' => $mensagem->crianca_id]) }}" class="bg-multirao-roxo text-white font-bold py-3 px-8 rounded-md shadow hover:bg-opacity-90 transition uppercase text-sm flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path></svg>
                            Responder
                        </a>
                    @else
                        <div></div>
                    @endif

                    <form action="{{ route('mensagens.destroy', $mensagem->id) }}" method="POST" onsubmit="return confirm('Excluir esta mensagem permanentemente?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 font-bold hover:underline uppercase text-xs flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            Excluir Mensagem
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
