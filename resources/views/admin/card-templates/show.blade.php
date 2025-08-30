@extends('layouts.admin')

@section('title', 'Template - ' . $template->name)

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="overflow-hidden bg-white rounded-lg shadow-sm">
        <div class="p-6 border-b border-gray-200">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">{{ $template->name }}</h2>
                    <p class="text-gray-600">Detalhes e preview do template de cartão</p>
                </div>
                <div class="flex mt-4 space-x-3 lg:mt-0">
                    <a href="{{ route('admin.card-templates.edit', $template) }}" class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-blue-600 border border-transparent rounded-md hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Editar
                    </a>
                    <a href="{{ route('admin.card-templates.index') }}" class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-gray-600 border border-transparent rounded-md hover:bg-gray-700">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Voltar
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
        <!-- Template Preview -->
        <div class="lg:col-span-2">
            <div class="overflow-hidden bg-white rounded-lg shadow-sm">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">Preview do Template</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 gap-8 md:grid-cols-2">
                        <!-- Front Design -->
                        <div class="text-center">
                            <h4 class="mb-4 text-sm font-medium text-gray-900">Frente do Cartão</h4>
                            <div class="relative mx-auto bg-white border border-gray-300 rounded-lg shadow-lg" style="width: 340px; height: 215px;">
                                @if($template->front_design_url)
                                    <img src="{{ $template->front_design_url }}"
                                         class="object-cover w-full h-full rounded-lg"
                                         alt="Frente do template {{ $template->name }}">
                                @else
                                    <div class="flex items-center justify-center w-full h-full text-white rounded-lg bg-gradient-to-br from-blue-600 to-blue-800">
                                        <div class="text-center">
                                            <svg class="w-8 h-8 mx-auto mb-2 opacity-75" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V4a2 2 0 114 0v2m-4 0a2 2 0 104 0m-4 0a2 2 0 014 0z"></path>
                                            </svg>
                                            <p class="text-sm font-medium">{{ $template->name }}</p>
                                            <p class="text-xs opacity-75">Design Padrão</p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Back Design -->
                        <div class="text-center">
                            <h4 class="mb-4 text-sm font-medium text-gray-900">Verso do Cartão</h4>
                            <div class="relative mx-auto bg-white border border-gray-300 rounded-lg shadow-lg" style="width: 340px; height: 215px;">
                                @if($template->back_design_url)
                                    <img src="{{ $template->back_design_url }}"
                                         class="object-cover w-full h-full rounded-lg"
                                         alt="Verso do template {{ $template->name }}">
                                @else
                                    <div class="flex items-center justify-center w-full h-full text-white rounded-lg bg-gradient-to-br from-gray-600 to-gray-800">
                                        <div class="text-center">
                                            <svg class="w-8 h-8 mx-auto mb-2 opacity-75" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V4a2 2 0 114 0v2m-4 0a2 2 0 104 0m-4 0a2 2 0 014 0z"></path>
                                            </svg>
                                            <p class="text-sm font-medium">Verso</p>
                                            <p class="text-xs opacity-75">Design Padrão</p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Template Info -->
        <div class="space-y-6">
            <!-- Details -->
            <div class="overflow-hidden bg-white rounded-lg shadow-sm">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">Detalhes</h3>
                </div>
                <div class="px-6 py-4">
                    <dl class="space-y-3">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Nome</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $template->name }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Dimensões</dt>
                            <dd class="mt-1 font-mono text-sm text-gray-900">{{ $template->width }}mm × {{ $template->height }}mm</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Status</dt>
                            <dd class="mt-1">
                                <span class="inline-flex px-2 text-xs font-semibold leading-5 rounded-full {{ $template->is_active ? 'text-green-800 bg-green-100' : 'text-gray-800 bg-gray-100' }}">
                                    {{ $template->is_active ? 'Ativo' : 'Inativo' }}
                                </span>
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Criado em</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $template->created_at->format('d/m/Y H:i') }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Atualizado em</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $template->updated_at->format('d/m/Y H:i') }}</dd>
                        </div>
                    </dl>
                </div>
            </div>

            <!-- Usage Stats -->
            <div class="overflow-hidden bg-white rounded-lg shadow-sm">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">Estatísticas de Uso</h3>
                </div>
                <div class="px-6 py-4">
                    <dl class="space-y-3">
                        <div class="flex justify-between">
                            <dt class="text-sm font-medium text-gray-500">Total de cartões:</dt>
                            <dd class="text-sm text-gray-900">{{ $template->cards->count() }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-sm font-medium text-gray-500">Cartões ativos:</dt>
                            <dd class="text-sm text-gray-900">{{ $template->cards->where('status', 'active')->count() }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-sm font-medium text-gray-500">Cartões expirados:</dt>
                            <dd class="text-sm text-gray-900">{{ $template->cards->where('status', 'expired')->count() }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-sm font-medium text-gray-500">Cartões revogados:</dt>
                            <dd class="text-sm text-gray-900">{{ $template->cards->where('status', 'revoked')->count() }}</dd>
                        </div>
                    </dl>

                    @if($template->cards->count() > 0)
                        <div class="pt-4 mt-4 border-t border-gray-200">
                            <p class="text-xs text-gray-500">Último cartão emitido: {{ $template->cards->latest()->first()->created_at->format('d/m/Y') }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Actions -->
            <div class="overflow-hidden bg-white rounded-lg shadow-sm">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">Ações</h3>
                </div>
                <div class="px-6 py-4 space-y-3">
                    <a href="{{ route('admin.cards.create') }}?template={{ $template->id }}" class="inline-flex items-center w-full px-3 py-2 text-sm font-medium text-center text-green-700 bg-green-100 rounded-lg hover:bg-green-200 focus:ring-4 focus:outline-none focus:ring-green-300">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Emitir Cartão
                    </a>

                    <a href="{{ route('admin.card-templates.edit', $template) }}" class="inline-flex items-center w-full px-3 py-2 text-sm font-medium text-center text-blue-700 bg-blue-100 rounded-lg hover:bg-blue-200 focus:ring-4 focus:outline-none focus:ring-blue-300">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Editar Template
                    </a>

                    @if($template->cards->count() == 0)
                        <form action="{{ route('admin.card-templates.destroy', $template) }}" method="POST" class="w-full">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Tem certeza que deseja excluir este template?')" class="inline-flex items-center w-full px-3 py-2 text-sm font-medium text-center text-red-700 bg-red-100 rounded-lg hover:bg-red-200 focus:ring-4 focus:outline-none focus:ring-red-300">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                                Excluir Template
                            </button>
                        </form>
                    @else
                        <div class="p-3 text-sm text-yellow-700 bg-yellow-100 rounded-lg">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                </svg>
                                Não é possível excluir este template pois possui cartões emitidos.
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
