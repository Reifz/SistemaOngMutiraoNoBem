<x-app-layout>
    <div class="max-w-8xl mx-auto sm:px-6 lg:px-8 py-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-8 text-gray-900">
                
                <div class="flex justify-between items-center mb-8 pb-4 border-b">
                    <div>
                        <h2 class="text-xl font-bold text-multirao-roxo uppercase">Central de Mensagens</h2>
                        <p class="text-sm text-gray-500">Comunicação interna sobre as crianças</p>
                    </div>
                    <a href="{{ route('mensagens.create') }}" class="bg-multirao-roxo text-white font-bold py-2 px-6 rounded-md shadow hover:bg-opacity-90 transition flex items-center uppercase text-sm">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                        Nova Mensagem
                    </a>
                </div>

                @if(session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                        <p class="font-bold">Sucesso!</p>
                        <p>{{ session('success') }}</p>
                    </div>
                @endif

                <div x-data="{ tab: 'recebidas' }">
                    <div class="flex space-x-4 mb-6 border-b">
                        <button @click="tab = 'recebidas'" :class="tab === 'recebidas' ? 'border-multirao-roxo text-multirao-roxo' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'" class="py-2 px-4 border-b-2 font-bold uppercase text-xs transition">
                            Caixa de Entrada 
                            @php $unreadCount = \App\Models\Mensagem::where('destinatario_id', Auth::id())->where('lida', false)->count(); @endphp
                            @if($unreadCount > 0)
                                <span class="ml-1 bg-red-500 text-white px-2 py-0.5 rounded-full text-[10px]">{{ $unreadCount }}</span>
                            @endif
                        </button>
                        <button @click="tab = 'enviadas'" :class="tab === 'enviadas' ? 'border-multirao-roxo text-multirao-roxo' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'" class="py-2 px-4 border-b-2 font-bold uppercase text-xs transition">
                            Enviadas
                        </button>
                    </div>

                    <!-- Recebidas -->
                    <div x-show="tab === 'recebidas'" class="space-y-4">
                        <div class="overflow-x-auto bg-gray-50 rounded-lg border">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-multirao-roxo uppercase tracking-wider">De</th>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-multirao-roxo uppercase tracking-wider">Sobre</th>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-multirao-roxo uppercase tracking-wider">Mensagem</th>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-multirao-roxo uppercase tracking-wider">Data</th>
                                        <th class="px-6 py-3 text-center text-xs font-bold text-multirao-roxo uppercase tracking-wider">Ações</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse($mensagensRecebidas as $msg)
                                        <tr class="{{ !$msg->lida ? 'bg-blue-50 font-bold' : '' }}">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ $msg->remetente->name }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                @if($msg->crianca)
                                                    <span class="text-multirao-roxo font-bold uppercase text-xs">{{ $msg->crianca->nome }}</span>
                                                @else
                                                    <span class="text-gray-400 italic text-xs">Geral</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="text-sm text-gray-600 truncate max-w-xs">{{ $msg->mensagem }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-500">
                                                {{ $msg->created_at->format('d/m/Y H:i') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                                <div class="flex justify-center space-x-2">
                                                    <a href="{{ route('mensagens.show', $msg->id) }}" class="text-multirao-roxo hover:text-indigo-900 bg-multirao-amarelo px-3 py-1 rounded font-bold uppercase text-[10px]">
                                                        Ver
                                                    </a>
                                                    <form action="{{ route('mensagens.destroy', $msg->id) }}" method="POST" onsubmit="return confirm('Excluir esta mensagem?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-600 hover:text-red-900 bg-red-50 px-3 py-1 rounded font-bold uppercase text-[10px] border border-red-100">
                                                            Excluir
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="px-6 py-12 text-center text-gray-500 italic">Nenhuma mensagem recebida.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4">
                            {{ $mensagensRecebidas->links() }}
                        </div>
                    </div>

                    <!-- Enviadas -->
                    <div x-show="tab === 'enviadas'" class="space-y-4" style="display: none;">
                        <div class="overflow-x-auto bg-gray-50 rounded-lg border">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-multirao-roxo uppercase tracking-wider">Para</th>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-multirao-roxo uppercase tracking-wider">Sobre</th>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-multirao-roxo uppercase tracking-wider">Mensagem</th>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-multirao-roxo uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-multirao-roxo uppercase tracking-wider">Data</th>
                                        <th class="px-6 py-3 text-center text-xs font-bold text-multirao-roxo uppercase tracking-wider">Ações</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse($mensagensEnviadas as $msg)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ $msg->destinatario->name }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                @if($msg->crianca)
                                                    <span class="text-multirao-roxo font-bold uppercase text-xs">{{ $msg->crianca->nome }}</span>
                                                @else
                                                    <span class="text-gray-400 italic text-xs">Geral</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="text-sm text-gray-600 truncate max-w-xs">{{ $msg->mensagem }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if($msg->lida)
                                                    <span class="px-2 inline-flex text-[10px] leading-5 font-bold rounded-full bg-green-100 text-green-800 uppercase">Lida</span>
                                                @else
                                                    <span class="px-2 inline-flex text-[10px] leading-5 font-bold rounded-full bg-gray-100 text-gray-800 uppercase">Pendente</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-500">
                                                {{ $msg->created_at->format('d/m/Y H:i') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                                <div class="flex justify-center space-x-2">
                                                    <a href="{{ route('mensagens.show', $msg->id) }}" class="text-multirao-roxo hover:text-indigo-900 bg-multirao-amarelo px-3 py-1 rounded font-bold uppercase text-[10px]">
                                                        Ver
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="px-6 py-12 text-center text-gray-500 italic">Nenhuma mensagem enviada.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4">
                            {{ $mensagensEnviadas->links() }}
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
