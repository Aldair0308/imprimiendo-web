<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Impresoras</h2>
            <a href="{{ route('admin.printers.create') }}" class="px-3 py-2 bg-blue-600 text-white rounded">Agregar</a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg p-6">
                <table class="min-w-full">
                    <thead>
                        <tr class="text-left">
                            <th class="py-2">Nombre</th>
                            <th class="py-2">IP</th>
                            <th class="py-2">Modelo</th>
                            <th class="py-2">Estado</th>
                            <th class="py-2">Disponible</th>
                            <th class="py-2">Prioridad</th>
                            <th class="py-2">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($printers as $printer)
                            <tr class="border-t">
                                <td class="py-2">{{ $printer->name }}</td>
                                <td class="py-2">{{ $printer->ip }}</td>
                                <td class="py-2">{{ $printer->model }}</td>
                                <td class="py-2">{{ $printer->status }}</td>
                                <td class="py-2">{{ $printer->is_available ? 'Sí' : 'No' }}</td>
                                <td class="py-2">{{ $printer->priority }}</td>
                                <td class="py-2">
                                    <a href="{{ route('admin.printers.edit', $printer) }}" class="px-2 py-1 bg-gray-800 text-white rounded">Editar</a>
                                    <form action="{{ route('admin.printers.destroy', $printer) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="px-2 py-1 bg-red-600 text-white rounded">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>

