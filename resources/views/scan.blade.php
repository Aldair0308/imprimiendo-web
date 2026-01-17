<x-guest-layout maxWidth="sm:max-w-4xl">
    <div class="space-y-6">
        <div class="text-center space-y-2">
            <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Imprimeindo</h1>
            <p class="text-lg text-gray-600">Interfaz de Impresión Inteligente</p>
        </div>

        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-2 sm:p-6">
            @livewire('print-job-configurator')
        </div>

        <div class="text-center">
            <p class="text-sm text-gray-400">
                Sesión segura activa. Los archivos se eliminan después de la impresión.
            </p>
        </div>
    </div>
</x-guest-layout>
