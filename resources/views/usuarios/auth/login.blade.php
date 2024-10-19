@extends('layouts.app')

@section('contenido')
    <form action="" method="POST">
        @csrf

        <label for="email">Email:</label>
        <input type="text" name="email" id="email">
        @error('email')
            <div style="color: red;">{{ $message }}</div>
        @enderror

        <label for="password">Contraseña:</label>
        <input type="password" name="password" id="password">
        @error('password')
            <div style="color: red;">{{ $message }}</div>
        @enderror

        <button>Iniciar Sesión</button>
        <a href="{{ route('user.formulario_registro') }}">Registrarse</a>
    </form>
@endsection
