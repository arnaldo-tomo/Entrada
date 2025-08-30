@extends('layouts.admin')

@section('title', 'Novo Colaborador')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="overflow-hidden bg-white rounded-lg shadow-sm">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Novo Colaborador</h2>
                    <p class="text-gray-600">Cadastre um novo colaborador no sistema</p>
                </div>
                <a href="{{ route('admin.employees.index') }}" class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase bg-gray-600 border border-transparent rounded-md hover:bg-gray-700">
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
        <form action="{{ route('admin.employees.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="p-6 space-y-6">
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <!-- Nome -->
                    <div class="md:col-span-2">
                        <label for="name" class="block text-sm font-medium text-gray-700">Nome Completo *</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('name') border-red-300 @enderror">
                        @error('name')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Número de Identificação -->
                    <div>
                        <label for="identification_number" class="block text-sm font-medium text-gray-700">Nº de Identificação *</label>
                        <input type="text" name="identification_number" id="identification_number" value="{{ old('identification_number') }}" required
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('identification_number') border-red-300 @enderror">
                        @error('identification_number')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email *</label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('email') border-red-300 @enderror">
                        @error('email')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Departamento -->
                    <div>
                        <label for="department" class="block text-sm font-medium text-gray-700">Departamento *</label>
                        <input type="text" name="department" id="department" value="{{ old('department') }}" required
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('department') border-red-300 @enderror">
                        @error('department')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Cargo -->
                    <div>
                        <label for="position" class="block text-sm font-medium text-gray-700">Cargo *</label>
                        <input type="text" name="position" id="position" value="{{ old('position') }}" required
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('position') border-red-300 @enderror">
                        @error('position')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Telefone -->
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700">Telefone</label>
                        <input type="text" name="phone" id="phone" value="{{ old('phone') }}"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('phone') border-red-300 @enderror">
                        @error('phone')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700">Status *</label>
                        <select name="status" id="status" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('status') border-red-300 @enderror">
                            <option value="active" {{ old('status') === 'active' ? 'selected' : '' }}>Ativo</option>
                            <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Inativo</option>
                        </select>
                        @error('status')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Foto -->
                    <div class="md:col-span-2">
                        <label for="photo" class="block text-sm font-medium text-gray-700">Foto</label>
                        <div class="flex justify-center px-6 pt-5 pb-6 mt-1 transition-colors border-2 border-gray-300 border-dashed rounded-md hover:border-gray-400">
                            <div class="space-y-1 text-center">
                                <svg class="w-12 h-12 mx-auto text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-gray-600">
                                    <label for="photo" class="relative font-medium text-blue-600 bg-white rounded-md cursor-pointer hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                        <span>Carregar uma foto</span>
                                        <input id="photo" name="photo" type="file" accept="image/*" class="sr-only">
                                    </label>
                                    <p class="pl-1">ou arrastar e soltar</p>
                                </div>
                                <p class="text-xs text-gray-500">PNG, JPG até 2MB</p>
                            </div>
                        </div>
                        @error('photo')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="flex justify-end px-6 py-4 space-x-3 border-t border-gray-200 bg-gray-50">
                <a href="{{ route('admin.employees.index') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Cancelar
                </a>
                <button type="submit" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Salvar Colaborador
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
