@extends('layouts.admin')

@section('title', 'Emitir Novo Cartão')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="overflow-hidden bg-white rounded-lg shadow-sm">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Emitir Novo Cartão</h2>
                    <p class="text-gray-600">Selecione o colaborador e o template para emitir um cartão</p>
                </div>
                <a href="{{ route('admin.cards.index') }}" class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase bg-gray-600 border border-transparent rounded-md hover:bg-gray-700">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Voltar
                </a>
            </div>
        </div>
    </div>

    <!-- Form -->
    <div class="overflow-hidden bg-white rounded-lg shadow-sm">
        <form action="{{ route('admin.cards.store') }}" method="POST" x-data="{ selectedEmployee: null, selectedTemplate: null }">
            @csrf
            <div class="p-6 space-y-8">

                <!-- Employee Selection -->
                <div>
                    <label for="employee_id" class="block mb-4 text-sm font-medium text-gray-700">
                        Selecionar Colaborador *
                    </label>
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                        @foreach($employees as $employee)
                            <div class="relative">
                                <input type="radio" name="employee_id" id="employee_{{ $employee->id }}"
                                       value="{{ $employee->id }}" class="sr-only peer"
                                       x-model="selectedEmployee" @error('employee_id') required @enderror>
                                <label for="employee_{{ $employee->id }}"
                                       class="flex items-center p-4 transition-all border-2 border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 peer-checked:border-blue-500 peer-checked:bg-blue-50">
                                    <div class="flex-shrink-0">
                                        <img class="object-cover w-12 h-12 rounded-full"
                                             src="{{ $employee->photo_url }}" alt="{{ $employee->name }}">
                                    </div>
                                    <div class="flex-1 min-w-0 ml-4">
                                        <div class="text-sm font-medium text-gray-900 truncate">{{ $employee->name }}</div>
                                        <div class="text-sm text-gray-500 truncate">{{ $employee->department }}</div>
                                        <div class="text-xs text-gray-400 truncate">{{ $employee->position }}</div>
                                        @if($employee->activeCard())
                                            <div class="mt-1">
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-yellow-100 text-yellow-800">
                                                    Possui cartão ativo
                                                </span>
                                            </div>
                                        @endif
                                    </div>
                                </label>
                            </div>
                        @endforeach
                    </div>
                    @error('employee_id')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Template Selection -->
                <div>
                    <label for="card_template_id" class="block mb-4 text-sm font-medium text-gray-700">
                        Selecionar Template *
                    </label>
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
                        @foreach($templates as $template)
                            <div class="relative">
                                <input type="radio" name="card_template_id" id="template_{{ $template->id }}"
                                       value="{{ $template->id }}" class="sr-only peer"
                                       x-model="selectedTemplate" @error('card_template_id') required @enderror>
                                <label for="template_{{ $template->id }}"
                                       class="block p-4 transition-all border-2 border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 peer-checked:border-blue-500 peer-checked:bg-blue-50">

                                    <!-- Template Preview -->
                                    <div class="mb-3 aspect-w-16 aspect-h-10">
                                        @if($template->front_design_url)
                                            <img src="{{ $template->front_design_url }}"
                                                 class="object-cover w-full h-24 border rounded">
                                        @else
                                            <div class="flex items-center justify-center w-full h-24 border rounded bg-gradient-to-br from-blue-600 to-blue-800">
                                                <span class="text-sm font-medium text-white">{{ $template->name }}</span>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="text-sm font-medium text-gray-900">{{ $template->name }}</div>
                                    <div class="text-xs text-gray-500">{{ $template->width }}mm × {{ $template->height }}mm</div>
                                    <div class="mt-1 text-xs text-gray-400">{{ $template->cards->count() }} cartão(s) emitido(s)</div>
                                </label>
                            </div>
                        @endforeach
                    </div>
                    @error('card_template_id')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Expiry Date -->
                <div>
                    <label for="expiry_date" class="block text-sm font-medium text-gray-700">Data de Expiração *</label>
                    <div class="relative mt-1">
                        <input type="date" name="expiry_date" id="expiry_date"
                               value="{{ old('expiry_date', now()->addYear()->format('Y-m-d')) }}"
                               min="{{ now()->addDay()->format('Y-m-d') }}" required
                               class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('expiry_date') border-red-300 @enderror">
                    </div>
                    <p class="mt-1 text-sm text-gray-500">O cartão expirará automaticamente nesta data</p>
                    @error('expiry_date')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Warning for Active Card -->
                <div x-show="selectedEmployee" x-transition class="p-4 border border-yellow-200 rounded-md bg-yellow-50">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="w-5 h-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-yellow-800">Atenção</h3>
                            <p class="mt-1 text-sm text-yellow-700">
                                Se o colaborador já possui um cartão ativo, ele será automaticamente revogado e substituído pelo novo cartão.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-end px-6 py-4 space-x-3 border-t border-gray-200 bg-gray-50">
                <a href="{{ route('admin.cards.index') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Cancelar
                </a>
                <button type="submit" class="inline-flex items-center px-6 py-3 text-sm font-medium text-white bg-green-600 border border-transparent rounded-md shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V4a2 2 0 114 0v2m-4 0a2 2 0 104 0m-4 0a2 2 0 014 0z"></path>
                    </svg>
                    Emitir Cartão
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
