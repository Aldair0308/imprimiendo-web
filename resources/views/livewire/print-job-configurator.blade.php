<div class="space-y-6">
    @if (session()->has('message'))
        <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
            {{ session('message') }}
        </div>
    @endif

    <div
        class="grid grid-cols-1 md:grid-cols-2 gap-6"
        x-data="{
            localPreviewUrl: null,
            colorMode: '{{ $colorMode }}',
            handleFileChange(e) {
                const file = e.target.files?.[0];
                if (!file || file.type !== 'application/pdf') return;

                if (this.localPreviewUrl) URL.revokeObjectURL(this.localPreviewUrl);
                this.localPreviewUrl = URL.createObjectURL(file);
            },
            init() {
                // Listen for color mode changes from Livewire
                window.addEventListener('color-mode-changed', (event) => {
                    this.colorMode = event.detail.colorMode;
                });
            }
        }"
        x-on:color-mode-changed.window="colorMode = $event.detail.colorMode"
    >
        <!-- Panel de Configuración -->
        <div class="space-y-6 bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <h2 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
                </svg>
                Configuración de Impresión
            </h2>

            <div class="space-y-4">
                <!-- Subida de Archivo -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Archivo PDF</label>
                    <div class="relative group">
                        <input type="file" wire:model="pdfFile" @change="handleFileChange($event)" accept="application/pdf"
                            class="block w-full text-sm text-gray-500
                            file:mr-4 file:py-2.5 file:px-4
                            file:rounded-lg file:border-0
                            file:text-sm file:font-bold
                            file:bg-blue-50 file:text-blue-700
                            hover:file:bg-blue-100
                            border border-gray-200 rounded-lg cursor-pointer focus:outline-none transition-all">
                        <div wire:loading wire:target="pdfFile" class="mt-2 text-xs text-blue-600 animate-pulse">
                            Procesando archivo...
                        </div>
                        @if($pdfFile)
                            <div class="mt-2 text-xs text-green-600 flex items-center gap-1">
                                ✓ Archivo seleccionado: {{ $pdfFile->getClientOriginalName() }}
                            </div>
                        @endif
                    </div>
                    @error('pdfFile') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- Opciones de Color -->
                <div class="space-y-2">
                     <label class="block text-sm font-semibold text-gray-700">Modo de Color</label>
                     <select wire:model="colorMode"
                             x-model="colorMode"
                             class="w-full border-gray-200 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm">
                         <option value="1">Color</option>
                         <option value="0">Blanco y Negro</option>
                     </select>
                </div>

                <!-- Selección de Páginas -->
                @if($pdfFile)
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700">Páginas a imprimir</label>
                    <input type="text" wire:model.live="selectedPages" placeholder="ej: 1-3,5 o dejar vacío para todas"
                           class="w-full border-gray-200 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm px-3 py-2">
                    <p class="text-xs text-gray-500">Deja vacío para imprimir todas las páginas o especifica rangos separados por comas (ej: 1-3,5)</p>
                </div>
                @endif
            </div>

            <!-- Información de páginas -->
            @if($pdfFile)
                <div class="p-4 bg-blue-50 rounded-lg border border-blue-200">
                    <div class="text-sm font-medium text-blue-800 mb-3">
                        📄 Información del documento
                    </div>
                    <div class="space-y-2">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Total de páginas:</span>
                            <div class="flex items-center gap-2">
                                @if($totalPages > 0)
                                    <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-bold">
                                        {{ $totalPages }}
                                    </span>
                                @else
                                    <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-bold">
                                        Contando...
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Páginas a imprimir:</span>
                            <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold">
                                {{ $pagesToPrint > 0 ? $pagesToPrint : 0 }}
                            </span>
                        </div>
                    </div>
                </div>
            @endif

            <button wire:click="submit" class="w-full py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl shadow-lg shadow-blue-200 transition-all transform hover:-translate-y-0.5 active:translate-y-0 flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                </svg>
                Enviar a Impresión
            </button>
        </div>

        <!-- Panel de Vista Previa -->
        <div class="bg-gray-50 p-6 rounded-xl border border-dashed border-gray-300 flex flex-col items-center justify-center min-h-[400px]">
            <div x-show="localPreviewUrl" x-cloak class="w-full h-full flex flex-col items-center">
                <div class="flex items-center justify-between w-full mb-4">
                    <h3 class="text-lg font-bold text-gray-800">Vista Previa</h3>
                    <div class="flex gap-2 flex-wrap">
                        <span class="px-3 py-1 bg-purple-100 text-purple-700 rounded-full text-xs font-medium">Total: {{ $totalPages }} páginas</span>
                        <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-medium">A imprimir: {{ $pagesToPrint }} páginas</span>
                         <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-medium" x-text="'Modo: ' + (colorMode === '1' ? 'Color' : 'Blanco y Negro')">Modo: {{ $colorMode == '1' ? 'Color' : 'Blanco y Negro' }}</span>
                    </div>
                </div>

                <div class="relative w-full bg-white shadow-2xl rounded-lg overflow-hidden border border-gray-200 transition-all duration-300">
                    <iframe x-bind:src="localPreviewUrl ? (localPreviewUrl + '#toolbar=0&navpanes=0&scrollbar=0') : 'about:blank'"
                            class="w-full h-[600px] border-none transition-all duration-300"
                            x-bind:class="colorMode === '0' ? 'preview-grayscale' : ''"
                            x-bind:style="colorMode === '0' ? 'filter: grayscale(100%); -webkit-filter: grayscale(100%);' : ''"
                            title="Vista Previa PDF"></iframe>
                </div>

                <p class="mt-4 text-sm text-gray-500 italic text-center">
                    * La vista previa es una representación aproximada. La configuración de páginas se aplicará al imprimir.
                </p>
            </div>
            <div x-show="!localPreviewUrl" x-cloak class="text-center space-y-4">
                <div class="w-20 h-20 bg-gray-200 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <p class="text-gray-500 font-medium">Sube un PDF para ver la previsualización</p>
                <p class="text-xs text-gray-400">Podrás configurar el color, copias y páginas</p>
            </div>
        </div>
    </div>

    <style>
        [x-cloak] { display: none !important; }
        .preview-grayscale {
            filter: grayscale(100%) !important;
            -webkit-filter: grayscale(100%) !important;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fadeIn {
            animation: fadeIn 0.3s ease-out forwards;
        }
    </style>
</div>