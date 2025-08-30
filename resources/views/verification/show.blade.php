<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Verificação de Cartão - {{ $card->employee->name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
</head>
<body class="min-h-screen font-sans bg-gradient-to-br from-blue-50 to-indigo-100">
    <div class="flex items-center justify-center min-h-screen px-4 py-12 sm:px-6 lg:px-8">
        <div class="w-full max-w-md space-y-8">
            <!-- Header -->
            <div class="text-center">
                <h1 class="text-3xl font-extrabold text-gray-900">Verificação de Cartão</h1>
                <p class="mt-2 text-sm text-gray-600">Sistema de Identificação</p>
            </div>

            <!-- Card Verification Result -->
            <div class="overflow-hidden bg-white rounded-lg shadow-xl">
                @if($card->isValid())
                    <!-- Valid Card -->
                    <div class="px-6 py-4 border-b border-green-200 bg-green-50">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-lg font-medium text-green-800">Cartão Válido</h3>
                                <p class="text-sm text-green-600">Este cartão está ativo e válido</p>
                            </div>
                        </div>
                    </div>
                @elseif($card->status === 'expired' || $card->isExpired())
                    <!-- Expired Card -->
                    <div class="px-6 py-4 border-b border-yellow-200 bg-yellow-50">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-lg font-medium text-yellow-800">Cartão Expirado</h3>
                                <p class="text-sm text-yellow-600">Este cartão expirou em {{ $card->expiry_date->format('d/m/Y') }}</p>
                            </div>
                        </div>
                    </div>
                @else
                    <!-- Revoked Card -->
                    <div class="px-6 py-4 border-b border-red-200 bg-red-50">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636m12.728 12.728L18.364 5.636M5.636 18.364l12.728-12.728"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-lg font-medium text-red-800">Cartão Revogado</h3>
                                <p class="text-sm text-red-600">Este cartão foi revogado</p>
                                @if($card->revoked_reason)
                                    <p class="mt-1 text-xs text-red-500">Motivo: {{ $card->revoked_reason }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Employee Information -->
                <div class="px-6 py-6">
                    <div class="flex items-center space-x-4">
                        <div class="flex-shrink-0">
                            <img class="object-cover w-16 h-16 border-4 border-gray-200 rounded-full"
                                 src="{{ $card->employee->photo_url }}"
                                 alt="{{ $card->employee->name }}">
                        </div>
                        <div class="flex-1">
                            <h2 class="text-xl font-semibold text-gray-900">{{ $card->employee->name }}</h2>
                            <p class="text-sm text-gray-600">{{ $card->employee->position }}</p>
                            <p class="text-sm text-gray-500">{{ $card->employee->department }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mt-6">
                        <div>
                            <dt class="text-xs font-medium text-gray-500 uppercase">Nº Série</dt>
                            <dd class="mt-1 text-sm font-medium text-gray-900">{{ $card->serial_number }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-medium text-gray-500 uppercase">Status</dt>
                            <dd class="mt-1">
                                <span class="px-2 py-1 text-xs font-semibold rounded-full
                                    @if($card->isValid()) bg-green-100 text-green-800
                                    @elseif($card->isExpired()) bg-yellow-100 text-yellow-800
                                    @else bg-red-100 text-red-800 @endif">
                                    @if($card->isValid()) Válido
                                    @elseif($card->isExpired()) Expirado
                                    @else Revogado @endif
                                </span>
                            </dd>
                        </div>
                        <div>
                            <dt class="text-xs font-medium text-gray-500 uppercase">Emitido em</dt>
                            <dd class="mt-1 text-sm font-medium text-gray-900">{{ $card->issued_date->format('d/m/Y') }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-medium text-gray-500 uppercase">Valid até</dt>
                            <dd class="mt-1 text-sm font-medium text-gray-900">{{ $card->expiry_date->format('d/m/Y') }}</dd>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                    <div class="text-center">
                        <p class="text-xs text-gray-500">
                            Verificado em {{ now()->format('d/m/Y H:i:s') }}
                        </p>
                        <p class="mt-1 text-xs text-gray-400">
                            Este é um sistema oficial de verificação de cartões de identificação
                        </p>
                    </div>
                </div>
            </div>

            <!-- Security Notice -->
            <div class="p-6 bg-white rounded-lg shadow">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-gray-900">Aviso de Segurança</h3>
                        <p class="mt-1 text-sm text-gray-600">
                            Este código QR é único e intransferível. Qualquer uso indevido será reportado às autoridades competentes.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
