<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear nuevo Vehículo</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>

    <form action="{{ route('admin.vehiculos.crear') }}" method="POST">
        @csrf

        <h2>Añadir nuevo vehículo</h2>
        

        <label for="description">Descripción del vehículo:</label>
        <input type="text" name="description" id="description" required>

        <label for="email_conductor">Email del conductor:</label>
        <input type="email" name="email_conductor" id="email_conductor" required>

        <label for="password">Contraseña del conductor:</label>
        <input type="password" name="password" id="password" required>

        <button type="submit">Añadir Vehículo</button>

        <div class="volver-menu">
            <a href="{{ route('vehiculo.listar') }}">← Volver a la gestión de vehículos</a>
        </div>
    </form>

</body>
</html>
