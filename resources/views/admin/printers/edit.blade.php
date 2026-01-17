<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Editar Impresora</h2>
    </x-slot>
    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg p-6">
                <form method="POST" action="{{ route('admin.printers.update', $printer) }}" class="space-y-4">
                    @csrf
                    @method('PUT')
                    <input type="text" name="name" class="w-full border rounded p-2" value="{{ $printer->name }}" required>
                    <input type="text" name="ip" class="w-full border rounded p-2" value="{{ $printer->ip }}">
                    <input type="text" name="model" class="w-full border rounded p-2" value="{{ $printer->model }}">
                    <select name="status" class="w-full border rounded p-2">
                        @foreach(['online','offline','maintenance'] as $s)
                            <option value="{{ $s }}" @selected($printer->status===$s)>{{ $s }}</option>
                        @endforeach
                    </select>
                    <label class="flex items-center gap-2"><input type="checkbox" name="is_available" value="1" @checked($printer->is_available)> Disponible</label>
                    <label class="flex items-center gap-2"><input type="checkbox" name="color_support" value="1" @checked($printer->color_support)> Color</label>
                    <label class="flex items-center gap-2"><input type="checkbox" name="duplex_support" value="1" @checked($printer->duplex_support)> Dúplex</label>
                    <input type="number" min="1" max="10" name="priority" class="w-full border rounded p-2" value="{{ $printer->priority }}">
                    <div class="flex gap-3">
                        <a href="{{ route('admin.printers.index') }}" class="px-3 py-2 bg-gray-200 rounded">Cancelar</a>
                        <button class="px-3 py-2 bg-blue-600 text-white rounded">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

