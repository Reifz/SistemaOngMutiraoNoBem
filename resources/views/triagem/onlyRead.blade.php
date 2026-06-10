<x-app-layout>
    <div class="max-w-8xl mx-auto sm:px-6 lg:px-8 py-6">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-t-4 border-multirao-roxo">
            <div class="p-6">
                <div class="flex justify-between items-center mb-6 border-b pb-4">
                    <h2 class="text-2xl font-bold text-multirao-roxo uppercase">
                        Detalhes da Pré-Inscrição
                    </h2>
                    <a href="{{ route('matricula.index') }}" class="text-sm font-bold text-gray-500 hover:text-multirao-roxo transition">
                        &larr; Voltar para a Lista
                    </a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                    <!-- Dados da Criança -->
                    <div class="bg-gray-50 p-5 rounded-lg border border-gray-200 shadow-sm">
                        <h3 class="text-lg font-bold text-multirao-roxo mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            Dados da Criança
                        </h3>
                        <div class="space-y-3">
                            <p class="text-sm"><span class="font-bold text-gray-700 uppercase text-xs block">Nome:</span> <span class="text-lg font-semibold">{{ $crianca->nome }}</span></p>
                            <div class="grid grid-cols-2 gap-4">
                                <p class="text-sm"><span class="font-bold text-gray-700 uppercase text-xs block">Idade:</span> {{ $crianca->idade }} anos</p>
                                {{-- <p class="text-sm"><span class="font-bold text-gray-700 uppercase text-xs block">Gênero:</span> {{ $crianca->sexo }}</p> --}}
                            </div>
                            <p class="text-sm"><span class="font-bold text-gray-700 uppercase text-xs block">Escola:</span> {{ $crianca->escola }}</p>
                            <p class="text-sm"><span class="font-bold text-gray-700 uppercase text-xs block">Série / Período:</span> {{ $crianca->serie }} - {{ $crianca->periodo_escolar }}</p>
                        </div>
                    </div>

                    <!-- Dados do Responsável -->
                    <div class="bg-gray-50 p-5 rounded-lg border border-gray-200 shadow-sm">
                        <h3 class="text-lg font-bold text-multirao-roxo mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            Dados do Responsável
                        </h3>
                        <div class="space-y-3">
                            <p class="text-sm"><span class="font-bold text-gray-700 uppercase text-xs block">Nome:</span> <span class="text-lg font-semibold">{{ $crianca->responsavel->nome }}</span></p>

                            @php $telefone = preg_replace('/\D/', '', $crianca->responsavel->telefone); @endphp

                            <p class="text-sm"><span class="font-bold text-gray-700 uppercase text-xs block">Telefone:</span> 
                                <div class="flex items-center gap-2 text-sm">
                                    {{ $crianca->responsavel->telefone }} 
                                    <a href="https://wa.me/55{{ $telefone }}?text=Olá,%20tudo%20bem?%20Somos%20da%20Ong%20Multirao%20no%20Bem" target="_blank" class="text-green-600 underline">
                                        <svg class="w-5 h-5 mr-2 text-green-500" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M12 2a10 10 0 00-8.94 14.32L2 22l5.83-1.53A10 10 0 1012 2zm5.07 14.57c-.21.58-1.23 1.08-1.7 1.15-.44.07-1 .1-1.62-.1-.38-.12-.87-.28-1.5-.55-2.64-1.14-4.36-3.93-4.5-4.12-.14-.19-1.07-1.43-1.07-2.72 0-1.29.67-1.92.9-2.18.23-.26.5-.32.67-.32.17 0 .34 0 .5.01.16.01.37-.06.58.44.21.5.71 1.74.77 1.87.06.13.1.29.02.48-.08.19-.12.31-.25.48-.13.17-.27.38-.39.51-.13.13-.27.27-.12.53.14.26.63 1.04 1.35 1.69.93.83 1.71 1.08 1.97 1.2.26.12.41.1.56-.06.15-.17.64-.74.81-.99.17-.25.34-.21.57-.13.23.08 1.48.7 1.73.82.25.12.42.19.48.29.06.1.06.58-.15 1.16z"/>
                                        </svg>
                                    </a>
                                </div>
                            </p>

                            @php $telefone_secundario = preg_replace('/\D/', '', $crianca->responsavel->telefone_secundario); @endphp

                            <p class="text-sm"><span class="font-bold text-gray-700 uppercase text-xs block">Telefone Secundário:</span> 
                                <div class="flex items-center gap-2 text-sm">
                                    {{ $crianca->responsavel->telefone_secundario ?? 'Não informado' }}
                                    <a href="https://wa.me/55{{ $telefone_secundario }}?text=Olá,%20tudo%20bem?%20Somos%20da%20Ong%20Multirao%20no%20Bem" target="_blank" class="text-green-600 underline">
                                        <svg class="w-5 h-5 mr-2 text-green-500" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M12 2a10 10 0 00-8.94 14.32L2 22l5.83-1.53A10 10 0 1012 2zm5.07 14.57c-.21.58-1.23 1.08-1.7 1.15-.44.07-1 .1-1.62-.1-.38-.12-.87-.28-1.5-.55-2.64-1.14-4.36-3.93-4.5-4.12-.14-.19-1.07-1.43-1.07-2.72 0-1.29.67-1.92.9-2.18.23-.26.5-.32.67-.32.17 0 .34 0 .5.01.16.01.37-.06.58.44.21.5.71 1.74.77 1.87.06.13.1.29.02.48-.08.19-.12.31-.25.48-.13.17-.27.38-.39.51-.13.13-.27.27-.12.53.14.26.63 1.04 1.35 1.69.93.83 1.71 1.08 1.97 1.2.26.12.41.1.56-.06.15-.17.64-.74.81-.99.17-.25.34-.21.57-.13.23.08 1.48.7 1.73.82.25.12.42.19.48.29.06.1.06.58-.15 1.16z"/>
                                        </svg>
                                    </a>  
                                </div>                  
                            </p>
                            <p class="text-sm"><span class="font-bold text-gray-700 uppercase text-xs block">Email:</span> {{ $crianca->responsavel->email }}</p>      
                        </div>
                    </div>
                </div>

                <!-- Histórico e Observações (Ponto 2) -->
                <div class="mb-8">
                    <h3 class="text-lg font-bold text-multirao-roxo mb-4 uppercase border-b pb-2 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                        Histórico e Observações
                    </h3>
                    @if($crianca->logsAuditoria->isEmpty())
                        <p class="text-sm text-gray-500 italic">Nenhuma observação registrada até o momento.</p>
                    @else
                        <div class="space-y-3">
                            @foreach($crianca->logsAuditoria as $log)
                                <div class="bg-blue-50 p-3 rounded border-l-4 border-blue-400">
                                    <div class="flex justify-between items-start mb-1">
                                        <span class="text-xs font-bold text-blue-800 uppercase">{{ $log->acao }}</span>
                                        <span class="text-xs text-gray-500">
                                            {{ $log->data_hora->format('d/m/Y H:i') }} por <span class="font-bold text-sm">{{ $log->usuario->name ?? 'Sistema' }}</span>
                                        </span>
                                    </div>
                                    <p class="text-sm text-gray-700 italic">"{{ $log->detalhes }}"</p>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>       
            </div>
        </div>
    </div>
</x-app-layout>
