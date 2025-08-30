@extends('layouts.admin')

@section('title', 'Cartões')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="overflow-hidden bg-white rounded-lg shadow-sm">
        <div class="p-6 border-b border-gray-200">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Gestão de Cartões</h2>
                    <p class="text-gray-600">Visualize e gerencie todos os cartões emitidos</p>
                </div>
                <div class="mt-4 lg:mt-0">
                    <a href="{{ route('admin.cards.create') }}" class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-green-600 border border-transparent rounded-md hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Emitir Cartão
                    </a>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="p-6 bg-gray-50">
            <form method="GET" class="grid grid-cols-1 gap-4 md:grid-cols-3">
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700">Buscar</label>
                    <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Nome, nº série..."
                           class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                </div>
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                    <select name="status" id="status" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        <option value="">Todos</option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Ativo</option>
                        <option value="expired" {{ request('status') === 'expired' ? 'selected' : '' }}>Expirado</option>
                        <option value="revoked" {{ request('status') === 'revoked' ? 'selected' : '' }}>Revogado</option>
                    </select>
                </div>
                <div class="flex items-end">
                    <button type="submit" class="inline-flex items-center justify-center w-full px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-gray-600 border border-transparent rounded-md hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        Filtrar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Cards Table -->
    <div class="overflow-hidden bg-white rounded-lg shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Colaborador</th>
                        <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Nº Série</th>
                        <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Template</th>
                        <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Validade</th>
                        <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Emitido</th>
                        <th class="relative px-6 py-3"><span class="sr-only">Ações</span></th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($cards as $card)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 w-10 h-10">
                                        <img class="object-cover w-10 h-10 rounded-full" src="{{ $card->employee->photo_url }}" alt="{{ $card->employee->name }}">
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $card->employee->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $card->employee->department }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="font-mono text-sm text-gray-900">{{ $card->serial_number }}</div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">{{ $card->cardTemplate->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                    @if($card->status === 'active') bg-green-100 text-green-800
                                    @elseif($card->status === 'expired' || $card->isExpired()) bg-yellow-100 text-yellow-800
                                    @else bg-red-100 text-red-800 @endif">
                                    @if($card->isExpired() && $card->status !== 'revoked') Expirado
                                    @else {{ ucfirst($card->status) }} @endif
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">{{ $card->expiry_date->format('d/m/Y') }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">{{ $card->issued_date->format('d/m/Y') }}</td>
                            <td class="px-6 py-4 text-sm font-medium text-right whitespace-nowrap">
                                <div class="flex justify-end space-x-2">
                                    <a href="{{ route('admin.cards.show', $card) }}" class="text-blue-600 hover:text-blue-900">Ver</a>
                                    <a href="{{ route('admin.cards.preview', $card) }}" class="text-indigo-600 hover:text-indigo-900">Preview</a>
                                    <a href="{{ route('admin.cards.export', [$card, 'pdf']) }}" class="text-green-600 hover:text-green-900">PDF</a>
                                    @if($card->status === 'active')
                                        <button onclick="openRevokeModal({{ $card->id }})" class="text-red-600 hover:text-red-900">Revogar</button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <div class="text-gray-500">
                                    <svg class="w-12 h-12 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V4a2 2 0 114 0v2m-4 0a2 2 0 104 0m-4 0a2 2 0 014 0z"/>
                                    </svg>
                                    <h3 class="mt-2 text-sm font-medium text-gray-900">Nenhum cartão encontrado</h3>
                                    <p class="mt-1 text-sm text-gray-500">Comece emitindo um novo cartão.</p>
                                    <div class="mt-6">
                                        <a href="{{ route('admin.cards.create') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-green-600 border border-transparent rounded-md shadow-sm hover:bg-green-700">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                            </svg>
                                            Emitir Cartão
                                        </a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($cards->hasPages())
            <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                {{ $cards->links() }}
            </div>
        @endif
    </div>
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
</script>
@endpush
@endsection
