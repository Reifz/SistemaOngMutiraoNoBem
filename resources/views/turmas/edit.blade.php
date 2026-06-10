<x-app-layout>
    <div class="max-w-8xl mx-auto sm:px-6 lg:px-8 py-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-t-8 border-multirao-roxo">
            <div class="p-8 text-gray-900">
                
                <div class="flex justify-between items-center mb-8 pb-4 border-b">
                    <div>
                        <h2 class="text-2xl font-bold text-multirao-roxo uppercase">Editar Turma: {{ $turma->nome }}</h2>
                        <p class="text-gray-500 text-sm italic">Atualize as informações da sala/grupo.</p>
                    </div>
                    <a href="{{ route('turmas.index') }}" class="text-sm font-bold text-gray-500 hover:text-multirao-roxo transition flex items-center">
                        &larr; Voltar
                    </a>
                </div>

                <form action="{{ route('turmas.update', $turma->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div class="md:col-span-2">
                            <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Nome da Turma</label>
                            <input type="text" name="nome" value="{{ $turma->nome }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo" required>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Turno</label>
                            <select name="turno" class="w-full border-gray-300 rounded-md shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo" required>
                                <option value="MANHÃ" {{ $turma->turno == 'MANHÃ' ? 'selected' : '' }}>Manhã</option>
                                <option value="TARDE" {{ $turma->turno == 'TARDE' ? 'selected' : '' }}>Tarde</option>
                                <option value="INTEGRAL" {{ $turma->turno == 'INTEGRAL' ? 'selected' : '' }}>Integral</option>
                                <option value="NOITE" {{ $turma->turno == 'NOITE' ? 'selected' : '' }}>Noite</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Capacidade Máxima (Alunos)</label>
                            <input type="number" name="capacidade" value="{{ $turma->capacidade }}" min="1" class="w-full border-gray-300 rounded-md shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo" required>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Idade Mínima (Anos)</label>
                            <input type="number" name="idade_minima" value="{{ $turma->idade_minima }}" min="0" class="w-full border-gray-300 rounded-md shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Idade Máxima (Anos)</label>
                            <input type="number" name="idade_maxima" value="{{ $turma->idade_maxima }}" min="0" class="w-full border-gray-300 rounded-md shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo">
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-xs font-bold text-multirao-roxo uppercase mb-1">Descrição / Observações</label>
                            <textarea name="descricao" rows="3" class="w-full border-gray-300 rounded-md shadow-sm focus:border-multirao-roxo focus:ring-multirao-roxo">{{ $turma->descricao }}</textarea>
                        </div>

                        <div class="md:col-span-2">
                            <label class="inline-flex items-center">
                                <input type="hidden" name="ativa" value="0">
                                <input type="checkbox" name="ativa" value="1" {{ $turma->ativa ? 'checked' : '' }} class="rounded border-gray-300 text-multirao-roxo shadow-sm focus:ring-multirao-roxo">
                                <span class="ms-2 text-sm font-bold text-gray-600 uppercase">Turma Ativa para Alocação</span>
                            </label>
                        </div>
                    </div>

                    <div class="flex justify-end pt-4 border-t">
                        <button type="submit" class="bg-multirao-roxo text-multirao-amarelo font-bold py-3 px-10 rounded shadow-lg hover:bg-opacity-90 transition uppercase tracking-widest text-sm">
                            Atualizar Turma
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
