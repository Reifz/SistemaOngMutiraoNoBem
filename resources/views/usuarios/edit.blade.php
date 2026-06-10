<x-app-layout>
    <div class="max-w-8xl mx-auto sm:px-6 lg:px-8 py-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-8 text-gray-900">
                
                <div class="flex justify-between items-center mb-8 pb-4 border-b">
                    <div>
                        <h2 class="text-xl font-bold text-multirao-roxo uppercase">Editar Usuário</h2>
                        <p class="text-sm text-gray-500">Atualize as informações do colaborador</p>
                    </div>
                    <a href="{{ route('usuarios.index') }}" class="text-multirao-roxo font-bold hover:underline uppercase text-sm flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Voltar
                    </a>
                </div>

                <form method="POST" action="{{ route('usuarios.update', $user->id) }}" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Nome -->
                    <div>
                        <x-input-label for="name" :value="__('Nome Completo')" class="text-multirao-roxo font-bold uppercase text-xs" />
                        <x-text-input id="name" class="block mt-1 w-full border-gray-300 focus:border-multirao-roxo focus:ring-multirao-roxo rounded-md shadow-sm" type="text" name="name" :value="old('name', $user->name)" required autofocus />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <!-- Email -->
                    <div>
                        <x-input-label for="email" :value="__('E-mail (Login)')" class="text-multirao-roxo font-bold uppercase text-xs" />
                        <x-text-input id="email" class="block mt-1 w-full border-gray-300 focus:border-multirao-roxo focus:ring-multirao-roxo rounded-md shadow-sm" type="email" name="email" :value="old('email', $user->email)" required />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div class="bg-blue-50 p-4 rounded-md border border-blue-100 mb-6">
                        <p class="text-xs text-blue-700 font-bold uppercase mb-2">Alterar Senha</p>
                        <p class="text-xs text-blue-600 mb-4 italic">Deixe os campos abaixo em branco para manter a senha atual.</p>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Senha -->
                            <div>
                                <x-input-label for="password" :value="__('Nova Senha')" class="text-multirao-roxo font-bold uppercase text-xs" />
                                <x-text-input id="password" class="block mt-1 w-full border-gray-300 focus:border-multirao-roxo focus:ring-multirao-roxo rounded-md shadow-sm" type="password" name="password" />
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>

                            <!-- Confirmar Senha -->
                            <div>
                                <x-input-label for="password_confirmation" :value="__('Confirmar Nova Senha')" class="text-multirao-roxo font-bold uppercase text-xs" />
                                <x-text-input id="password_confirmation" class="block mt-1 w-full border-gray-300 focus:border-multirao-roxo focus:ring-multirao-roxo rounded-md shadow-sm" type="password" name="password_confirmation" />
                                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                            </div>
                        </div>
                    </div>

                    <!-- Nível de Acesso -->
                    <div>
                        <x-input-label for="role" :value="__('Nível de Acesso')" class="text-multirao-roxo font-bold uppercase text-xs" />
                        <select id="role" name="role" class="block mt-1 w-full border-gray-300 focus:border-multirao-roxo focus:ring-multirao-roxo rounded-md shadow-sm">
                            <option value="user" {{ old('role', $user->role) == 'user' ? 'selected' : '' }}>USUÁRIO (Acesso padrão)</option>
                            <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>ADMINISTRADOR (Gestão total)</option>
                        </select>
                        <x-input-error :messages="$errors->get('role')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end mt-8 pt-6 border-t">
                        <button type="submit" class="bg-multirao-roxo text-white font-bold py-3 px-8 rounded-md shadow hover:bg-opacity-90 transition uppercase text-sm flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Atualizar Usuário
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
