<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Panel Administrativo
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="p-6 bg-white shadow rounded">
                    <p class="text-sm text-gray-500">Impresoras Online</p>
                    <p class="text-2xl font-bold">{{ $stats['printers_online'] }}</p>
                </div>
                <div class="p-6 bg-white shadow rounded">
                    <p class="text-sm text-gray-500">Impresoras Offline</p>
                    <p class="text-2xl font-bold">{{ $stats['printers_offline'] }}</p>
                </div>
                <div class="p-6 bg-white shadow rounded">
                    <p class="text-sm text-gray-500">Trabajos en cola</p>
                    <p class="text-2xl font-bold">{{ $stats['jobs_queued'] }}</p>
                </div>
                <div class="p-6 bg-white shadow rounded">
                    <p class="text-sm text-gray-500">Imprimiendo</p>
                    <p class="text-2xl font-bold">{{ $stats['jobs_printing'] }}</p>
                </div>
                <div class="p-6 bg-white shadow rounded">
                    <p class="text-sm text-gray-500">Completados</p>
                    <p class="text-2xl font-bold">{{ $stats['jobs_done'] }}</p>
                </div>
                <div class="p-6 bg-white shadow rounded">
                    <p class="text-sm text-gray-500">Errores</p>
                    <p class="text-2xl font-bold">{{ $stats['jobs_error'] }}</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

