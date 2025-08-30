@extends('layouts.admin')

@section('title', 'Cartão - ' . $card->serial_number)

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="overflow-hidden bg-white rounded-lg shadow-sm">
        <div class="p-6 border-b border-gray-200">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Cartão {{ $card->serial_number }}</h2>
                    <p class="text-gray-600">{{ $card->employee->name }} • {{ $card->employee->department }}</p>
                </div>
                <div class="flex mt-4 space-x-3 lg:mt-0">
                    <a href="{{ route('admin.cards.preview', $card) }}" class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-indigo-600 border border-transparent rounded-md hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        Preview
                    </a>
                    <a href="{{ route('admin.cards.export', [$card, 'pdf']) }}" class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-green-600 border border-transparent rounded-md hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Baixar PDF
                    </a>
                    @if($card->status === 'active')
                        <button onclick="openRevokeModal({{ $card->id }})" class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-red-600 border border-transparent rounded-md hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636m12.728 12.728L18.364 5.636M5.636 18.364l12.728-12.728"></path>
                            </svg>
                            Revogar
                        </button>
                    @endif
                    <a href="{{ route('admin.cards.index') }}" class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase bg-gray-600 border border-transparent rounded-md hover:bg-gray-700">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Voltar
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
        <!-- Card Information -->
        <div class="space-y-6 lg:col-span-2">
            <!-- Employee Info -->
            <div class="overflow-hidden bg-white rounded-lg shadow-sm">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">Informações do Colaborador</h3>
                </div>
                <div class="px-6 py-4">
                    <div class="flex items-center space-x-6">
                        <div class="flex-shrink-0">
                            <img class="object-cover w-20 h-20 border-4 border-gray-200 rounded-full" src="{{ $card->employee->photo_url }}" alt="{{ $card->employee->name }}">
                        </div>
                        <div class="flex-1">
                            <h4 class="text-xl font-semibold text-gray-900">{{ $card->employee->name }}</h4>
                            <p class="text-sm text-gray-600">{{ $card->employee->position }}</p>
                            <p class="text-sm text-gray-500">{{ $card->employee->department }}</p>
                            <div class="flex items-center mt-2 space-x-4 text-sm text-gray-500">
                                <span>ID: {{ $card->employee->identification_number }}</span>
                                <span>•</span>
                                <a href="mailto:{{ $card->employee->email }}" class="text-blue-600 hover:text-blue-500">{{ $card->employee->email }}</a>
                                @if($card->employee->phone)
                                    <span>•</span>
                                    <a href="tel:{{ $card->employee->phone }}" class="text-blue-600 hover:text-blue-500">{{ $card->employee->phone }}</a>
                                @endif
                            </div>
                        </div>
                        <div>
                            <a href="{{ route('admin.employees.show', $card->employee) }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-blue-700 bg-blue-100 rounded-lg hover:bg-blue-200 focus:ring-4 focus:outline-none focus:ring-blue-300">
                                Ver Perfil
                                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card Details -->
            <div class="overflow-hidden bg-white rounded-lg shadow-sm">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">Detalhes do Cartão</h3>
                </div>
                <div class="px-6 py-4">
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Número de Série</dt>
                            <dd class="mt-1 font-mono text-sm text-gray-900">{{ $card->serial_number }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Template</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                <a href="{{ route('admin.card-templates.show', $card->cardTemplate) }}" class="text-blue-600 hover:text-blue-500">
                                    {{ $card->cardTemplate->name }}
                                </a>
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Data de Emissão</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $card->issued_date->format('d/m/Y') }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Data de Validade</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $card->expiry_date->format('d/m/Y') }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Status</dt>
                            <dd class="mt-1">
                                <span class="inline-flex px-2 text-xs font-semibold leading-5 rounded-full
                                    @if($card->status === 'active') bg-green-100 text-green-800
                                    @elseif($card->status === 'expired' || $card->isExpired()) bg-yellow-100 text-yellow-800
                                    @else bg-red-100 text-red-800 @endif">
                                    @if($card->isExpired() && $card->status !== 'revoked') Expirado
                                    @else {{ ucfirst($card->status) }} @endif
                                </span>
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Dimensões</dt>
                            <dd class="mt-1 font-mono text-sm text-gray-900">{{ $card->cardTemplate->width }}mm × {{ $card->cardTemplate->height }}mm</dd>
                        </div>
                        @if($card->status === 'revoked')
                            <div class="sm:col-span-2">
                                <dt class="text-sm font-medium text-gray-500">Motivo da Revogação</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $card->revoked_reason }}</dd>
                            </div>
                            <div class="sm:col-span-2">
                                <dt class="text-sm font-medium text-gray-500">Revogado em</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $card->revoked_at->format('d/m/Y H:i') }}</dd>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- QR Code and Verification -->
            <div class="overflow-hidden bg-white rounded-lg shadow-sm">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">Verificação</h3>
                </div>
                <div class="px-6 py-4">
                    <div class="flex items-center space-x-6">
                        <div class="flex-shrink-0">
                            @if($card->qr_code_url)
                                <img src="{{ $card->qr_code_url }}" class="w-24 h-24 border border-gray-300 rounded">
                            @else
                                <div class="flex items-center justify-center w-24 h-24 text-gray-500 bg-gray-100 border border-gray-300 rounded">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M12 12h-4.01m4.01 0v3M12 4h-4.01M12 4H8.01M12 8v4m0 0v3"></path>
                                    </svg>
                                </div>
                            @endif
                        </div>
                        <div class="flex-1">
                            <div class="space-y-2">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Token de Verificação</dt>
                                    <dd class="mt-1 font-mono text-sm text-gray-900 break-all">{{ $card->verification_token }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">URL de Verificação</dt>
                                    <dd class="mt-1">
                                        <a href="{{ $card->verification_url }}" target="_blank" class="text-sm text-blue-600 break-all hover:text-blue-500">
                                            {{ $card->verification_url }}
                                        </a>
                                    </dd>
                                </div>
                                <div class="pt-2">
                                    <a href="{{ $card->verification_url }}" target="_blank" class="inline-flex items-center px-3 py-2 text-sm font-medium text-green-700 bg-green-100 rounded-lg hover:bg-green-200 focus:ring-4 focus:outline-none focus:ring-green-300">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        Testar Verificação
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Quick Actions -->
            <div class="overflow-hidden bg-white rounded-lg shadow-sm">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">Ações Rápidas</h3>
                </div>
                <div class="px-6 py-4 space-y-3">
                    <a href="{{ route('admin.cards.preview', $card) }}" class="inline-flex items-center w-full px-3 py-2 text-sm font-medium text-center text-indigo-700 bg-indigo-100 rounded-lg hover:bg-indigo-200 focus:ring-4 focus:outline-none focus:ring-indigo-300">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        Ver Preview
                    </a>

                    <a href="{{ route('admin.cards.export', [$card, 'pdf']) }}" class="inline-flex items-center w-full px-3 py-2 text-sm font-medium text-center text-green-700 bg-green-100 rounded-lg hover:bg-green-200 focus:ring-4 focus:outline-none focus:ring-green-300">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Baixar PDF
                    </a>

                    <a href="{{ $card->verification_url }}" target="_blank" class="inline-flex items-center w-full px-3 py-2 text-sm font-medium text-center text-blue-700 bg-blue-100 rounded-lg hover:bg-blue-200 focus:ring-4 focus:outline-none focus:ring-blue-300">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                        </svg>
                        Verificar Online
                    </a>

                    @if($card->status === 'active')
                        <button onclick="openRevokeModal({{ $card->id }})" class="inline-flex items-center w-full px-3 py-2 text-sm font-medium text-center text-red-700 bg-red-100 rounded-lg hover:bg-red-200 focus:ring-4 focus:outline-none focus:ring-red-300">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636m12.728 12.728L18.364 5.636M5.636 18.364l12.728-12.728"></path>
                            </svg>
                            Revogar Cartão
                        </button>
                    @endif
                </div>
            </div>

            <!-- Card Stats -->
            <div class="overflow-hidden bg-white rounded-lg shadow-sm">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">Estatísticas</h3>
                </div>
                <div class="px-6 py-4">
                    <dl class="space-y-3">
                        <div class="flex justify-between">
                            <dt class="text-sm font-medium text-gray-500">Verificações:</dt>
                            <dd class="text-sm text-gray-900">{{ $card->verificationLogs->count() }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-sm font-medium text-gray-500">Dias restantes:</dt>
                            <dd class="text-sm text-gray-900">
                                @if($card->status === 'revoked')
                                    <span class="text-red-600">Revogado</span>
                                @elseif($card->isExpired())
                                    <span class="text-yellow-600">Expirado</span>
                                @else
                                    {{ $card->expiry_date->diffInDays(now()) }} dias
                                @endif
                            </dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-sm font-medium text-gray-500">Tempo ativo:</dt>
                            <dd class="text-sm text-gray-900">{{ $card->created_at->diffForHumans() }}</dd>
                        </div>
                        @if($card->verificationLogs->count() > 0)
                            <div class="pt-3 border-t border-gray-200">
                                <div class="flex justify-between">
                                    <dt class="text-sm font-medium text-gray-500">Última verificação:</dt>
                                    {{-- <dd class="text-sm text-gray-900">{{ $card->verificationLogs->latest()->first()->created_at }}</dd> --}}
                                </div>
                            </div>
                        @endif
                    </dl>
                </div>
            </div>

            <!-- Related Links -->
            <div class="overflow-hidden bg-white rounded-lg shadow-sm">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">Links Relacionados</h3>
                </div>
                <div class="px-6 py-4 space-y-3">
                    <a href="{{ route('admin.employees.show', $card->employee) }}" class="block text-sm text-blue-600 hover:text-blue-500">
                        → Ver perfil do colaborador
                    </a>
                    <a href="{{ route('admin.card-templates.show', $card->cardTemplate) }}" class="block text-sm text-blue-600 hover:text-blue-500">
                        → Ver template usado
                    </a>
                    <a href="{{ route('admin.cards.create') }}?employee={{ $card->employee->id }}" class="block text-sm text-blue-600 hover:text-blue-500">
                        → Emitir novo cartão para este colaborador
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Verification Logs -->
    @if($card->verificationLogs->count() > 0)
        <div class="overflow-hidden bg-white rounded-lg shadow-sm">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium leading-6 text-gray-900">Log de Verificações</h3>
                <p class="mt-1 text-sm text-gray-600">Histórico de verificações deste cartão</p>
            </div>
            <div class="overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Data/Hora</th>
                            <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">IP</th>
                            <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">User Agent</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($card->verificationLogs->sortByDesc('created_at')->take(10) as $log)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap">{{ $log->verified_at->format('d/m/Y H:i:s') }}</td>
                                <td class="px-6 py-4 font-mono text-sm text-gray-500 whitespace-nowrap">{{ $log->ip_address }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    <div class="max-w-xs truncate" title="{{ $log->user_agent }}">
                                        {{ $log->user_agent ?? 'N/A' }}
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @if($card->verificationLogs->count() > 10)
                    <div class="px-6 py-3 text-sm text-gray-500 bg-gray-50">
                        Mostrando as 10 verificações mais recentes de {{ $card->verificationLogs->count() }} total.
                    </div>
                @endif
            </div>
        </div>
    @endif
</div>

<!-- Revoke Modal -->
<div id="revokeModal" class="fixed inset-0 z-10 hidden overflow-y-auto">
    <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>
        <div class="inline-block overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form id="revokeForm" method="POST">
                @csrf
                <div class="px-4 pt-5 pb-4 bg-white sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="flex items-center justify-center flex-shrink-0 w-12 h-12 mx-auto bg-red-100 rounded-full sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="w-6 h-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636m12.728 12.728L18.364 5.636M5.636 18.364l12.728-12.728"/>
                            </svg>
                        </div>
                        <div class="w-full mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg font-medium leading-6 text-gray-900">Revogar Cartão</h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">Informe o motivo da revogação do cartão. Esta ação não pode ser desfeita.</p>
                                <div class="mt-4">
                                    <label for="revoked_reason" class="block text-sm font-medium text-gray-700">Motivo da Revogação</label>
                                    <textarea name="revoked_reason" id="revoked_reason" rows="3" required placeholder="Ex: Cartão perdido, colaborador desligado, etc."
                                              class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500 sm:text-sm"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="px-4 py-3 bg-gray-50 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="submit" class="inline-flex justify-center w-full px-4 py-2 text-base font-medium text-white bg-red-600 border border-transparent rounded-md shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Revogar Cartão
                    </button>
                    <button type="button" onclick="closeRevokeModal()" class="inline-flex justify-center w-full px-4 py-2 mt-3 text-base font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Cancelar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
function openRevokeModal(cardId) {
    document.getElementById('revokeForm').action = `/admin/cards/${cardId}/revoke`;
    document.getElementById('revokeModal').classList.remove('hidden');
}

function closeRevokeModal() {
    document.getElementById('revokeModal').classList.add('hidden');
    document.getElementById('revoked_reason').value = '';
}

// Close modal when clicking outside
document.getElementById('revokeModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeRevokeModal();
    }
});
</script>
@endpush
@endsection


