<x-app-layout>
    <div class="max-w-8xl mx-auto sm:px-6 lg:px-8 py-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-8 text-gray-900">
                
                <div class="flex justify-between items-center mb-8 pb-4 border-b">
                    <div>
                        <h2 class="text-xl font-bold text-multirao-roxo uppercase">Gestão de Usuários</h2>
                        <p class="text-sm text-gray-500">Controle de acesso e níveis de permissão (RBAC)</p>
                    </div>
                    <a href="{{ route('usuarios.create') }}" class="bg-multirao-roxo text-white font-bold py-2 px-6 rounded-md shadow hover:bg-opacity-90 transition flex items-center uppercase text-sm">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                        Novo Usuário
                    </a>
                </div>

                @if(session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                        <p class="font-bold">Sucesso!</p>
                        <p>{{ session('success') }}</p>
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                        <p class="font-bold">Erro!</p>
                        <p>{{ session('error') }}</p>
                    </div>
                @endif

                <div class="overflow-x-auto bg-gray-50 rounded-lg border">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-bold text-multirao-roxo uppercase tracking-wider">Nome / E-mail</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-multirao-roxo uppercase tracking-wider">Nível</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-multirao-roxo uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-center text-xs font-bold text-multirao-roxo uppercase tracking-wider">Ações</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($users as $user)
                                <tr class="{{ !$user->ativo ? 'bg-gray-50 opacity-75' : '' }}">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-bold text-gray-900">{{ $user->name }}</div>
                                        <div class="text-xs text-gray-500">{{ $user->email }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-bold rounded-full {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' }} uppercase">
                                            {{ $user->role }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($user->ativo)
                                            <span class="px-2 inline-flex text-xs leading-5 font-bold rounded-full bg-green-100 text-green-800 uppercase">Ativo</span>
                                        @else
                                            <span class="px-2 inline-flex text-xs leading-5 font-bold rounded-full bg-red-100 text-red-800 uppercase">Inativo</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                        <div class="flex justify-center space-x-2">
                                            <a href="{{ route('usuarios.edit', $user->id) }}" class="text-multirao-roxo hover:text-indigo-900 bg-multirao-amarelo px-3 py-1 rounded font-bold uppercase text-[10px]">
                                                Editar
                                            </a>
                                            
                                            <form action="{{ route('usuarios.toggle-status', $user->id) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="px-3 py-1 rounded font-bold uppercase text-[10px] {{ $user->ativo ? 'bg-red-50 text-red-600 border border-red-100' : 'bg-green-50 text-green-600 border border-green-100' }}">
                                                    {{ $user->ativo ? 'Inativar' : 'Ativar' }}
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-6">
                    {{ $users->links() }}
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
