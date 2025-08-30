@extends('layouts.admin')

@section('title', 'Templates de Cartão')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="overflow-hidden bg-white rounded-lg shadow-sm">
        <div class="p-6 border-b border-gray-200">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Templates de Cartão</h2>
                    <p class="text-gray-600">Gerencie os modelos de design dos cartões</p>
                </div>
                <div class="mt-4 lg:mt-0">
                    <a href="{{ route('admin.card-templates.create') }}" class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-purple-600 border border-transparent rounded-md hover:bg-purple-700 focus:bg-purple-700 active:bg-purple-900 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Novo Template
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Templates Grid -->
    <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
        @forelse($templates as $template)
            <div class="overflow-hidden transition-shadow bg-white rounded-lg shadow-sm hover:shadow-md">
                <!-- Template Preview -->
                <div class="p-4 bg-gray-50">
                    <div class="relative mx-auto" style="width: 240px; height: 150px;">
                        @if($template->front_design_url)
                            <img src="{{ $template->front_design_url }}"
                                 class="object-cover w-full h-full border border-gray-300 rounded-lg shadow-sm"
                                 alt="Preview de {{ $template->name }}">
                        @else
                            <div class="flex items-center justify-center w-full h-full text-white border border-gray-300 rounded-lg shadow-sm bg-gradient-to-br from-blue-600 to-blue-800">
                                <div class="text-center">
                                    <svg class="w-8 h-8 mx-auto mb-2 opacity-75" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V4a2 2 0 114 0v2m-4 0a2 2 0 104 0m-4 0a2 2 0 014 0z"></path>
                                    </svg>
                                    <p class="text-sm font-medium">{{ $template->name }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Template Info -->
                <div class="p-6">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-lg font-semibold text-gray-900 truncate">{{ $template->name }}</h3>
                        <span class="inline-flex px-2 text-xs font-semibold leading-5 rounded-full {{ $template->is_active ? 'text-green-800 bg-green-100' : 'text-gray-800 bg-gray-100' }}">
                            {{ $template->is_active ? 'Ativo' : 'Inativo' }}
                        </span>
                    </div>

                    <div class="space-y-2 text-sm text-gray-600">
                        <div class="flex justify-between">
                            <span>Dimensões:</span>
                            <span class="font-mono">{{ $template->width }}mm × {{ $template->height }}mm</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Cartões emitidos:</span>
                            <span>{{ $template->cards->count() }} cartão(s)</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Criado em:</span>
                            <span>{{ $template->created_at->format('d/m/Y') }}</span>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex justify-between pt-4 mt-4 border-t border-gray-200">
                        <div class="flex space-x-2">
                            <a href="{{ route('admin.card-templates.show', $template) }}" class="text-sm font-medium text-blue-600 hover:text-blue-900">Ver</a>
                            <a href="{{ route('admin.card-templates.edit', $template) }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-900">Editar</a>
                        </div>
                        @if($template->cards->count() == 0)
                            <form action="{{ route('admin.card-templates.destroy', $template) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Tem certeza que deseja excluir este template?')" class="text-sm font-medium text-red-600 hover:text-red-900">Excluir</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="md:col-span-2 lg:col-span-3">
                <div class="py-12 text-center">
                    <svg class="w-12 h-12 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zM21 5a2 2 0 00-2-2h-4a2 2 0 00-2 2v12a4 4 0 004 4h4a2 2 0 002-2V5z"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Nenhum template encontrado</h3>
                    <p class="mt-1 text-sm text-gray-500">Comece criando seu primeiro template de cartão.</p>
                    <div class="mt-6">
                        <a href="{{ route('admin.card-templates.create') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-purple-600 border border-transparent rounded-md shadow-sm hover:bg-purple-700">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Novo Template
                        </a>
                    </div>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($templates->hasPages())
        <div class="flex justify-center">
            {{ $templates->links() }}
        </div>
    @endif
</div>
@endsection
