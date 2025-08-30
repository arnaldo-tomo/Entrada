@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="overflow-hidden bg-white rounded-lg shadow-sm">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-2xl font-bold text-gray-800">Bem-vindo ao Sistema de Cartões</h2>
            <p class="text-gray-600">Gerencie cartões de identificação da sua empresa</p>
        </div>
    </div>

    <!-- Quick Start -->
    <div class="overflow-hidden bg-white rounded-lg shadow-sm">
        <div class="p-6">
            <h3 class="mb-4 text-lg font-medium text-gray-800">Início Rápido</h3>
            <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                <div class="p-4 border border-gray-200 rounded-lg">
                    <div class="flex items-center mb-3">
                        <div class="flex items-center justify-center w-8 h-8 mr-3 bg-blue-100 rounded-full">
                            <span class="text-sm font-semibold text-blue-600">1</span>
                        </div>
                        <h4 class="font-medium text-gray-900">Cadastrar Colaboradores</h4>
                    </div>
                    <p class="mb-3 text-sm text-gray-600">Comece cadastrando os colaboradores que receberão cartões.</p>
                    <a href="{{ route('admin.employees.create') }}" class="inline-flex items-center text-sm font-medium text-blue-600 hover:text-blue-500">
                        Cadastrar colaborador
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>

                <div class="p-4 border border-gray-200 rounded-lg">
                    <div class="flex items-center mb-3">
                        <div class="flex items-center justify-center w-8 h-8 mr-3 bg-purple-100 rounded-full">
                            <span class="text-sm font-semibold text-purple-600">2</span>
                        </div>
                        <h4 class="font-medium text-gray-900">Criar Templates</h4>
                    </div>
                    <p class="mb-3 text-sm text-gray-600">Crie modelos de design para os cartões da empresa.</p>
                    <a href="{{ route('admin.card-templates.create') }}" class="inline-flex items-center text-sm font-medium text-purple-600 hover:text-purple-500">
                        Criar template
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>

                <div class="p-4 border border-gray-200 rounded-lg">
                    <div class="flex items-center mb-3">
                        <div class="flex items-center justify-center w-8 h-8 mr-3 bg-green-100 rounded-full">
                            <span class="text-sm font-semibold text-green-600">3</span>
                        </div>
                        <h4 class="font-medium text-gray-900">Emitir Cartões</h4>
                    </div>
                    <p class="mb-3 text-sm text-gray-600">Emita cartões de identificação para os colaboradores.</p>
                    <a href="{{ route('admin.cards.create') }}" class="inline-flex items-center text-sm font-medium text-green-600 hover:text-green-500">
                        Emitir cartão
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- System Info -->
    <div class="overflow-hidden bg-white rounded-lg shadow-sm">
        <div class="p-6">
            <h3 class="mb-4 text-lg font-medium text-gray-800">Informações do Sistema</h3>
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <div>
                    <h4 class="mb-2 font-medium text-gray-900">Estatísticas Gerais</h4>
                    <dl class="space-y-1 text-sm">
                        <div class="flex justify-between">
                            <dt class="text-gray-500">Colaboradores cadastrados:</dt>
                            <dd class="text-gray-900">{{ \App\Models\Employee::count() }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-gray-500">Templates disponíveis:</dt>
                            <dd class="text-gray-900">{{ \App\Models\CardTemplate::where('is_active', true)->count() }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-gray-500">Cartões emitidos:</dt>
                            <dd class="text-gray-900">{{ \App\Models\Card::count() }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-gray-500">Verificações realizadas:</dt>
                            <dd class="text-gray-900">{{ \App\Models\VerificationLog::count() }}</dd>
                        </div>
                    </dl>
                </div>

                <div>
                    <h4 class="mb-2 font-medium text-gray-900">Links Úteis</h4>
                    <div class="space-y-2 text-sm">
                        <a href="{{ route('admin.employees.index') }}" class="block text-blue-600 hover:text-blue-500">→ Gerenciar colaboradores</a>
                        <a href="{{ route('admin.card-templates.index') }}" class="block text-blue-600 hover:text-blue-500">→ Gerenciar templates</a>
                        <a href="{{ route('admin.cards.index') }}" class="block text-blue-600 hover:text-blue-500">→ Visualizar todos os cartões</a>
                        <a href="{{ route('profile.edit') }}" class="block text-blue-600 hover:text-blue-500">→ Configurações da conta</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
