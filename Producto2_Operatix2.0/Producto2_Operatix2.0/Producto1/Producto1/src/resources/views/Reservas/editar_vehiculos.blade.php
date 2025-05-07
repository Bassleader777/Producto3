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

    <form method="POST" action="{{ route('admin.vehiculos.actualizar') }}">
        @csrf

        <label for="id_vehiculo">ID Vehículo:</label>
        <input type="text" id="id_vehiculo" name="id_vehiculo" 
               value="{{ old('id_vehiculo', $vehiculo['id_vehiculo'] ?? '') }}" required>

        <label for="description">Descripción:</label>
        <input type="text" id="description" name="description" 
               value="{{ old('description', $vehiculo['description'] ?? '') }}" required>

        <label for="email_conductor">Email del conductor:</label>
        <input type="email" id="email_conductor" name="email_conductor" 
               value="{{ old('email_conductor', $vehiculo['email_conductor'] ?? '') }}" required>

        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password" 
               value="{{ old('password', $vehiculo['password'] ?? '') }}" required>

        <button type="submit">Actualizar Vehículo</button>
    </form>

    <div class="volver-menu">
        <a href="{{ route('admin.vehiculos.index') }}">← Volver a gestión de vehículos</a>
    </div>
</div>

</body>
</html>
