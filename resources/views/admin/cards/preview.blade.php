@extends('layouts.admin')

@section('title', 'Preview do Cartão - ' . $card->employee->name)

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="overflow-hidden bg-white rounded-lg shadow-sm">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Preview do Cartão</h2>
                    <p class="text-gray-600">{{ $card->employee->name }} - {{ $card->serial_number }}</p>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('admin.cards.export', [$card, 'pdf']) }}" class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase bg-red-600 border border-transparent rounded-md hover:bg-red-700">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Baixar PDF
                    </a>
                    <a href="{{ route('admin.cards.show', $card) }}" class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase bg-gray-600 border border-transparent rounded-md hover:bg-gray-700">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Voltar
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Card Preview -->
    <div class="overflow-hidden bg-white rounded-lg shadow-sm">
        <div class="p-6">
            <div class="grid grid-cols-1 gap-8 lg:grid-cols-2">
                <!-- Card Front -->
                <div class="space-y-4">
                    <h3 class="text-lg font-medium text-gray-800">Frente do Cartão</h3>
                    <div class="relative overflow-hidden rounded-lg shadow-lg bg-gradient-to-br from-blue-600 to-blue-800"
                         style="width: 340px; height: 215px; margin: 0 auto;">

                        <!-- Background Design -->
                        @if($card->cardTemplate->front_design_url)
                            <img src="{{ $card->cardTemplate->front_design_url }}" class="absolute inset-0 object-cover w-full h-full">
                        @endif

                        <!-- Card Content -->
                        <div class="relative z-10 flex flex-col justify-between h-full p-4 text-white">
                            <div class="flex items-start justify-between">
                                <!-- Photo -->
                                <div class="flex-shrink-0">
                                    <img src="{{ $card->employee->photo_url }}"
                                         class="object-cover w-16 h-20 border-2 rounded border-white/30">
                                </div>

                                <!-- Company Logo Area -->
                                <div class="text-right">
                                    <div class="text-xs opacity-80">ID CARD</div>
                                </div>
                            </div>

                            <!-- Employee Info -->
                            <div class="space-y-1">
                                <div class="text-lg font-bold truncate">{{ $card->employee->name }}</div>
                                <div class="text-sm truncate opacity-90">{{ $card->employee->position }}</div>
                                <div class="text-xs truncate opacity-75">{{ $card->employee->department }}</div>
                            </div>

                            <!-- Serial Number -->
                            <div class="flex items-end justify-between">
                                <div class="text-xs opacity-75">{{ $card->serial_number }}</div>
                                <div class="text-xs opacity-75">{{ $card->issued_date->format('m/Y') }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card Back -->
                <div class="space-y-4">
                    <h3 class="text-lg font-medium text-gray-800">Verso do Cartão</h3>
                    <div class="relative overflow-hidden rounded-lg shadow-lg bg-gradient-to-br from-gray-600 to-gray-800"
                         style="width: 340px; height: 215px; margin: 0 auto;">

                        <!-- Background Design -->
                        @if($card->cardTemplate->back_design_url)
                            <img src="{{ $card->cardTemplate->back_design_url }}" class="absolute inset-0 object-cover w-full h-full">
                        @endif

                        <!-- Card Content -->
                        <div class="relative z-10 flex flex-col justify-between h-full p-4 text-white">
                            <div class="space-y-2 text-xs">
                                <div class="text-center opacity-90">
                                    <div class="font-medium">CARTÃO DE IDENTIFICAÇÃO</div>
                                    <div class="opacity-75">Este cartão é propriedade da empresa</div>
                                </div>
                            </div>

                            <div class="flex items-center justify-between">
                                <!-- QR Code -->
                                <div class="flex-shrink-0 p-2 bg-white rounded">
                                    @if($card->qr_code_url)
                                        <img src="{{ $card->qr_code_url }}" class="w-16 h-16">
                                    @else
                                        <div class="flex items-center justify-center w-16 h-16 text-xs text-gray-500 bg-gray-200">
                                            QR Code
                                        </div>
                                    @endif
                                </div>

                                <!-- Validity Info -->
                                <div class="space-y-1 text-xs text-right">
                                    <div class="opacity-75">Válido até:</div>
                                    <div class="font-medium">{{ $card->expiry_date->format('d/m/Y') }}</div>
                                    <div class="opacity-60 text-10px">Para verificar: escaneie o QR</div>
                                </div>
                            </div>

                            <!-- Footer -->
                            <div class="text-xs text-center opacity-60">
                                Em caso de perda, comunique imediatamente
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card Info -->
            <div class="grid grid-cols-1 gap-6 mt-8 md:grid-cols-3">
                <div class="p-4 rounded-lg bg-gray-50">
                    <dt class="text-sm font-medium text-gray-500">Template</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $card->cardTemplate->name }}</dd>
                </div>
                <div class="p-4 rounded-lg bg-gray-50">
                    <dt class="text-sm font-medium text-gray-500">Dimensões</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $card->cardTemplate->width }}mm × {{ $card->cardTemplate->height }}mm</dd>
                </div>
                <div class="p-4 rounded-lg bg-gray-50">
                    <dt class="text-sm font-medium text-gray-500">Status</dt>
                    <dd class="mt-1">
                        <span class="px-2 py-1 text-xs font-semibold rounded-full
                            @if($card->status === 'active') bg-green-100 text-green-800
                            @elseif($card->status === 'expired') bg-yellow-100 text-yellow-800
                            @else bg-red-100 text-red-800 @endif">
                            {{ ucfirst($card->status) }}
                        </span>
                    </dd>
                </div>
            </div>
        </div>
    </div>

    <!-- Print Instructions -->
    <div class="p-6 border border-blue-200 rounded-lg bg-blue-50">
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-blue-800">Instruções de Impressão</h3>
                <div class="mt-2 text-sm text-blue-700">
                    <ul class="space-y-1 list-disc list-inside">
                        <li>Use papel especial para cartões PVC ou papel fotográfico de alta qualidade</li>
                        <li>Configure a impressora para o tamanho {{ $card->cardTemplate->width }}mm × {{ $card->cardTemplate->height }}mm</li>
                        <li>Use qualidade de impressão máxima (1200 DPI ou superior)</li>
                        <li>Certifique-se de que as cores estão calibradas corretamente</li>
                        <li>Teste a impressão em papel comum primeiro</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Print functionality
function printCard() {
    window.print();
}

// Add print styles
const printStyles = `
<style media="print">
    body * { visibility: hidden; }
    .card-preview, .card-preview * { visibility: visible; }
    .card-preview { position: absolute; top: 0; left: 0; }
</style>
`;
document.head.insertAdjacentHTML('beforeend', printStyles);
</script>
@endpush
@endsection
