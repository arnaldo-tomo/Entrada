@extends('layouts.admin')

@section('title', 'Editar Template - ' . $cardTemplate->name)

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="overflow-hidden bg-white rounded-lg shadow-sm">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Editar Template</h2>
                    <p class="text-gray-600">Atualize o template "{{ $cardTemplate->name }}"</p>
                </div>
                <a href="{{ route('admin.card-templates.show', $cardTemplate) }}" class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase bg-gray-600 border border-transparent rounded-md hover:bg-gray-700">
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
        <form action="{{ route('admin.card-templates.update', $cardTemplate) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="p-6 space-y-6">
                <!-- Preview Atual -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Preview Atual</label>
                    <div class="grid grid-cols-1 gap-4 mt-2 md:grid-cols-2">
                        <!-- Frente Atual -->
                        <div class="text-center">
                            <p class="mb-2 text-sm text-gray-500">Frente</p>
                            <div class="relative mx-auto" style="width: 200px; height: 125px;">
                                @if($cardTemplate->front_design_url)
                                    <img src="{{ $cardTemplate->front_design_url }}" class="object-cover w-full h-full border border-gray-300 rounded-lg">
                                @else
                                    <div class="flex items-center justify-center w-full h-full text-white border border-gray-300 rounded-lg bg-gradient-to-br from-blue-600 to-blue-800">
                                        <span class="text-xs">Design Padrão</span>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Verso Atual -->
                        <div class="text-center">
                            <p class="mb-2 text-sm text-gray-500">Verso</p>
                            <div class="relative mx-auto" style="width: 200px; height: 125px;">
                                @if($cardTemplate->back_design_url)
                                    <img src="{{ $cardTemplate->back_design_url }}" class="object-cover w-full h-full border border-gray-300 rounded-lg">
                                @else
                                    <div class="flex items-center justify-center w-full h-full text-white border border-gray-300 rounded-lg bg-gradient-to-br from-gray-600 to-gray-800">
                                        <span class="text-xs">Design Padrão</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Nome do Template -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Nome do Template *</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $cardTemplate->name) }}" required
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500 sm:text-sm @error('name') border-red-300 @enderror">
                    @error('name')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Dimensões -->
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <div>
                        <label for="width" class="block text-sm font-medium text-gray-700">Largura (mm) *</label>
                        <input type="number" name="width" id="width" value="{{ old('width', $cardTemplate->width) }}" step="0.01" min="50" max="200" required
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500 sm:text-sm @error('width') border-red-300 @enderror">
                        @error('width')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="height" class="block text-sm font-medium text-gray-700">Altura (mm) *</label>
                        <input type="number" name="height" id="height" value="{{ old('height', $cardTemplate->height) }}" step="0.01" min="30" max="150" required
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500 sm:text-sm @error('height') border-red-300 @enderror">
                        @error('height')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Status -->
                <div>
                    <label for="is_active" class="block text-sm font-medium text-gray-700">Status</label>
                    <select name="is_active" id="is_active" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500 sm:text-sm">
                        <option value="1" {{ old('is_active', $cardTemplate->is_active) ? 'selected' : '' }}>Ativo</option>
                        <option value="0" {{ old('is_active', $cardTemplate->is_active) == false ? 'selected' : '' }}>Inativo</option>
                    </select>
                </div>

                <!-- Atualizar Design da Frente -->
                <div>
                    <label for="front_design" class="block text-sm font-medium text-gray-700">Atualizar Design da Frente</label>
                    <div class="flex justify-center px-6 pt-5 pb-6 mt-1 transition-colors border-2 border-gray-300 border-dashed rounded-md hover:border-gray-400">
                        <div class="space-y-1 text-center">
                            <svg class="w-12 h-12 mx-auto text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="flex text-sm text-gray-600">
                                <label for="front_design" class="relative font-medium text-purple-600 bg-white rounded-md cursor-pointer hover:text-purple-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-purple-500">
                                    <span>Novo design da frente</span>
                                    <input id="front_design" name="front_design" type="file" accept="image/*" class="sr-only">
                                </label>
                                <p class="pl-1">ou arrastar e soltar</p>
                            </div>
                            <p class="text-xs text-gray-500">PNG, JPG até 5MB</p>
                            <p class="text-xs text-gray-400">Deixe em branco para manter o design atual</p>
                        </div>
                    </div>
                    @error('front_design')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Atualizar Design do Verso -->
                <div>
                    <label for="back_design" class="block text-sm font-medium text-gray-700">Atualizar Design do Verso</label>
                    <div class="flex justify-center px-6 pt-5 pb-6 mt-1 transition-colors border-2 border-gray-300 border-dashed rounded-md hover:border-gray-400">
                        <div class="space-y-1 text-center">
                            <svg class="w-12 h-12 mx-auto text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="flex text-sm text-gray-600">
                                <label for="back_design" class="relative font-medium text-purple-600 bg-white rounded-md cursor-pointer hover:text-purple-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-purple-500">
                                    <span>Novo design do verso</span>
                                    <input id="back_design" name="back_design" type="file" accept="image/*" class="sr-only">
                                </label>
                                <p class="pl-1">ou arrastar e soltar</p>
                            </div>
                            <p class="text-xs text-gray-500">PNG, JPG até 5MB</p>
                            <p class="text-xs text-gray-400">Deixe em branco para manter o design atual</p>
                        </div>
                    </div>
                    @error('back_design')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex justify-end px-6 py-4 space-x-3 border-t border-gray-200 bg-gray-50">
                <a href="{{ route('admin.card-templates.show', $cardTemplate) }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                    Cancelar
                </a>
                <button type="submit" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-purple-600 border border-transparent rounded-md shadow-sm hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Salvar Alterações
                </button>
            </div>
        </form>
    </div>

    <!-- Template Impact -->
    @if($cardTemplate->cards->count() > 0)
        <div class="p-6 border border-yellow-200 rounded-lg bg-yellow-50">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-yellow-800">Atenção</h3>
                    <p class="mt-1 text-sm text-yellow-700">
                        Este template possui {{ $cardTemplate->cards->count() }} cartão(s) emitido(s).
                        Alterações nas dimensões podem afetar a impressão de cartões já criados.
                    </p>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
