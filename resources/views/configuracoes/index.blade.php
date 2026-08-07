<x-app-layout>
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 py-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-t-8 border-multirao-roxo">
            <div class="p-8 text-gray-900">
                
                <div class="flex justify-between items-center mb-8 pb-4 border-b">
                    <div>
                        <h2 class="text-2xl font-bold text-multirao-roxo uppercase">Configurações do Sistema</h2>
                    </div>
                </div>

                @if(session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                        <p class="font-bold">Sucesso!</p>
                        <p>{{ session('success') }}</p>
                    </div>
                @endif

                <form action="{{ route('configuracoes.store') }}" method="POST">
                    @csrf
                    
                    <div class="bg-gray-50 p-6 rounded-xl border border-gray-200 mb-8">
                        <h3 class="text-lg font-bold text-multirao-roxo mb-4 flex items-center uppercase border-b pb-2">
                            <svg class="w-5 h-5 mr-2 text-multirao-roxo" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                            </svg>
                            Módulo de Pré-Inscrições Públicas
                        </h3>
                        
                        <div class="flex items-start justify-between py-4">
                            <div class="mr-4">
                                <label class="text-md font-bold text-gray-800 uppercase block mb-1">Status do Formulário</label>
                                <span class="text-sm text-gray-500">
                                    Define se o formulário público de pré-inscrição de crianças estará disponível para novos envios pelos responsáveis.
                                </span>
                            </div>
                            <div class="flex items-center">
                                <label class="inline-flex items-center cursor-pointer select-none">
                                    <input type="hidden" name="inscricoes_abertas" value="0">
                                    <input type="checkbox" name="inscricoes_abertas" value="1" {{ $inscricoesAbertas ? 'checked' : '' }} class="sr-only peer">
                                    <div class="relative w-14 h-7 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-multirao-roxo"></div>
                                    <span class="ms-3 text-sm font-bold uppercase tracking-wider text-multirao-roxo peer-checked:text-multirao-roxo/80">
                                        {{ $inscricoesAbertas ? 'Abertas' : 'Fechadas' }}
                                    </span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end gap-4">
                        <button type="submit" class="bg-multirao-roxo text-white font-bold py-2.5 px-8 rounded-md shadow-md hover:bg-opacity-90 transition uppercase text-sm">
                            Salvar Configurações
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
