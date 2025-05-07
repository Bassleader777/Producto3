<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Vehículo</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>

<div class="editar-vehiculo-container">
    <h2 class="titulo-reservas">Editar Vehículo</h2>

    <!-- Mostrar errores de validación -->
    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>⚠ {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Mostrar mensaje de error o éxito -->
    @if (session('success'))
        <div style="color: green;">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div style="color: red;">{{ session('error') }}</div>
    @endif

    <form method="POST" action="{{ route('admin.vehiculos.actualizar') }}">
        @csrf

        <!-- ID del vehículo (solo lectura) -->
        <label for="id_vehiculo">ID Vehículo:</label>
        <input type="text" id="id_vehiculo" name="id_vehiculo" 
               value="{{ old('id_vehiculo', $vehiculo->id_vehiculo ?? '') }}" readonly>

        <label for="description">Descripción:</label>
        <input type="text" id="description" name="description" 
               value="{{ old('description', $vehiculo->description ?? '') }}" required>

        <label for="email_conductor">Email del conductor:</label>
        <input type="email" id="email_conductor" name="email_conductor" 
               value="{{ old('email_conductor', $vehiculo->email_conductor ?? '') }}" required>

        <label for="password">Nueva Contraseña (opcional):</label>
        <input type="password" id="password" name="password" placeholder="Dejar en blanco para mantener">

        <button type="submit">Actualizar Vehículo</button>
    </form>

    <div class="volver-menu" style="margin-top: 20px;">
        <a href="{{ route('vehiculo.listar') }}">← Volver a gestión de vehículos</a>
    </div>
</div>

</body>
</html>
