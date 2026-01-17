<x-guest-layout>
    <div class="space-y-6">
        <h1 class="text-xl font-semibold">Imprimeindo</h1>
        <p class="text-gray-600">Escanea el código QR para iniciar tu sesión y subir archivos.</p>

        <div x-data="{ token: '{{ $session->token }}', expiresAt: '{{ $session->expires_at->toIso8601String() }}' }" class="space-y-4">
            <div class="p-4 border rounded bg-white flex flex-col items-center">
                <p class="text-sm text-gray-500 mb-2">Código QR de sesión:</p>
                <div class="mb-4">
                    {!! QrCode::size(200)->generate(config('app.url') . '/scan/' . $session->token) !!}
                </div>
                <p class="text-sm text-gray-500">Token de sesión QR:</p>
                <code class="text-xs break-all block mt-1" x-text="token"></code>
                <p class="text-sm text-gray-500 mt-2">Expira: <span x-text="new Date(expiresAt).toLocaleString()"></span></p>
            </div>

            <form id="upload-form" method="POST" action="#" enctype="multipart/form-data" class="p-4 border rounded bg-white">
                <p class="text-sm font-medium mb-2">Selecciona archivos para imprimir</p>
                <input type="file" name="files[]" multiple class="mb-3">
                <div class="grid grid-cols-2 gap-4">
                    <label class="flex items-center gap-2"><input type="checkbox" name="options[color]" checked> Color</label>
                    <label class="flex items-center gap-2"><input type="checkbox" name="options[duplex]"> Dúplex</label>
                </div>
                <button type="button" class="mt-3 inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded" x-on:click="alert('Subida simulada')">Enviar</button>
            </form>

            <div class="flex items-center gap-3">
                <button type="button" class="px-3 py-2 bg-gray-800 text-white rounded"
                        x-on:click="fetch('{{ route('qr.refresh') }}', { method: 'POST', headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' } }) .then(r => r.json()).then(d => { token = d.token; expiresAt = d.expires_at; })">
                    Renovar QR
                </button>
                <button type="button" class="px-3 py-2 bg-green-600 text-white rounded"
                        x-on:click="fetch('{{ route('qr.validate') }}', { method: 'POST', headers: { 'Content-Type':'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' }, body: JSON.stringify({ token }) }) .then(r => r.json()).then(d => alert(d.valid ? 'Token válido' : 'Token inválido'))">
                    Validar QR
                </button>
            </div>
        </div>
    </div>
</x-guest-layout>

