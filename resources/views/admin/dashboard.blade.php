@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-2xl font-bold text-gray-800">Dashboard</h2>
            <p class="text-gray-600">Visão geral do sistema de cartões de identificação</p>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-4">
        <div class="overflow-hidden bg-white rounded-lg shadow-sm">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="flex items-center justify-center w-8 h-8 bg-blue-500 rounded-full">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="flex-1 w-0 ml-5">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Total Colaboradores</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $stats['total_employees'] }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="overflow-hidden bg-white rounded-lg shadow-sm">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="flex items-center justify-center w-8 h-8 bg-green-500 rounded-full">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="flex-1 w-0 ml-5">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Cartões Ativos</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $stats['active_cards'] }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="overflow-hidden bg-white rounded-lg shadow-sm">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="flex items-center justify-center w-8 h-8 bg-yellow-500 rounded-full">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="flex-1 w-0 ml-5">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Cartões Expirados</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $stats['expired_cards'] }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="overflow-hidden bg-white rounded-lg shadow-sm">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="flex items-center justify-center w-8 h-8 bg-red-500 rounded-full">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636m12.728 12.728L18.364 5.636M5.636 18.364l12.728-12.728"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="flex-1 w-0 ml-5">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Cartões Revogados</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $stats['revoked_cards'] }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="overflow-hidden bg-white rounded-lg shadow-sm">
        <div class="p-6">
            <h3 class="mb-4 text-lg font-medium text-gray-800">Ações Rápidas</h3>
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-4">
                <a href="{{ route('admin.employees.create') }}" class="inline-flex items-center justify-center px-4 py-3 text-sm font-medium text-white transition duration-150 ease-in-out bg-blue-600 border border-transparent rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Novo Colaborador
                </a>

                <a href="{{ route('admin.cards.create') }}" class="inline-flex items-center justify-center px-4 py-3 text-sm font-medium text-white transition duration-150 ease-in-out bg-green-600 border border-transparent rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V4a2 2 0 114 0v2m-4 0a2 2 0 104 0m-4 0a2 2 0 014 0z"></path>
                    </svg>
                    Emitir Cartão
                </a>

                <a href="{{ route('admin.card-templates.create') }}" class="inline-flex items-center justify-center px-4 py-3 text-sm font-medium text-white transition duration-150 ease-in-out bg-purple-600 border border-transparent rounded-md hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zM21 5a2 2 0 00-2-2h-4a2 2 0 00-2 2v12a4 4 0 004 4h4a2 2 0 002-2V5z"></path>
                    </svg>
                    Novo Template
                </a>

                <a href="{{ route('admin.reports.cards') }}" class="inline-flex items-center justify-center px-4 py-3 text-sm font-medium text-white transition duration-150 ease-in-out bg-gray-600 border border-transparent rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Relatórios
                </a>
            </div>
        </div>
    </div>

    <!-- Recent Cards -->
    <div class="overflow-hidden bg-white rounded-lg shadow-sm">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-medium text-gray-800">Cartões Recentes</h3>
                <a href="{{ route('admin.cards.index') }}" class="text-sm text-blue-600 hover:text-blue-500">Ver todos</a>
            </div>
        </div>
        <div class="overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Colaborador</th>
                        <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Nº Série</th>
                        <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Template</th>
                        <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Emitido</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($recent_cards as $card)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 w-8 h-8">
                                        <img class="object-cover w-8 h-8 rounded-full" src="{{ $card->employee->photo_url }}" alt="">
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $card->employee->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $card->employee->department }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap">{{ $card->serial_number }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">{{ $card->cardTemplate->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                    @if($card->status === 'active') bg-green-100 text-green-800
                                    @elseif($card->status === 'expired') bg-yellow-100 text-yellow-800
                                    @else bg-red-100 text-red-800 @endif">
                                    {{ ucfirst($card->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">{{ $card->created_at->format('d/m/Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-sm text-center text-gray-500 whitespace-nowrap">Nenhum cartão encontrado</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
