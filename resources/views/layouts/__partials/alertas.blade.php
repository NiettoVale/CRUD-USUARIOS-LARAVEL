{{-- Verificamos si hay mensajes de éxito --}}
@if (session()->has('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: '¡Éxito!',
            text: '{{ session('success') }}',
            showConfirmButton: true,
            timer: 3000
        });
    </script>
@endif

{{-- Verificamos si hay mensajes de error --}}
@if (session()->has('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: '¡Error!',
            text: '{{ session('error') }}',
            showConfirmButton: true,
            timer: 3000
        });
    </script>
@endif
