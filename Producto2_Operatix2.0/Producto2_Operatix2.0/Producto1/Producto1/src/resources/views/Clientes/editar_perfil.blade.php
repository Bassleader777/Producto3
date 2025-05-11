<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Perfil</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>

<div class="login-container">

    {{-- Mensaje de éxito --}}
    @if (session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    {{-- Errores de validación --}}
    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>⚠️ {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('cliente.perfil.actualizar') }}" method="POST">
        <h2>Editar Perfil</h2>
        @csrf

        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" value="{{ old('nombre', $cliente->nombre) }}" required>

        <label for="apellido1">Primer Apellido:</label>
        <input type="text" id="apellido1" name="apellido1" value="{{ old('apellido1', $cliente->apellido1) }}" required>

        <label for="email">Correo electrónico:</label>
        <input type="email" id="email" name="email" value="{{ old('email', $cliente->email) }}" required>

        <label for="password">Nueva contraseña:</label>
        <input type="password" id="password" name="password">

        <label for="password_confirmation">Confirmar contraseña:</label>
        <input type="password" id="password_confirmation" name="password_confirmation">

        <button type="submit">Guardar Cambios</button>

        <div class="volver-menu">
            <a href="{{ route('cliente.home') }}">← Volver al panel</a>
        </div>
    </form>
</div>

</body>
</html>
