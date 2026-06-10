<x-app-layout>
    <div class="max-w-8xl mx-auto sm:px-7 lg:px-9">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <div class="mb-4 flex justify-between items-center border-b pb-2">
                    <h2 class="font-semibold text-xl text-multirao-roxo leading-tight uppercase">
                        Gestão de Períodos (Anos Letivos)
                    </h2>
                    <a href="{{ route('rematricula.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-md text-sm font-bold transition duration-300">
                        Voltar para Rematrícula
                    </a>
                </div>

                @if(session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 shadow-sm" role="alert">
                        <p>{{ session('success') }}</p>
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 shadow-sm" role="alert">
                        <p>{{ session('error') }}</p>
                    </div>
                @endif

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Formulário de Criação -->
                    <div class="md:col-span-1 bg-gray-50 p-6 rounded-lg border border-gray-200 h-fit">
                        <h3 class="text-sm font-bold text-multirao-roxo uppercase mb-4 flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            Novo Ano Letivo
                        </h3>
                        <form action="{{ route('rematricula.ano.store') }}" method="POST" class="space-y-4">
                            @csrf
                            <div>
                                <label for="ano" class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Ano</label>
                                <input type="number" name="ano" id="ano" placeholder="Ex: 2027" class="w-full rounded border-gray-300 focus:ring-multirao-roxo focus:border-multirao-roxo text-sm" required>
                            </div>
                            <div>
                                <label for="data_virada" class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Dia de Virada (Idade/Série)</label>
                                <input type="date" name="data_virada" id="data_virada" class="w-full rounded border-gray-300 focus:ring-multirao-roxo focus:border-multirao-roxo text-sm" required>
                                <p class="text-[10px] text-gray-400 mt-1 italic">Data em que o sistema deve atualizar as idades e séries das crianças.</p>
                            </div>
                            <button type="submit" class="w-full bg-multirao-roxo text-white px-4 py-2 rounded font-bold hover:bg-opacity-90 transition shadow-sm uppercase text-xs">
                                Criar Período
                            </button>
                        </form>
                    </div>

                    <!-- Listagem -->
                    <div class="md:col-span-2 bg-white p-6 rounded-lg border border-gray-200">
                        <h3 class="text-sm font-bold text-multirao-roxo uppercase mb-4 flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path></svg>
                            Períodos Cadastrados
                        </h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white border border-gray-200 rounded-lg overflow-hidden">
                                <thead>
                                    <tr class="bg-gray-50 text-gray-600 uppercase text-xs leading-normal">
                                        <th class="py-3 px-4 text-left">Ano</th>
                                        <th class="py-3 px-4 text-left">Dia de Virada</th>
                                        <th class="py-3 px-4 text-center">Status</th>
                                        <th class="py-3 px-4 text-center">Ações</th>
                                    </tr>
                                </thead>
                                <tbody class="text-gray-600 text-sm font-light">
                                    @foreach($anosLetivos as $ano)
                                        <tr class="border-b border-gray-200 hover:bg-gray-50 transition">
                                            <td class="py-3 px-4 text-left font-bold text-gray-800">
                                                {{ $ano->ano }}
                                            </td>
                                            <td class="py-3 px-4 text-left">
                                                {{ $ano->data_virada ? $ano->data_virada->format('d/m/Y') : 'Não informada' }}
                                            </td>
                                            <td class="py-3 px-4 text-center">
                                                @if($ano->status_ativo)
                                                    <span class="bg-green-100 text-green-700 text-[10px] px-3 py-1 rounded-full font-bold uppercase">Ativo</span>
                                                @else
                                                    <span class="bg-gray-100 text-gray-500 text-[10px] px-3 py-1 rounded-full font-bold uppercase">Inativo</span>
                                                @endif
                                            </td>
                                            <td class="py-3 px-4 text-center">
                                                @if(!$ano->status_ativo)
                                                    <form action="{{ route('rematricula.ano.ativar', $ano->id) }}" method="POST">
                                                        @csrf
                                                        <button type="submit" class="bg-multirao-roxo text-white px-3 py-1 rounded text-[10px] font-bold hover:bg-opacity-90 transition uppercase" onclick="return confirm('Deseja tornar {{ $ano->ano }} o ano letivo ATIVO?')">
                                                            Ativar
                                                        </button>
                                                    </form>
                                                @else
                                                    <span class="text-multirao-roxo font-bold text-xs italic">Ano Atual</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
