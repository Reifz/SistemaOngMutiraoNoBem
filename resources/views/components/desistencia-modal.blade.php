@props(['crianca'])

@php
    $desistenciaModalId = 'desistenciaModal' . $crianca->id;
@endphp

<div id="{{ $desistenciaModalId }}" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="desistencia-modal-title-{{ $crianca->id }}" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="closeDesistenciaModal({{ $crianca->id }})"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border-t-8 border-amber-500">
            <form action="{{ route('matricula.desistir', $crianca->id) }}" method="POST">
                @csrf
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-amber-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12H9m12 0A9 9 0 113 12a9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-bold text-gray-900 uppercase" id="desistencia-modal-title-{{ $crianca->id }}">Registrar Desist&ecirc;ncia</h3>
                            <div class="mt-4 space-y-4">
                                <p class="text-sm text-gray-500 italic">Informe a data e o motivo da desist&ecirc;ncia de <b>{{ $crianca->nome }}</b>.</p>

                                <div>
                                    <label class="block text-xs font-bold text-amber-700 uppercase mb-1">Data da Desist&ecirc;ncia</label>
                                    <input type="date" name="data_desistencia" value="{{ date('Y-m-d') }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-amber-600 focus:ring-amber-600 text-sm" required>
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-amber-700 uppercase mb-1">Motivo / Observa&ccedil;&atilde;o</label>
                                    <textarea name="motivo_desistencia" rows="3" placeholder="Descreva o motivo informado pela familia ou pela equipe..." class="w-full border-gray-300 rounded-md shadow-sm focus:border-amber-600 focus:ring-amber-600 text-sm" required></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-amber-600 text-base font-bold text-white hover:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 sm:ml-3 sm:w-auto sm:text-xs uppercase">
                        Confirmar Desist&ecirc;ncia
                    </button>
                    <button type="button" onclick="closeDesistenciaModal({{ $crianca->id }})" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-bold text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-xs uppercase">
                        Cancelar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@once
    @push('scripts')
        <script>
            function openDesistenciaModal(id) {
                const modal = document.getElementById('desistenciaModal' + id);
                if (modal) {
                    modal.classList.remove('hidden');
                }
            }

            function closeDesistenciaModal(id) {
                const modal = document.getElementById('desistenciaModal' + id);
                if (modal) {
                    modal.classList.add('hidden');
                }
            }
        </script>
    @endpush
@endonce
