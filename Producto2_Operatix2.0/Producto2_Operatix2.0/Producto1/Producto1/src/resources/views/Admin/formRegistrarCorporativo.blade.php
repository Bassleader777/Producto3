<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Usuario Corporativo</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>

<div class="registro-container">
    

    @if (session('success'))
        <div class="mensaje-exito">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="mensaje-error">{{ session('error') }}</div>
    @endif

    <form method="POST" action="{{ route('admin.corporativos.store') }}">
    <h2 class="titulo-registro">➕ Registrar Usuario Corporativo</h2>
    @csrf

    <label for="nombre">Nombre del Responsable:</label>
    <input type="text" id="nombre" name="nombre" value="{{ old('nombre') }}" required>

    <label for="apellido1">Primer Apellido:</label>
    <input type="text" id="apellido1" name="apellido1" value="{{ old('apellido1') }}" required>

    <label for="apellido2">Segundo Apellido:</label>
    <input type="text" id="apellido2" name="apellido2" value="{{ old('apellido2') }}" required>

    <label for="direccion">Dirección:</label>
    <input type="text" id="direccion" name="direccion" value="{{ old('direccion') }}" required>

    <label for="codigoPostal">Código Postal:</label>
    <input type="text" id="codigoPostal" name="codigoPostal" value="{{ old('codigoPostal') }}" required>

    <label for="ciudad">Ciudad:</label>
    <input type="text" id="ciudad" name="ciudad" value="{{ old('ciudad') }}" required>

    <label for="pais">País:</label>
    <input type="text" id="pais" name="pais" value="{{ old('pais') }}" required>

    <label for="email">Email Corporativo:</label>
    <input type="email" id="email" name="email" value="{{ old('email') }}" required>

    <label for="password">Contraseña:</label>
    <input type="password" id="password" name="password" required>

    <label for="password_confirmation">Confirmar Contraseña:</label>
    <input type="password" id="password_confirmation" name="password_confirmation" required>

    <button type="submit">Registrar Usuario Corporativo</button>

    <div class="volver-menu">
        <a href="{{ route('admin.home') }}">← Volver al Panel de Administración</a>
    </div>
</form>


    
</div>

</body>
</html>
