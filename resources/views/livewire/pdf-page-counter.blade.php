<!-- Contador de Páginas -->
<div class="p-4 bg-blue-50 rounded-lg border border-blue-200">
    <div class="flex items-center justify-between">
        <div class="text-sm font-medium text-blue-800">
            📄 Información del documento
        </div>
    </div>
    
    @if($pdfFile)
        <div class="mt-3 space-y-2">
            <div class="flex justify-between items-center">
                <span class="text-sm text-gray-600">Total de páginas:</span>
                <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-bold">
                    {{ $totalPages }}
                </span>
            </div>
            
            <div class="flex justify-between items-center">
                <span class="text-sm text-gray-600">Páginas a imprimir:</span>
                <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold">
                    {{ $pagesToPrint }}
                </span>
            </div>
        </div>
    @else
        <p class="text-sm text-gray-500 mt-2">Sube un archivo PDF para ver información</p>
    @endif
</div>