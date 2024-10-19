@extends('layouts.app')

@section('contenido')
    <form action="{{ route('user.store') }}" method="POST">
        @csrf
        <label for="name">Nombre de Usuario</label>
        <input type="text" name="name" id="name" value="{{ old('name') }}">
        @error('name')
            <div>
                {{ $message }}
            </div>
        @enderror

        <label for="email">Email</label>
        <input type="email" name="email" id="email" value="{{ old('email') }}">
        @error('email')
            <div>
                {{ $message }}
            </div>
        @enderror

        <label for="password">Contraseña</label>
        <input type="password" name="password" id="password">
        @error('password')
            <div>
                {{ $message }}
            </div>
        @enderror

        <label for="confirmed_password">Confirmación de Contraseña</label>
        <input type="password" name="confirmed_password" id="confirmed_password">
        @error('confirmed_password')
            <div>
                {{ $message }}
            </div>
        @enderror

        <button>Registrarse</button>
        <a href="{{ route('login') }}">Iniciar Sesión</a>
    </form>
@endsection
