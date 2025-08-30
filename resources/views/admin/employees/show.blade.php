@extends('layouts.admin')

@section('title', 'Colaborador - ' . $employee->name)

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="overflow-hidden bg-white rounded-lg shadow-sm">
        <div class="p-6 border-b border-gray-200">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Detalhes do Colaborador</h2>
                    <p class="text-gray-600">Informações completas e histórico de cartões</p>
                </div>
                <div class="flex mt-4 space-x-3 lg:mt-0">
                    <a href="{{ route('admin.cards.create', ['employee_id' => $employee->id]) }}" class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-green-600 border border-transparent rounded-md hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V4a2 2 0 114 0v2m-4 0a2 2 0 104 0m-4 0a2 2 0 014 0z"></path>
                        </svg>
                        Emitir Cartão
                    </a>
                    <a href="{{ route('admin.employees.edit', $employee) }}" class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-blue-600 border border-transparent rounded-md hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Editar
                    </a>
                    <a href="{{ route('admin.employees.index') }}" class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-gray-600 border border-transparent rounded-md hover:bg-gray-700">
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
        <!-- Employee Information -->
        <div class="lg:col-span-2">
            <div class="overflow-hidden bg-white rounded-lg shadow-sm">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">Informações Pessoais</h3>
                </div>
                <div class="px-6 py-4">
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <div class="flex items-center space-x-4 sm:col-span-2">
                            <div class="flex-shrink-0">
                                <img class="object-cover w-20 h-20 border-4 border-gray-200 rounded-full" src="{{ $employee->photo_url }}" alt="{{ $employee->name }}">
                            </div>
                            <div>
                                <h4 class="text-xl font-semibold text-gray-900">{{ $employee->name }}</h4>
                                <p class="text-sm text-gray-600">{{ $employee->position }}</p>
                                <p class="text-sm text-gray-500">{{ $employee->department }}</p>
                                <div class="mt-2">
                                    <span class="inline-flex px-2 text-xs font-semibold leading-5 rounded-full {{ $employee->status === 'active' ? 'text-green-800 bg-green-100' : 'text-red-800 bg-red-100' }}">
                                        {{ $employee->status === 'active' ? 'Ativo' : 'Inativo' }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500">Nº de Identificação</dt>
                            <dd class="mt-1 font-mono text-sm text-gray-900">{{ $employee->identification_number }}</dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500">Email</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                <a href="mailto:{{ $employee->email }}" class="text-blue-600 hover:text-blue-500">{{ $employee->email }}</a>
                            </dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500">Telefone</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                @if($employee->phone)
                                    <a href="tel:{{ $employee->phone }}" class="text-blue-600 hover:text-blue-500">{{ $employee->phone }}</a>
                                @else
                                    <span class="text-gray-400">Não informado</span>
                                @endif
                            </dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500">Cadastrado em</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $employee->created_at->format('d/m/Y H:i') }}</dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500">Última atualização</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $employee->updated_at->format('d/m/Y H:i') }}</dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500">Total de cartões</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $employee->cards->count() }} cartão(s)</dd>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="space-y-6">
            <!-- Current Card -->
            @if($employee->activeCard())
                <div class="overflow-hidden bg-white rounded-lg shadow-sm">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Cartão Atual</h3>
                    </div>
                    <div class="px-6 py-4">
                        @php $activeCard = $employee->activeCard() @endphp
                        <div class="space-y-3">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Nº de Série</dt>
                                <dd class="mt-1 font-mono text-sm text-gray-900">{{ $activeCard->serial_number }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Template</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $activeCard->cardTemplate->name }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Validade</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $activeCard->expiry_date->format('d/m/Y') }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Status</dt>
                                <dd class="mt-1">
                                    <span class="inline-flex px-2 text-xs font-semibold leading-5 rounded-full {{ $activeCard->isValid() ? 'text-green-800 bg-green-100' : ($activeCard->isExpired() ? 'text-yellow-800 bg-yellow-100' : 'text-red-800 bg-red-100') }}">
                                        @if($activeCard->isValid()) Válido
                                        @elseif($activeCard->isExpired()) Expirado
                                        @else Revogado @endif
                                    </span>
                                </dd>
                            </div>
                            <div class="pt-3">
                                <a href="{{ route('admin.cards.show', $activeCard) }}" class="inline-flex items-center w-full px-3 py-2 text-xs font-medium text-center text-blue-700 bg-blue-100 rounded-lg hover:bg-blue-200 focus:ring-4 focus:outline-none focus:ring-blue-300">
                                    Ver Cartão
                                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="overflow-hidden bg-white rounded-lg shadow-sm">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Cartão Atual</h3>
                    </div>
                    <div class="px-6 py-4 text-center">
                        <svg class="w-12 h-12 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V4a2 2 0 114 0v2m-4 0a2 2 0 104 0m-4 0a2 2 0 014 0z"></path>
                        </svg>
                        <p class="mt-2 text-sm text-gray-500">Nenhum cartão ativo</p>
                        <div class="mt-3">
                            <a href="{{ route('admin.cards.create', ['employee_id' => $employee->id]) }}" class="inline-flex items-center px-3 py-2 text-xs font-medium text-white bg-green-600 rounded-lg hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-green-300">
                                Emitir Cartão
                            </a>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Quick Stats -->
            <div class="overflow-hidden bg-white rounded-lg shadow-sm">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">Estatísticas</h3>
                </div>
                <div class="px-6 py-4">
                    <dl class="space-y-3">
                        <div class="flex justify-between">
                            <dt class="text-sm font-medium text-gray-500">Cartões ativos</dt>
                            <dd class="text-sm text-gray-900">{{ $employee->cards->where('status', 'active')->count() }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-sm font-medium text-gray-500">Cartões expirados</dt>
                            <dd class="text-sm text-gray-900">{{ $employee->cards->where('status', 'expired')->count() }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-sm font-medium text-gray-500">Cartões revogados</dt>
                            <dd class="text-sm text-gray-900">{{ $employee->cards->where('status', 'revoked')->count() }}</dd>
                        </div>
                        <div class="flex justify-between pt-3 border-t border-gray-200">
                            <dt class="text-sm font-medium text-gray-900">Total de cartões</dt>
                            <dd class="text-sm font-semibold text-gray-900">{{ $employee->cards->count() }}</dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <!-- Cards History -->
    @if($employee->cards->count() > 0)
        <div class="overflow-hidden bg-white rounded-lg shadow-sm">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium leading-6 text-gray-900">Histórico de Cartões</h3>
                <p class="mt-1 text-sm text-gray-600">Todos os cartões emitidos para este colaborador</p>
            </div>
            <div class="overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Nº Série</th>
                            <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Template</th>
                            <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Status</th>
                            <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Emitido</th>
                            <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Validade</th>
                            <th class="relative px-6 py-3"><span class="sr-only">Ações</span></th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($employee->cards->sortByDesc('created_at') as $card)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 font-mono text-sm text-gray-900 whitespace-nowrap">{{ $card->serial_number }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">{{ $card->cardTemplate->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex px-2 text-xs font-semibold leading-5 rounded-full
                                        @if($card->status === 'active') bg-green-100 text-green-800
                                        @elseif($card->status === 'expired' || $card->isExpired()) bg-yellow-100 text-yellow-800
                                        @else bg-red-100 text-red-800 @endif">
                                        @if($card->isExpired() && $card->status !== 'revoked') Expirado
                                        @else {{ ucfirst($card->status) }} @endif
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">{{ $card->issued_date->format('d/m/Y') }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">{{ $card->expiry_date->format('d/m/Y') }}</td>
                                <td class="px-6 py-4 text-sm font-medium text-right whitespace-nowrap">
                                    <div class="flex justify-end space-x-2">
                                        <a href="{{ route('admin.cards.show', $card) }}" class="text-blue-600 hover:text-blue-900">Ver</a>
                                        <a href="{{ route('admin.cards.preview', $card) }}" class="text-indigo-600 hover:text-indigo-900">Preview</a>
                                        @if($card->status === 'active')
                                            <a href="{{ route('admin.cards.export', [$card, 'pdf']) }}" class="text-green-600 hover:text-green-900">PDF</a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>
@endsection
