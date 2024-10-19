{{-- Verificamos si hay mensajes de éxito --}}
@if (session()->has('success'))
    <div style="color: green;">
        {{ session('success') }}
    </div>
@endif

{{-- Verificamos si hay mensajes de error --}}
@if (session()->has('error'))
    <div style="color: red;">
        {{ session('error') }}
    </div>
@endif
