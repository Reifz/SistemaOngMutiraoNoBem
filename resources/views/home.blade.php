<x-app-layout>
    <div class="py-12">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <!-- Seções de Destaque: Aniversariantes e Alertas -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <!-- Aniversariantes -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-l-8 border-multirao-amarelo">
                    <div class="p-6">
                        <h3 class="text-sm font-bold text-multirao-roxo uppercase flex items-center mb-4">
                            <svg class="w-5 h-5 mr-2 text-multirao-amarelo" fill="currentColor" viewBox="0 0 20 20"><path d="M11 3a1 1 0 10-2 0v1a1 1 0 102 0V3zM15.657 5.757a1 1 0 00-1.414-1.414l-.707.707a1 1 0 001.414 1.414l.707-.707zM18 10a1 1 0 01-1 1h-1a1 1 0 110-2h1a1 1 0 011 1zM5.05 6.464A1 1 0 106.464 5.05l-.707-.707a1 1 0 00-1.414 1.414l.707.707zM5 10a1 1 0 01-1 1H3a1 1 0 110-2h1a1 1 0 011 1zM8 16v-1a1 1 0 112 0v1a1 1 0 11-2 0zM13 16v-1a1 1 0 112 0v1a1 1 0 11-2 0zM16 10a1 1 0 01-1 1h-1a1 1 0 110-2h1a1 1 0 011 1z"></path><path fill-rule="evenodd" d="M5 5a3 3 0 015-2.236A3 3 0 0114.83 6H16a2 2 0 110 4h-5V9a1 1 0 10-2 0v1H4a2 2 0 110-4h1.17C5.06 5.687 5 5.35 5 5zm3.354 8.854a.5.5 0 11-.708-.708L13 7.793V6.5a.5.5 0 011 0v1.5a.5.5 0 01-.146.354l-5.5 5.5z" clip-rule="evenodd"></path></svg>
                            Aniversariantes de Hoje
                        </h3>
                        @forelse($aniversariantes as $niver)
                            <div class="flex justify-between items-center p-2 hover:bg-gray-50 rounded border-b last:border-0">
                                <span class="text-sm font-bold text-gray-700">{{ $niver->nome }}</span>
                                <span class="text-[10px] bg-multirao-amarelo text-multirao-roxo font-black px-2 py-1 rounded-full uppercase">{{ $niver->data_nascimento->age }} Anos</span>
                            </div>
                        @empty
                            <p class="text-xs text-gray-400 italic">Nenhum aniversariante hoje.</p>
                        @endforelse
                    </div>
                </div>

                <!-- Alertas de Triagem -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-l-8 border-red-500">
                    <div class="p-6">
                        <h3 class="text-sm font-bold text-red-600 uppercase flex items-center mb-4">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Alertas de Triagem (> 7 dias)
                        </h3>
                        @forelse($alertasTriagem as $alerta)
                            <div class="flex justify-between items-center p-2 hover:bg-gray-50 rounded border-b last:border-0">
                                <div class="flex flex-col">
                                    <span class="text-sm font-bold text-gray-700">{{ $alerta->nome }}</span>
                                    <span class="text-[9px] text-red-400 font-bold uppercase">Parado há {{ (int)$alerta->created_at->diffInDays() }} dias</span>
                                </div>
                                <a href="{{ route('triagem.show', $alerta->id) }}" class="text-[10px] bg-red-100 text-red-700 font-bold px-3 py-1 rounded hover:bg-red-600 hover:text-white transition uppercase">
                                    Ir para Triagem
                                </a>
                            </div>
                        @empty
                            <p class="text-xs text-gray-400 italic">Nenhum alerta pendente.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-t-8 border-multirao-roxo">
                <div class="p-10 text-center">
                    <img src="{{ asset('logo.png') }}" alt="Logo Multirão Bem" class="h-10 mx-auto mb-6 p-2">
                    
                    <h1 class="text-3xl font-extrabold text-multirao-roxo mb-4">Bem-vindo ao Sistema Interno</h1>
                    <p class="text-gray-600 max-w-2xl mx-auto text-lg mb-8 leading-relaxed">
                        Este é o painel de controle administrativo da ONG <b>Multirão no Bem</b>. 
                    </p>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-10">
                        <div class="p-6 rounded-xl border border-indigo-100 shadow-sm">
                            <h3 class="font-bold text-multirao-roxo mb-2">1. Triagem</h3>
                            <p class="text-xs text-gray-500">Avalie as novas pré-inscrições recebidas pelo formulário público.</p>
                        </div>
                        <div class="p-6 rounded-xl border border-indigo-100 shadow-sm">
                            <h3 class="font-bold text-multirao-roxo mb-2">2. Matrícula</h3>
                            <p class="text-xs text-gray-500">Entreviste a criança e preencha a matrícula, validando os documentos anexados.</p>
                        </div>
                        <div class="p-6 rounded-xl border border-indigo-100 shadow-sm">
                            <h3 class="font-bold text-multirao-roxo mb-2">3. Anamnese</h3>
                            <p class="text-xs text-gray-500">Etapa final de avaliação e preenchimento dos dados adicionais da criança.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
