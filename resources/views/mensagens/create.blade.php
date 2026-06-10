<x-app-layout>
    <div class="max-w-8xl mx-auto sm:px-6 lg:px-8 py-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-8 text-gray-900">
                
                <div class="flex justify-between items-center mb-8 pb-4 border-b">
                    <div>
                        <h2 class="text-xl font-bold text-multirao-roxo uppercase">Nova Mensagem</h2>
                        <p class="text-sm text-gray-500">Envie uma mensagem interna para outro colaborador</p>
                    </div>
                    <a href="{{ route('mensagens.index') }}" class="text-multirao-roxo font-bold hover:underline uppercase text-sm flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Voltar
                    </a>
                </div>

                <form method="POST" action="{{ route('mensagens.store') }}" class="space-y-6">
                    @csrf

                    <!-- Destinatário -->
                    <div>
                        <x-input-label for="destinatario_id" :value="__('Para (Colaborador)')" class="text-multirao-roxo font-bold uppercase text-xs" />
                        <select id="destinatario_id" name="destinatario_id" class="tom-select block mt-1 w-full border-gray-300 focus:border-multirao-roxo focus:ring-multirao-roxo rounded-md shadow-sm" required>
                            <option value="">Selecione o destinatário...</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ (old('destinatario_id') == $user->id || $destinatario_id == $user->id) ? 'selected' : '' }}>
                                    {{ $user->name }} ({{ $user->role }})
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('destinatario_id')" class="mt-2" />
                    </div>

                    <!-- Criança Relacionada (Opcional) -->
                    <div>
                        <x-input-label for="crianca_id" :value="__('Sobre a Criança (Opcional)')" class="text-multirao-roxo font-bold uppercase text-xs" />
                        <select id="crianca_id" name="crianca_id" class="tom-select block mt-1 w-full border-gray-300 focus:border-multirao-roxo focus:ring-multirao-roxo rounded-md shadow-sm">
                            <option value="">Geral / Nenhuma específica</option>
                            @foreach($criancas as $crianca)
                                <option value="{{ $crianca->id }}" {{ (old('crianca_id') == $crianca->id || $crianca_id == $crianca->id) ? 'selected' : '' }}>
                                    {{ $crianca->nome }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('crianca_id')" class="mt-2" />
                    </div>

                    <!-- Mensagem -->
                    <div>
                        <x-input-label for="mensagem" :value="__('Mensagem')" class="text-multirao-roxo font-bold uppercase text-xs" />
                        <textarea id="mensagem" name="mensagem" rows="6" class="block mt-1 w-full border-gray-300 focus:border-multirao-roxo focus:ring-multirao-roxo rounded-md shadow-sm" required>{{ old('mensagem') }}</textarea>
                        <x-input-error :messages="$errors->get('mensagem')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end mt-8 pt-6 border-t">
                        <button type="submit" class="bg-multirao-roxo text-white font-bold py-3 px-8 rounded-md shadow hover:bg-opacity-90 transition uppercase text-sm flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                            Enviar Mensagem
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <!-- Tom Select Assets -->
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
    <script>
        document.querySelectorAll('.tom-select').forEach((el) => {
            new TomSelect(el, {
                create: false,
                sortField: {
                    field: "text",
                    direction: "asc"
                }
            });
        });
    </script>
</x-app-layout>
