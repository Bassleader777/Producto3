<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Vehículos</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>

<div class="gestion-vehiculos-container">
    <h2>Gestión de Vehículos</h2>

    <!-- Mensajes de éxito / error -->
    @if (session('success'))
        <div style="color: green; font-weight: bold;">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div style="color: red; font-weight: bold;">
            {{ session('error') }}
        </div>
    @endif

    <p><a href="{{ route('admin.vehiculos.crear.form') }}">+ Añadir nuevo vehículo</a></p>

    <table>
        <thead>
            <tr>
                <th>ID Vehículo</th>
                <th>Descripción</th>
                <th>Email Conductor</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @if (!empty($vehiculos) && count($vehiculos) > 0)
                @foreach ($vehiculos as $vehiculo)
                    <tr>
                        <td>{{ $vehiculo->id_vehiculo ?? 'No disponible' }}</td>
                        <td>{{ $vehiculo->description ?? 'No disponible' }}</td>
                        <td>{{ $vehiculo->email_conductor ?? 'No disponible' }}</td>
                        <td>
                            <a href="{{ route('admin.vehiculos.editar', ['id' => $vehiculo->id_vehiculo]) }}">Editar</a> |
                            <a href="{{ route('admin.vehiculos.eliminar', ['id' => $vehiculo->id_vehiculo]) }}"
                               onclick="return confirm('¿Deseas eliminar este vehículo?')">Eliminar</a>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr><td colspan="4">No hay vehículos registrados.</td></tr>
            @endif
        </tbody>
    </table>

    <div class="volver-panel" style="margin-top: 20px;">
        <a href="{{ route('admin.home') }}">← Volver al Panel de Administración</a>
    </div>
</div>

</body>
</html>
