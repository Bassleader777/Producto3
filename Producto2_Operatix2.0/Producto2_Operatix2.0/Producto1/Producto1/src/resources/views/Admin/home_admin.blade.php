<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Administración</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>

    <div class="panel-container">
        <h2>Bienvenido al Panel de Administración</h2>
        <p>Desde este panel, el administrador puede gestionar todas las reservas, usuarios y otros aspectos del sistema.</p>

        <ul class="panel-links">
            <li><a href="{{ route('admin.reservas.calendario') }}">📅 Ver Calendario de Reservas</a></li>
            <li><a href="{{ url('/admin/reservas/crear') }}">➕ Crear Nueva Reserva</a></li>
            <li><a href="{{ url('/admin/usuarios') }}">👥 Gestionar Usuarios</a></li>
            <li><a href="{{ url('/admin/hoteles') }}">🏨 Gestionar Hoteles</a></li>
            <li><a href="{{ url('/admin/vehiculos') }}">🚗 Gestionar Vehículos</a></li>
            <li><a href="{{ url('/admin/reportes') }}">📊 Ver Reportes de Actividad</a></li>
            <li><a href="{{ url('/admin/corporativos/crear') }}">🏢 Registrar Usuario Corporativo</a></li>
            <li><a href="{{ url('/admin/comisiones') }}">💰 Ver Resumen de Comisiones</a></li>


        </ul>

        <div class="volver-menu">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit">← Cerrar sesión</button>
            </form>
        </div>
    </div>

</body>
</html>
