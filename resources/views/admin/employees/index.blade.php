@extends('layouts.admin')

@section('title', 'Colaboradores')

@section('content')
<div class="space-y-6">
    <!-- Header with Search and Filters -->
    <div class="overflow-hidden bg-white rounded-lg shadow-sm">
        <div class="p-6 border-b border-gray-200">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Colaboradores</h2>
                    <p class="text-gray-600">Gerencie todos os colaboradores da empresa</p>
                </div>
                <div class="mt-4 lg:mt-0">
                    <a href="{{ route('admin.employees.create') }}" class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-blue-600 border border-transparent rounded-md hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Novo Colaborador
                    </a>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="p-6 bg-gray-50">
            <form method="GET" class="grid grid-cols-1 gap-4 md:grid-cols-4">
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700">Buscar</label>
                    <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Nome, ID, email..."
                           class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                </div>
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                    <select name="status" id="status" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        <option value="">Todos</option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Ativo</option>
                        <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inativo</option>
                    </select>
                </div>
                <div>
                    <label for="department" class="block text-sm font-medium text-gray-700">Departamento</label>
                    <select name="department" id="department" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        <option value="">Todos</option>
                        @foreach($departments as $dept)
                            <option value="{{ $dept }}" {{ request('department') === $dept ? 'selected' : '' }}>{{ $dept }}</option>
                        @endforeach
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

    <!-- Employees Table -->
    <div class="overflow-hidden bg-white rounded-lg shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Colaborador</th>
                        <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Identificação</th>
                        <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Departamento</th>
                        <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Cargo</th>
                        <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Cartões</th>
                        <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Status</th>
                        <th class="relative px-6 py-3"><span class="sr-only">Ações</span></th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($employees as $employee)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 w-10 h-10">
                                        <img class="object-cover w-10 h-10 rounded-full" src="{{ $employee->photo_url }}" alt="{{ $employee->name }}">
                                    </div>
                                    <div class="ml-3">
                            <h3 class="text-lg font-medium text-red-800">Cartão Não Encontrado</h3>
                            <p class="text-sm text-red-600">O código QR escaneado não é válido ou não existe no sistema</p>
                        </div>
                    </div>
                </div>

                <div class="px-6 py-8 text-center">
                    <svg class="w-16 h-16 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <h3 class="mt-4 text-lg font-medium text-gray-900">Código Inválido</h3>
                    <p class="mt-2 text-sm text-gray-500">
                        O código QR que você escaneou não corresponde a nenhum cartão válido em nosso sistema.
                    </p>

                    <div class="mt-6">
                        <p class="text-xs text-gray-600">Possíveis motivos:</p>
                        <ul class="mt-2 space-y-1 text-xs text-gray-500">
                            <li>• O cartão foi revogado ou cancelado</li>
                            <li>• O código QR está danificado</li>
                            <li>• O cartão não foi emitido por este sistema</li>
                        </ul>
                    </div>
                </div>

                <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                    <div class="text-center">
                        <p class="text-xs text-gray-500">
                            Verificado em {{ now()->format('d/m/Y H:i:s') }}
                        </p>
                        <p class="mt-1 text-xs text-gray-400">
                            Em caso de dúvidas, entre em contato com o departamento responsável
                        </p>
                    </div>
                </div>
            </div>

            <!-- Security Notice -->
            <div class="p-6 bg-white rounded-lg shadow">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-gray-900">Alerta de Segurança</h3>
                        <p class="mt-1 text-sm text-gray-600">
                            Se você acredita que este cartão deveria ser válido, reporte imediatamente à segurança.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

